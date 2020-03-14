<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\Task;
use Club\KidTask\Step;
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
    $taskAdultId = filter_input(INPUT_GET, "taskAdultId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $taskKidId = filter_input(INPUT_GET, "taskKidId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
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
            // if the user is logged in grab all the tasks by that user based on who is logged in
            $reply->data = Task::getTaskByTaskAdultId($pdo, $taskAdultId)->toArray();

        } else if(empty($taskKidId) === false) {
            // if the user is logged in grab all the tasks by that user based on who is logged in
            $reply->data = Task::getTaskByTaskKidId($pdo, $taskKidId)->toArray();

        } else if(empty($taskContent) === false) {
            $reply->data = Task::getTaskByTaskContent($pdo, $taskContent)->toArray();

        }
    } else if($method === "PUT" || $method === "POST") {
        //enforce that the XSRF token is present in the header
        verifyXsrf();

        //enforce the user is signed in and only trying to edit their own profile
       /* if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $kid->getKidAdultId()->toString()) {
            throw(new \InvalidArgumentException("You are not allowed to access this profile son", 403));
        }*/

        $requestContent = file_get_contents("php://input");


        // Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
        $requestObject = json_decode($requestContent);

        // This Line Then decodes the JSON package and stores that result in $requestObject
        //make sure task content is available (required field)
        if(empty($requestObject->taskContent) === true) {
            throw(new \InvalidArgumentException ("No content for Task.", 405));
        }

        if(empty($requestObject->taskKidId) === true) {
            throw(new \InvalidArgumentException ("Select a Kid.", 405));
        }

        if(empty($requestObject->taskAvatarUrl) === true) {
            $requestObject->taskAvatarUrl = null;
        }

        if(empty($requestObject->taskCloudinaryToken) === true) {
            $requestObject->taskCloudinaryToken = null;
        }

        if(empty($requestObject->taskDueDate) === true) {
            $requestObject->taskDueDate = null;
        }

        if(empty($requestObject->taskReward) === true) {
            $requestObject->taskReward = null;
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

            $taskId = generateUuidV4();

            // create new task and insert into the database
            $task = new Task($taskId, $_SESSION["adult"]->getAdultId(), $requestObject->taskKidId, $requestObject->taskAvatarUrl, $requestObject->taskCloudinaryToken, $requestObject->taskContent, $requestObject->taskDueDate, 0, $requestObject->taskReward);
            $task->insert($pdo);

            // update reply
            $reply->message = "Task created OK";

			  // create new step and insert into the database
			  $index = 0;
			  foreach($requestObject->steps as $key => $value) {
				  if(empty($value) === true) {
					  throw(new \InvalidArgumentException("content is empty"));
				  }
				  if ($key === "stepContent") {
			  			$index++;
				  }
				  $step = new Step(generateUuidV4(), $taskId, $value, $index);
				  $step->insert($pdo);
			  }

			  // update reply
			  $reply->message = "Step created OK";
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