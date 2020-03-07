<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\{
	Adult, Kid, Task, Step
};


/**
 * api for the Step class
 *
 * @author Demetria
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
	$stepTaskId = filter_input(INPUT_GET, "stepTaskId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$stepContent = filter_input(INPUT_GET, "stepContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}


	// handle GET request - if id is present, that step is returned, otherwise all steps are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific step or all steps and update reply
		if(empty($id) === false) {
			$reply->data = Step::getStepByStepId($pdo, $id);

		} else if(empty($stepTaskId) === false) {
			// if the user is logged in grab all the steps by that user based  on who is logged in
			$reply->data = Step::getStepByStepTaskId($pdo, $stepTaskId)->toArray();

		}

	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["adult"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post steps", 401));
		}

		$requestContent = file_get_contents("php://input");


		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure step content is available (required field)
		if(empty($requestObject->stepContent) === true) {
			throw(new \InvalidArgumentException ("No content for Step.", 405));
		}


		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the step to update
			$step = Step::getStepByStepId($pdo, $id);
			if($step === null) {
				throw(new RuntimeException("Step does not exist", 404));
			}

			//enforce the end user has a JWT token


			//enforce the user is signed in and only trying to edit their own step
			if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $step->getStepTaskId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this step", 403));
			}

			validateJwtHeader();

			// update all attributes

			$step->setStepContent($requestObject->stepContent);
			$step->update($pdo);

			// update reply
			$reply->message = "Step updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["adult"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post steps", 403));
			}

			//enforce the end user has a JWT token
			validateJwtHeader();

			// create new step and insert into the database
			$step = new Step(generateUuidV4(), $_SESSION["adult"]->getAdultId(), $requestObject->stepContent, null);
			$step->insert($pdo);

			// update reply
			$reply->message = "Step created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Step to be deleted
		$step = Step::getStepByStepId($pdo, $id);
		if($step === null) {
			throw(new RuntimeException("Step does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own step
		if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $step->getStepTaskId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this step", 403));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// delete step
		$step->delete($pdo);
		// update reply
		$reply->message = "Step deleted OK";
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