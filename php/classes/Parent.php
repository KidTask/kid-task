<?php
namespace Club\KidTask;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Parent implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/*
	 * id for this Parent; this is the primary key
	 * @var Uuid $ParentId
	 */
	private $ParentId;
	/*
	 * activation token for this Parent
	 * @var $ParentActivationToken
	 */
	private $ParentActivationToken;
	/*
	 * avatar url for this Parent
	 * @var string $ParentAvatarUrl
	 */
	private $ParentAvatarUrl;
	/*
	 * email for this Parent; unique
	 * @var string $ParentEmail
	 */
	private $ParentEmail;
	/*
	 * State variable containing the Hash of Parent in question
	 * @var $ParentHash
	 */
	private $ParentHash;
	/*
	 * name of this Parent
	 * @var $ParentName
	 */
	private $ParentName;
	/*
		 * State variable containing the Username of Parent in question
		 * Unique
		 * @var string $ParentUsername
		 */
	private $ParentUsername;

	/**
	 * constructor for this Parent
	 *
	 * @param string|Uuid $newParentId id of this Parent or null if a new Parent
	 * @param $newParentActivationToken
	 * @param $newParentAvatarUrl
	 * @param $newParentEmail
	 * @param $newParentHash
	 * @param $newParentName
	 * @param $newParentUsername
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newParentId, $newParentActivationToken, $newParentAvatarUrl, $newParentEmail, $newParentHash, $newParentName, $newParentUsername) {
		try {
			$this->setParentId($newParentId);
			$this->setParentActivationToken($newParentActivationToken);
			$this->setParentAvatarUrl($newParentAvatarUrl);
			$this->setParentEmail($newParentEmail);
			$this->setParentHash($newParentHash);
			$this->setParentName($newParentName);
			$this->setParentUsername($newParentUsername);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} //end of construct function

	/**
	 * accessor method for Parent id
	 *
	 * @return Uuid value of Parent id (or null if new Profile)
	 **/
	public function getParentId() : Uuid {
		return($this->parentId);
	} //end of getParentId function

	/**
	 * mutator method for tweet id
	 *
	 * @param Uuid|string $newParentId new value of Parent id
	 * @throws \RangeException if $newAtuhorId is not positive
	 * @throws \TypeError if $newParentId is not a uuid or string
	 **/
	public function setParentId($newParentId): void {
		try {
			$uuid = self::validateUuid($newParentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the Parent id
		$this->parentId = $uuid;
	} //end of setParentId function

	/**
	 * accessor method for Parent activation token
	 *
	 * @return string value of Parent activation token
	 **/
	public function getParentActivationToken(): string {
		return $this->parentActivationToken;
	} //end of getParentActivationToken function

	/**
	 * mutator method for activation token
	 *
	 * @param string $newParentActivationToken value of activation token
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if $newParentActivationToken is not exactly 32 characters
	 * @throws \TypeError if $newParentActivationToken is not  string
	 **/
	public function setParentActivationToken(string $newParentActivationToken): void {
		if($newParentActivationToken === null) {
			$this->parentActivationToken = null;
			return;
		}
		$newParentActivationToken = strtolower(trim($newParentActivationToken));
		if(ctype_xdigit($newParentActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		if(strlen($newParentActivationToken) !== 32){
			throw(new\RangeException("Activation Token must be 32 characters "));
		}
		$this->parentActivationToken = $newParentActivationToken;
	} //end of setParentActivationToken function

	/**
	 * accessor method for Parent avatar url
	 *
	 * @return string value of Parent avatar url
	 **/
	public function getParentAvatarUrl(): string {
		return $this->parentAvatarUrl;
	} //end of getParentAvatarUrl function

	/* Mutator method for avatar url
		 @param string $newParentAvatarUrl new value of avatar url
		 @throws \InvalidArgumentException if $newParentAvatarUrl is not a valid url or insecure
		 @throws \RangeException if $newParentAvatarUrl is > 255 characters
		 @throws \TypeError if $newParentAvatarUrl is not a string
		*/

	public function setParentAvatarUrl($newParentAvatarUrl): void {
		//verify url is secure
		$newParentAvatarUrl = trim($newParentAvatarUrl);
		$newParentAvatarUrl = filter_var($newParentAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newParentAvatarUrl)===true) {
			throw(new \InvalidArgumentException("url is empty or insecure"));
		}
		//verify url will fit database
		if(strlen($newParentAvatarUrl) > 255) {
			throw(new \RangeException("parent avatar url is too large"));
		}

		$this->parentAvatarUrl = $newParentAvatarUrl;
	} //end of set avatar function

	/*
		 *@return string value of email
		 */
	public function getParentEmail(): string {
		return $this->parentEmail;
	} // end getParentEmail function

	/**
	 * mutator method for email
	 *
	 * @param string $newParentEmail new value of email
	 * @throws \InvalidArgumentException if $newParentEmail is not a valid email or insecure
	 * @throws \RangeException if $newParentEmail is > 128 characters
	 * @throws \TypeError if $newParentEmail is not a string
	 **/
	public function setParentEmail(string $newParentEmail): void {
		// verify the email is secure
		$newParentEmail = trim($newParentEmail);
		$newParentEmail = filter_var($newParentEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newParentEmail) === true) {
			throw(new \InvalidArgumentException("parent email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newParentEmail) > 128) {
			throw(new \RangeException("parent email is too large"));
		}

		// store the email
		$this->parentEmail = $newParentEmail;
	} // end of setParentEmail function

	/**
	 * accessor method for ParentHash
	 *
	 * @return string value of hash
	 */
	public function getParentHash(): string {
		return $this->parentHash;
	} //end of getParentHash function

	/**
	 * mutator method for Parent hash password
	 *
	 * @param string $newParentHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setParentHash(string $newParentHash): void {
		//enforce that the hash is properly formatted
		$newParentHash = trim($newParentHash);
		if(empty($newParentHash) === true) {
			throw(new \InvalidArgumentException("Parent password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$parentHashInfo = password_get_info($newParentHash);
		if($parentHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("Parent hash is not a valid hash"));
		}
		//enforce that the hash is exactly 96 characters.
		if(strlen($newParentHash) !== 96) {
			throw(new \RangeException("Parent hash must be 96 characters"));
		}
		//store the hash
		$this->parentHash = $newParentHash;
	} //end of setParentHash function

	/*
	 * Accessor method for parentName
	 *
	 * @return string value of Name
	 */
	public function getParentName(): string {
		return $this->parentName;
	}//end of getParentName method

	/*
	 * mutator method for Name
	 *
	 * @param string newParentName new value of parent name
	 * @throws \RangeException if $new is > 255 characters
	 * @throws \TypeError if $newParentAvatarUrl is not a string
	 */
	public function setParentName(string $newParentName): void {
		if(strlen($newParentName) > 255) {
			throw(new \RangeException("Name is too large"));
		}

		//store parent name
		$this->parentName = $newParentName;
	}

	/*
	* @return string value of username
	**/
	public function getParentUsername(): string {
		return $this->parentUsername;
	} // end getParentUsername function

	/**
	 * mutator method for Username
	 *
	 * @param string $newParentUsername new value of username
	 * @throws \InvalidArgumentException if the username is empty
	 * @throws \RangeException if $newParentUsername is > 32 characters
	 * @throws \TypeError if $newParentUsername is not a string
	 **/
	public function setParentUsername(string $newParentUsername): void {
		if(empty($newParentUsername) === true) {
			throw(new \InvalidArgumentException("username is empty"));
		}

		// store the username
		$this->parentUsername = $newParentUsername;
	} // end of setParentUsername function

}//end of Parent class