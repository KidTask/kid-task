<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\Task;
use Club\KidTask\Kid;
use Club\KidTask\Adult;

/**
 * api for the Task class
 *
 * @author Jacob Lott <jlott3@cnm.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

    $secrets = new \Secrets("/etc/apache2/capstone-mysql/kidtask.ini");
    $pdo = $secrets->getPdoObject();



    //determine which HTTP method was used
    $method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

    //sanitize input

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $taskAdultId = filter_input(INPUT_GET, "task adult id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $taskKidId = filter_input(INPUT_GET, "task kid id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $taskContent = filter_input(INPUT_GET, "taskContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    //make sure the id is valid for methods that require it
    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
        throw(new InvalidArgumentException("id cannot be empty or negative", 402));
    }


    // handle GET request - if id is present, that task is returned, otherwise all tasks are returned
    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        //get a specific task or all tasks and update reply
        if(empty($id) === false) {
            $reply->data = Task::getTaskByTaskId($pdo, $id);

        } else if(empty($taskAdultId) === false) {
            // if the user is logged in grab all the tasks by that user based  on who is logged in
            $reply->data = Task::getTaskByTaskAdultId($pdo, $taskAdultId)->toArray();

        } else if(empty($taskKidId) === false) {
            // if the user is logged in grab all the tasks by that user based  on who is logged in
            $reply->data = Task::getTaskByTaskKidId($pdo, $taskKidId)->toArray();

        } else if(empty($taskContent) === false) {
            $reply->data = Task::getTaskByTaskContent($pdo, $taskContent)->toArray();

        } else {
            $tasks = Task::getAllTasks($pdo)->toArray();
            $taskProfiles = [];
            foreach($tasks as $task){
                $adult = 	Adult::getAdultByAdultId($pdo, $task->getTaskAdultId());
                $kid =      Kid::getKidByKidId($pdo, $task->getTaskKidId());
                $taskProfiles[] = (object)[
                    "taskId"=>$task->getTaskId(),
                    "taskAdultId"=>$task->getTaskAdultId(),
                    "taskContent"=>$task->getTaskContent(),
                    "taskDate"=>$task->getTaskDate()->format("U.u") * 1000,
                    "adultAvatarUrl"=>$adult->getAdultAvatarUrl(),
                    "kidAvatarUrl"=>$kid->getKidAvatarUrl(),
                ];
            }
            $reply->data = $taskProfiles;
        }
    } else if($method === "PUT" || $method === "POST") {
        // enforce the user has a XSRF token
        verifyXsrf();

        // enforce the user is signed in
        if(empty($_SESSION["adult"]) === true) {
            throw(new \InvalidArgumentException("you must be logged in to post tasks", 401));
        }

        $requestContent = file_get_contents("php://input");


        // Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
        $requestObject = json_decode($requestContent);

        // This Line Then decodes the JSON package and stores that result in $requestObject
        //make sure task content is available (required field)
        if(empty($requestObject->taskContent) === true) {
            throw(new \InvalidArgumentException ("No content for Task.", 405));
        }
        $requestObject->foo; //value:bar
        // make sure ask date is accurate (optional field)
        if(empty($requestObject->taskDate) === true) {
            $requestObject->taskDate = null;
        }

        //perform the actual put or post
        if($method === "PUT") {

            // retrieve the task to update
            $task = Task::getTaskByTaskId($pdo, $id);
            if($task === null) {
                throw(new RuntimeException("Task does not exist", 404));
            }

            //enforce the end user has a JWT token


            //enforce the user is signed in and only trying to edit their own task
            if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $task->getTaskAdultId()->toString()) {
                throw(new \InvalidArgumentException("You are not allowed to edit this task", 403));
            }

            validateJwtHeader();

            // update all attributes
            //$task->setTaskDate($requestObject->taskDate);
            $task->setTaskContent($requestObject->taskContent);
            $task->update($pdo);

            // update reply
            $reply->message = "Task updated OK";

        } else if($method === "POST") {

            // enforce the user is signed in
            if(empty($_SESSION["adult"]) === true) {
                throw(new \InvalidArgumentException("you must be logged in to post tasks", 403));
            }

            //enforce the end user has a JWT token
            validateJwtHeader();

            // create new task and insert into the database
            $task = new Task(generateUuidV4(), $_SESSION["adult"]->getAdultId(), $requestObject->taskContent, $requestObject->taskAdultAvatarUrl, $requestObject->taskCloudinaryToken, $requestObject->taskContent, $requestObject->taskDueDate, $requestObject->taskIsComplete, $requestObject->taskReward);
            $task->insert($pdo);

            // update reply
            $reply->message = "Task created OK";
        }

    } else if($method === "DELETE") {

        //enforce that the end user has a XSRF token.
        verifyXsrf();

        // retrieve the Task to be deleted
        $task = Task::getTaskByTaskId($pdo, $id);
        if($task === null) {
            throw(new RuntimeException("Task does not exist", 404));
        }

        //enforce the user is signed in and only trying to edit their own task
        if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $task->getTaskAdultId()->toString()) {
            throw(new \InvalidArgumentException("You are not allowed to delete this task", 403));
        }

        //enforce the end user has a JWT token
        validateJwtHeader();

        // delete task
        $task->delete($pdo);
        // update reply
        $reply->message = "Task deleted OK";
    } else {
        throw (new InvalidArgumentException("Invalid HTTP method request", 418));
    }
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);