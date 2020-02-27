<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\Test\Adult;

/**
 * api for signing up to Kid Task
 *
 * @author Gabriel Town gtown@cnm.edu>
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
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/kidtask.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {

		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//account email is a required field
		if(empty($requestObject->aduleEmail) === true) {
			throw(new \InvalidArgumentException ("No account email present", 405));
		}

		//account username is a required field
		if(empty($requestObject->adultUsername) === true) {
			throw(new \InvalidArgumentException ("No parent username", 405));
		}

		//verify that account password is present
		if(empty($requestObject->adultPassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//verify that the confirm password is present
		if(empty($requestObject->adulrPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//make sure the password and confirm password match
		if ($requestObject->adultPassword !== $requestObject->adultPasswordConfirm) {
			throw(new \InvalidArgumentException("passwords do not match"));


