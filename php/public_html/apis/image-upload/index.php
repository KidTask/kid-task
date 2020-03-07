<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";


/**
 * Cloudinary API for Images
 *
 * @author Gabriel Town gtown@cnm.edu
 *
 */

// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Grab the MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/kidtask.ini");
	$pdo = $secrets->getPdoObject();
	$cloudinary = $secrets->getSecret("cloudinary");

	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];



	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// process GET requests
	if($method === "POST") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();


		// assigning variable to the user profile, add image
		//
		$tempUserFileName = $_FILES["image"]["tmp_name"];


		//$reply->message = $cloudinary = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 200, "crop" => "scale"));


		$reply->message  = "https://cloudinary.com/mysupercoolimage.jpg, cloudinaryToken";

	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);