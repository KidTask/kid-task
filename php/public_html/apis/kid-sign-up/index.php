<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\{Adult, Kid};

/**
 * api for the KidTask class
 *
 * @author Gabriel Town <rieltown@gmail.com>
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


	if($method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["adult"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to create kids", 401));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		$requestContent = file_get_contents("php://input");

		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);


		//kid-account username is a required field
		if(empty($requestObject->kidUsername) === true) {
			throw(new \InvalidArgumentException ("Must input valid username or password", 405));
		}

		//verify that kid-account password is present
		if(empty($requestObject->kidPassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid username or password", 405));
		}

		//verify that the confirm password is present
		if(empty($requestObject->kidPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid username or password", 405));
		}


		$hash = password_hash($requestObject->kidPassword, PASSWORD_ARGON2I, ["time_cost" => 32]);


		//make sure name is valid (optional field)
		if (empty($requestObject->kidName) === true) {
			$requestObject->kidName = null;
		}

		//make sure cloudinary token is valid (optional field)
		if (empty($requestObject->kidCloudinaryToken) === true) {
			$requestObject->kidCloudinaryToken = null;
		}

		//make sure Avatar Url is valid (optional field)
		if (empty($requestObject->kidAvatarUrl) === true) {
			$requestObject->kidAvatarUrl = null;
		}

		$kid = new Kid(generateUuidV4(), getKidAdultId(), $requestObject->kidAvatarUrl, $requestObject->kidCloudinaryToken, $hash, $requestObject->kidName, $requestObject->kidUsername);
		$kid->insert($pdo);

		// insert reply
		$reply->message = "Kid created OK";

	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}
} catch(\Exception |\TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}

header("Content-type: application/json");
echo json_encode($reply);
