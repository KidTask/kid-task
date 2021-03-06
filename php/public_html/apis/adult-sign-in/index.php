<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");


use Club\KidTask\Adult;

/**
 * api for signing in to Kid Task as an Adult
 *
 * @author Jacob Lott jlott3@cnm.edu
 */

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab mySQL statement
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/kidtask.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//If method is post handle the sign in logic
	if($method === "POST") {

		//make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and username field is not empty.s
		if(empty($requestObject->adultUsername) === true) {
			throw(new\InvalidArgumentException("username not provided.", 401));
		} else {
			$adultUsername = filter_var($requestObject->adultUsername, FILTER_SANITIZE_STRING);
		}

		if(empty($requestObject->adultPassword) === true) {
			throw(new \InvalidArgumentException("Must enter a password.", 401));
		} else {
			$adultPassword = $requestObject->adultPassword;
		}

		//grab the adult from the database by the username provided
		$adult = Adult::getAdultByAdultUsername($pdo, $adultUsername);
		if(empty($adult) === true) {
			throw (new \InvalidArgumentException("Invalid Username", 401));
		}
		$adult->setAdultActivationToken(null);
		$adult->update($pdo);

		//verify hash is correct
		if(password_verify($requestObject->adultPassword, $adult->getAdultHash()) === false) {
			throw(new \InvalidArgumentException("Password or username is incorrect", 401));
		}

		//grab adult from database and put into a session
		$adult = Adult::getAdultByAdultId($pdo, $adult->getAdultId());


		$_SESSION["adult"] = $adult;


		//create the Auth payload
		$authObject = (object)[
			"adultId" => $adult->getAdultId(),
			"adultUsername" => $adult->getAdultUsername()
		];

		//create and set the JWT TOKEN
		setJwtAndAuthHeader("auth", $authObject);


		$reply->message = "Sign In was successful.";

	} else {
		throw (new \InvalidArgumentException("Invalid HTTP method request", 418));
	}

	//if an exception is thrown update the

} catch(Exception | TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);