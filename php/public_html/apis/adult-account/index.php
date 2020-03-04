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


	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$adultUsername = filter_input(INPUT_GET, "adultUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$adultEmail = filter_input(INPUT_GET, "adultEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);



	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a post by content
		if(empty($id) === false) {
			$reply->data = Adult::getAdultByAdultId($pdo, $id);

		} else if(empty($adultUsername) === false) {
			$reply->data = Adult::getAdultByAdultUsername($pdo, $adultUsername);

		} else if(empty($adultEmail) === false) {

			$reply->data = Adult::getAdultbyAdultEmail($pdo, $adultEmail);
		}

	} elseif($method === "PUT") {

		//enforce that the XSRF token is present in the header
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();

		//enforce the user is signed in and only trying to edit their own account
		if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this adult", 403));
		}

		validateJwtHeader();

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the adult account to be updated
		$adult = Adult::getAdultByAdultId($pdo, $id);
		if($adult === null) {
			throw(new RuntimeException("Adult account does not exist", 404));
		}


		//adult username
		if(empty($requestObject->adultUsername) === true) {
			throw(new \InvalidArgumentException ("No adult username", 405));
		}

		//adult email is a required field
		if(empty($requestObject->adultEmail) === true) {
			throw(new \InvalidArgumentException ("No adult email present", 405));
		}




		$adult->setAdultUsername($requestObject->adultUsername);
		$adult->setAdultEmail($requestObject->adultEmail);
		$adult->update($pdo);

		// update reply
		$reply->message = "Adult account information updated";


	} elseif($method === "DELETE") {

		//verify the XSRF Token
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();

		$adult = Adult::getAdultByAdultId($pdo, $id);
		if($adult === null) {
			throw (new RuntimeException("Profile does not exist"));
		}

		//enforce the user is signed in and only trying to edit their own adult
		if(empty($_SESSION["adult"]) === true || $_SESSION["adult"]->getAdultId()->toString() !== $adult->getAdultId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this adult account", 403));
		}

		validateJwtHeader();

		//delete the post from the database
		$adult->delete($pdo);
		$reply->message = "Adult Account Deleted";

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