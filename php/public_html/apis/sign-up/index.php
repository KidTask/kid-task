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
		if(empty($requestObject->adultPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}


		$hash = password_hash($requestObject->adultPassword, PASSWORD_ARGON2I, ["time_cost" => 384]);

		$adultActivationToken = bin2hex(random_bytes(16));

		//create the adult object and prepare to insert into the database
		$adult = new Adult(generateUuidV4(), $adultActivationToken, null, null, $requestObject->adultEmail, $hash, null, $requestObject->adultUsername);

		//insert the profile into the database
		$adult->insert($pdo);

		//compose the email message to send with th activation token
		$messageSubject = "Kid Task -- Activate Your Account";

		//building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		//make sure URL is /public_html/api/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

		//create the path
		$urlglue = $basePath . "/apis/activation/?activation=" . $adultActivationToken;

		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

		//compose message to send with email
		$message = <<< EOF
		<h2>Welcome to Kid Task.</h2>
		<p>In order to start assigning tasks to your kid(s) confirm your account </p>
		<p><a href="$confirmLink">$confirmLink</a></p>
		EOF;

		//create swift email
		$swiftMessage = new Swift_Message();

		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["gtown@cnm.edu" => "Gabriel Town"]);

		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */
		//define who the recipient is
		$recipients = [$requestObject->adultEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);

		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);

		/**
		 * attach the message to the email
		 * set two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text
		 * notice the tactic used is to display the entire $confirmLink to plain text
		 * this lets users who are not viewing the html content to still access the link
		 */
		//attach the html version fo the message
		$swiftMessage->setBody($message, "text/html");

		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		/**
		 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
		 * this default may or may not be available on all web hosts; consult their documentation/support for details
		 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
		 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		 **/
		//setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25);
		$mailer = new Swift_Mailer($smtp);

		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);

		/**
		 * the send method returns the number of recipients that accepted the Email
		 * so, if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email", 400));
		}

		// update reply
		$reply->message = "Thank you for creating an account with Kid Task";
	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}

} catch(\Exception |\TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}

header("Content-type: application/json");
echo json_encode($reply);


