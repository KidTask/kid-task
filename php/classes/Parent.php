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
	 * @var Uuid $parentId
	 */
	private $parentId;
	/*
	 * activation token for this Parent
	 * @var $parentActivationToken
	 */
	private $parentActivationToken;
	/*
	 * avatar url for this Parent
	 * @var string $parentAvatarUrl
	 */
	private $parentAvatarUrl;
	/*
	 * cloudinary token for this Parent
	 * @var string $parentCloudinaryToken
	 */
	private $parentCloudinaryToken;
	/*
	 * email for this Parent; unique
	 * @var string $parentEmail
	 */
	private $parentEmail;
	/*
	 * State variable containing the Hash of Parent in question
	 * @var $parentHash
	 */
	private $parentHash;
	/*
	 * name of this Parent
	 * @var $parentName
	 */
	private $parentName;
	/*
		 * State variable containing the Username of Parent in question
		 * Unique
		 * @var string $parentUsername
		 */
	private $parentUsername;

	/**
	 * constructor for this Parent
	 *
	 * @param string|Uuid $newParentId id of this Parent or null if a new Parent
	 * @param $newParentActivationToken
	 * @param $newParentAvatarUrl
	 * @param $newParentCLoudinaryToken
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
	public function __construct($newParentId, $newParentActivationToken, $newParentAvatarUrl, $newParentCloudinaryToken, $newParentEmail, $newParentHash, $newParentName, $newParentUsername) {
		try {
			$this->setParentId($newParentId);
			$this->setParentActivationToken($newParentActivationToken);
			$this->setParentAvatarUrl($newParentAvatarUrl);
			$this->setParentCloudinaryToken($newParentCloudinaryToken);
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
	 * mutator method for Parent id
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

	/**
	 * accessor method for Parent cloudinary Token
	 *
	 * @return string value of Parent cloudinary token
	 **/
	public function getParentCloudinaryToken(): string {
		return $this->parentCloudinaryToken;
	} //end of getParentCloudinaryToken function

	/* Mutator method for avatar url
		 @param string $newParentCloudinaryToken new value of avatar url
		 @throws \InvalidArgumentException if $newParentCloudinaryToken is insecure
		 @throws \RangeException if $newParentCloudinaryToken is > 255 characters
		 @throws \TypeError if $newParentCloudinaryToken is not a string
		*/
	public function setParentCloudinaryToken($newParentCloudinaryToken): void {
		//verify string is secure
		$newParentCloudinaryToken = trim($newParentCloudinaryToken);
		$newParentCloudinaryToken = filter_var($newParentCloudinaryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newParentCloudinaryToken)===true) {
			throw(new \InvalidArgumentException("token is insecure"));
		}
		//verify url will fit database
		if(strlen($newParentCloudinaryToken) > 255) {
			throw(new \RangeException("parent cloudinary token is too large"));
		}

		$this->parentCloudinaryToken = $newParentCloudinaryToken;
	} //end of setParentCloudinaryToken function

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
		$newParentEmail = filter_var($newParentEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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
	 * @param string newParentName value of parent name
	 * @throws \RangeException if $new is > 255 characters
	 * @throws \TypeError if $newParentAvatarUrl is not a string
	 */
	public function setParentName(string $newParentName): void {
		//remove whitespace and validate parent name
		$newParentName = trim($newParentName);
		$newParentName = filter_var($newParentName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if($newParentName === null) {
			$this->parentName = null;
			return;
		}
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
		//remove whitespace and validate parent name
		$newParentUsername = trim($newParentUsername);
		$newParentUsername = filter_var($newParentUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newParentUsername) === true) {
			throw(new \InvalidArgumentException("username is empty"));
		}

		// store the username
		$this->parentUsername = $newParentUsername;
	} // end of setParentUsername function

	/**
	 * inserts this Parent into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO parent(parentId, parentActivationToken, parentAvatarUrl, parentCloudinaryToken, parentEmail, parentHash, parentName, parentUsername) VALUES(:parentId, :parentActivationToken, :parentAvatarUrl, :parentCloudinaryToken, :parentEmail, :parentHash, :parentName, :parentUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["parentId" => $this->parentId->getBytes(), "parentActivationToken" => $this->parentActivationToken, "parentAvatarUrl" => $this->parentAvatarUrl, "parentCloudinaryToken" => $this->parentCloudinaryToken, "parentEmail" => $this->parentEmail, "parentHash" => $this->parentHash, "parentName" => $this->parentName, "parentUsername" => $this->parentUsername];
		$statement->execute($parameters);
	}//end of pdo insert function

	/**
	 * updates this Parent in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE parent SET parentActivationToken = :parentActivationToken, parentAvatarUrl = :parentAvatarUrl, parentEmail = :parentEmail, parentHash = :parentHash, parentName = :parentName, parentUsername = :parentUsername WHERE parentId = :parentId";
		$statement = $pdo->prepare($query);

		$parameters = ["parentId" => $this->parentId->getBytes(), "parentActivationToken" => $this->parentActivationToken, "parentAvatarUrl" => $this->parentAvatarUrl, "parentEmail" => $this->parentEmail, "parentHash" => $this->parentHash, "parentName" => $this->parentName "parentUsername" => $this->parentUsername];
		$statement->execute($parameters);
	}//end of update pdo method

	/**
	 * deletes this Parent from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM parent WHERE parentId = :parentId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["parentId" => $this->parentId->getBytes()];
		$statement->execute($parameters);
	} //end of delete pdo method

	/**
	 * gets the Parent by parentId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $parentId parent id to search for
	 * @return Parent|null Parent found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getParentByParentId(\PDO $pdo, $parentId) : ?Parent {
		// sanitize the parentId before searching
		try {
			$parentId = self::validateUuid($parentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT parentId, parentActivationToken, parentAvatarUrl, parentEmail, parentHash, parentName, parentUsername FROM parent WHERE parentId = :parentId";
		$statement = $pdo->prepare($query);

		// bind the parent id to the place holder in the template
		$parameters = ["parentId" => $parentId->getBytes()];
		$statement->execute($parameters);

		// grab the parent from mySQL
		try {
			$parent = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$parent = new Parent($row["parentId"], $row["parentActivationToken"], $row["parentAvatarUrl"], $row["parentEmail"], $row["parentHash"], $row["parentName"], $row["parentUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($parent);
	} // end of getParentByParentId

	/**
	 * gets the Parent by parentActivationToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $parentId parent id to search for
	 * @return Parent|null Parent found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getParentByParentActivationToken(\PDO $pdo, $parentActivationToken) : ?Parent {
		// sanitize the parentId before searching
		try {
			$parentId = self::validateUuid($parentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT parentId, parentActivationToken, parentAvatarUrl, parentEmail, parentHash, parentName, parentUsername FROM parent WHERE parentActivationToken = :parentActivationToken";
		$statement = $pdo->prepare($query);

		// bind the parent id to the place holder in the template
		$parameters = ["parentActivationToken" => $parentActivationToken];
		$statement->execute($parameters);

		// grab the parent from mySQL
		try {
			$parent = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$parent = new Parent($row["parentId"], $row["parentActivationToken"], $row["parentAvatarUrl"], $row["parentEmail"], $row["parentHash"], $row["parentName"], $row["parentUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($parent);
	} // end of getParentByParentId

	/**
	 * gets the Parent by parentId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $parentId parent id to search for
	 * @return Parent|null Parent found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getParentByParentId(\PDO $pdo, $parentId) : ?Parent {
		// sanitize the parentId before searching
		try {
			$parentId = self::validateUuid($parentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT parentId, parentActivationToken, parentAvatarUrl, parentCloudinaryToken, parentEmail, parentHash, parentName, parentUsername FROM parent WHERE parentId = :parentId";
		$statement = $pdo->prepare($query);

		// bind the parent id to the place holder in the template
		$parameters = ["parentId" => $parentId->getBytes()];
		$statement->execute($parameters);

		// grab the parent from mySQL
		try {
			$parent = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$parent = new Parent($row["parentId"], $row["parentActivationToken"], $row["parentAvatarUrl"], $row["parentCloudinaryToken"], $row["parentEmail"], $row["parentHash"], $row["parentName"], $row["parentUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($parent);
	} // end of getParentByParentId

	/**
	 * gets the Parent by parentActivationToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $parentId parent id to search for
	 * @return Parent|null Parent found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getParentByParentActivationToken(\PDO $pdo, $parentActivationToken) : ?Parent {
		// sanitize the parentActivationToken before searching
		$parentActivationToken = strtolower(trim($parentActivationToken));
		if(ctype_xdigit($parentActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}

		// create query template
		$query = "SELECT parentId, parentActivationToken, parentAvatarUrl, parentCloudinaryToken, parentEmail, parentHash, parentName, parentUsername FROM parent WHERE parentActivationToken = :parentActivationToken";
		$statement = $pdo->prepare($query);

		// bind the parent id to the place holder in the template
		$parameters = ["parentActivationToken" => $parentActivationToken];
		$statement->execute($parameters);

		// grab the parent from mySQL
		try {
			$parent = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$parent = new Parent($row["parentId"], $row["parentActivationToken"], $row["parentAvatarUrl"], $row["parentCloudinaryToken"], $row["parentEmail"], $row["parentHash"], $row["parentName"], $row["parentUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($parent);
	} // end of getParentByActivationToken

	public static function getParentByParentUsername(\PDO $pdo, $parentUsername) : ?Parent {
		//trim and sanitize username
		$parentUsername = strtolower(trim($parentUsername));
		$parentUsername = filter_var($parentUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($parentUsername) === true) {
			throw(new \PDOException("parent Username type is empty of invalid"));
		}
		// escape mySQL wild cards
		$parentUsername = str_replace("_", "\\_", str_replace("%", "\\%", $parentUsername));

		// create query template
		$query = "SELECT parentId, parentActivationToken, parentAvatarUrl, parentCloudinaryToken, parentEmail, parentHash, parentName, parentUsername FROM parent WHERE parentUsername = :parentUsername";
		$statement = $pdo->prepare($query);

		// bind the parent username to the place holder in the template
		$parameters = ["parentUsername" => $parentUsername];
		$statement->execute($parameters);

		// grab the parent from mySQL
		try {
			$parent = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$parent = new Parent($row["parentId"], $row["parentActivationToken"], $row["parentAvatarUrl"], $row["parentCloudinaryToken"], $row["parentEmail"], $row["parentHash"], $row["parentName"], $row["parentUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($parent);
	}  //end of getParentByParentUsername

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		$fields["parentId"] = $this->parentId->toString();

		return($fields);
	} //end of jsonSerialize
}//end of Parent class