<?php


require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Club\KidTask\Kid;

/**
 * API for kid-account
 *
 * @author Jacob Lott <jlott3@cnm.edu>
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
    $kidId = filter_input(INPUT_GET, "kidId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $kidAdultId = filter_input(INPUT_GET, "kidAdultId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $kidAvatarUrl= filter_input(INPUT_GET, "kidAvatarUrl", FILTER_SANITIZE_URL);
    $kidCloudinaryToken= filter_input(INPUT_GET, "kidCloudinaryToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $kidName = filter_input(INPUT_GET, "kidName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $kidUsername = filter_input(INPUT_GET, "kidUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    //make sure avatar url is valid (optional field)
        if (empty($requestObject->kidAvatarUrl) === true) {
            $requestObject->kidAvatarUrl = null;
        }

        //make sure cloudinary token is valid (optional field)
        if (empty($requestObject->kidCloudinaryToken) === true) {
            $requestObject->kidCloudinaryToken = null;
        }

        //make sure name is valid (optional field)
        if (empty($requestObject->kidName) === true) {
            $requestObject->kidName = null;
        }
        // make sure the id is valid for methods that require it
        if(($method === "DELETE" || $method === "PUT") && (empty($kidId) === true)) {
            throw(new InvalidArgumentException("Kid Id cannot be empty or negative", 405));
        }

    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        //gets a kid by content
        if(empty($kidId) === false) {
            $reply->data = Kid::getKidByKidId($pdo, $kidId);

        } else if(empty($kidAdultId) === false) {
            $reply->data = Kid::getKidByKidAdultId($pdo, $kidAdultId);

        } else if(empty($kidUsername) === false) {

            $reply->data = Kid::getKidByKidUsername($pdo, $kidUsername);
        }

    } elseif($method === "PUT") {

        //enforce that the XSRF token is present in the header
        verifyXsrf();

        //enforce the end user has a JWT token
        validateJwtHeader();

        //enforce the user is signed in and only trying to edit their own profile
        if(empty($_SESSION["kid"]) === true || $_SESSION["kid"]->getKidId()->toString() !== $kidId) {
            throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
        }

        validateJwtHeader();

        //decode the response from the front end
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //retrieve the kid to be updated
        $kid = Kid::getKidByKidId($pdo, $kidId);
        if($kid === null) {
            throw(new RuntimeException("Profile does not exist.", 404));
        }

        //the kid's adult id
        $kid = Kid::getKidByKidAdultId($pdo, $kidAdultId);
        if($kid === null) {
            throw(new RuntimeException("Profile does not exist.", 404));
        }

        //kid's avatar url
        if(empty($requestObject->kidAvatarUrl) === true) {
            throw(new \InvalidArgumentException("No Kid Avatar Url is present.", 405));
        }

        //kid's cloudinary token
        if(empty($requestObject->kidCloudinaryToken) === true) {
            throw(new \InvalidArgumentException("No Cloudinary Token for Kid.", 405));
        }

        //Kid Name
        if(empty($requestObject->kidName) === true) {
            throw(new \InvalidArgumentException("No kid name!", 405));
        }

        //Kid Username
        if(empty($requestObject->kidUsername) === true) {
            throw(new \InvalidArgumentException ("No Kid Username present.", 405));
        }


        $kid->setKidAdultId($requestObject->kidAdultId);
        $kid->setKidAvatarUrl($requestObject->kidAvatarUrl);
        $kid->setKidCloudinaryToken($requestObject->kidCloudinaryToken);
        $kid->setKidName($requestObject->kidName);
        $kid->setKidUsername($requestObject->kidUsername);
        $kid->update($pdo);

        // update reply
        $reply->message = "Profile information updated";


    } elseif($method === "DELETE") {

        //verify the XSRF Token
        verifyXsrf();

        //enforce the end user has a JWT token
        //validateJwtHeader();

        $kid = Kid::getKidByKidId($pdo, $kidId);
        if($kid === null) {
            throw (new RuntimeException("Profile does not exist"));
        }

        //enforce the user is signed in and only trying to edit their own profile
        if(empty($_SESSION["kid"]) === true || $_SESSION["kid"]->getKidId()->toString() !== $kid->getKidId()->toString()) {
            throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
        }

        validateJwtHeader();

        //delete the post from the database
        $kid->delete($pdo);
        $reply->message = "Profile Deleted";

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