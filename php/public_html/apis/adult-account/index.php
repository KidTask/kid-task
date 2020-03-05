<?php


require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\Adult;

/**
 * API for adult-account
 *
 * @author demetria
 * @version 1.0
 */

//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/kidtask.ini");
	$pdo = $secrets->getPdoObject();
	//$cloudinary = $secrets->getSecret("cloudinary");


	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a adult
		if(empty($id) === false) {
			$reply->data = Adult::getAdultByAdultId($pdo, $id);
		}

	} elseif($method === "PUT") {

		//enforce that the XSRF token is present in the header
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();





		validateJwtHeader();

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the adult account to be updated
		$adult = Adult::getAdultByAdultId($pdo, $id);
		if($adult === null) {
			throw(new RuntimeException("Adult account does not exist", 404));
		}

		//  	//enforce the user is signed in and only trying to edit their own account
		if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $adult->getAdultId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this account", 403));
		}

		//adult email is a required field
		if(empty($requestObject->adultEmail) === true) {
			$requestObject->adultEmail = $adult->getAdultEmail();
		}
		//make sure avatar url is valid (optional field)
		if (empty($requestObject->adultAvatarUrl) === true) {
			$requestObject->adultAvatarUrl = $adult->getAdultAvatarUrl();
		}



		//make sure name is valid (optional field)
		if (empty($requestObject->adultName) === true) {
			$requestObject->adultName = $adult->getAdultName();
		}


		$adult->setAdultAvatarUrl($requestObject->adultAvatarUrl);
		$adult->setAdultEmail($requestObject->adultEmail);
		$adult->setAdultName($requestObject->adultName);
		$adult->update($pdo);

		// update reply
		$reply->message = "Adult account information updated";


	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch
(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);