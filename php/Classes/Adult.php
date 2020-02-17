<?php
namespace Club\KidTask;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Adult implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/*
	 * id for this Adult; this is the primary key
	 * @var Uuid $adultId
	 */
	private $adultId;
	/*
	 * activation token for this Adult
	 * @var $adultActivationToken
	 */
	private $adultActivationToken;
	/*
	 * avatar url for this Adult
	 * @var string $adultAvatarUrl
	 */
	private $adultAvatarUrl;
	/*
	 * cloudinary token for this Adult
	 * @var string $adultCloudinaryToken
	 */
	private $adultCloudinaryToken;
	/*
	 * email for this Adult; unique
	 * @var string $adultEmail
	 */
	private $adultEmail;
	/*
	 * State variable containing the Hash of Adult in question
	 * @var $adultHash
	 */
	private $adultHash;
	/*
	 * name of this Adult
	 * @var $adultName
	 */
	private $adultName;
	/*
		 * State variable containing the Username of Adult in question
		 * Unique
		 * @var string $adultUsername
		 */
	private $adultUsername;

	/**
	 * constructor for this Adult
	 *
	 * @param string|Uuid $newAdultId id of this Adult or null if a new Adult
	 * @param string $newAdultActivationToken
	 * @param string $newAdultAvatarUrl
	 * @param string $newAdultCLoudinaryToken
	 * @param string $newAdultEmail
	 * @param string $newAdultHash
	 * @param string $newAdultName
	 * @param string $newAdultUsername
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct(string $newAdultId, string $newAdultActivationToken, ?string $newAdultAvatarUrl, ?string $newAdultCloudinaryToken, string $newAdultEmail, string $newAdultHash, ?string $newAdultName, string $newAdultUsername) {
		try {
			$this->setAdultId($newAdultId);
			$this->setAdultActivationToken($newAdultActivationToken);
			$this->setAdultAvatarUrl($newAdultAvatarUrl);
			$this->setAdultCloudinaryToken($newAdultCloudinaryToken);
			$this->setAdultEmail($newAdultEmail);
			$this->setAdultHash($newAdultHash);
			$this->setAdultName($newAdultName);
			$this->setAdultUsername($newAdultUsername);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} //end of construct function

	/**
	 * accessor method for Adult id
	 *
	 * @return Uuid value of Adult id (or null if new Profile)
	 **/
	public function getAdultId() : Uuid {
		return($this->adultId);
	} //end of getAdultId function

	/**
	 * mutator method for Adult id
	 *
	 * @param Uuid|string $newAdultId new value of Adult id
	 * @throws \RangeException if $newAtuhorId is not positive
	 * @throws \TypeError if $newAdultId is not a uuid or string
	 **/
	public function setAdultId($newAdultId): void {
		try {
			$uuid = self::validateUuid($newAdultId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the Adult id
		$this->adultId = $uuid;
	} //end of setAdultId function

	/**
	 * accessor method for Adult activation token
	 *
	 * @return string value of Adult activation token
	 **/
	public function getAdultActivationToken(): string {
		return $this->adultActivationToken;
	} //end of getAdultActivationToken function

	/**
	 * mutator method for activation token
	 *
	 * @param string $newAdultActivationToken value of activation token
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if $newAdultActivationToken is not exactly 32 characters
	 * @throws \TypeError if $newAdultActivationToken is not  string
	 **/
	public function setAdultActivationToken(string $newAdultActivationToken): void {
		if($newAdultActivationToken === null) {
			$this->adultActivationToken = null;
			return;
		}
		$newAdultActivationToken = strtolower(trim($newAdultActivationToken));
		if(ctype_xdigit($newAdultActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		if(strlen($newAdultActivationToken) !== 32){
			throw(new\RangeException("Activation Token must be 32 characters "));
		}
		$this->adultActivationToken = $newAdultActivationToken;
	} //end of setAdultActivationToken function

	/**
	 * accessor method for Adult avatar url
	 *
	 * @return string value of Adult avatar url
	 **/
	public function getAdultAvatarUrl(): string {
		return $this->adultAvatarUrl;
	} //end of getAdultAvatarUrl function

	/* Mutator method for avatar url
		 @param string $newAdultAvatarUrl new value of avatar url
		 @throws \InvalidArgumentException if $newAdultAvatarUrl is not a valid url or insecure
		 @throws \RangeException if $newAdultAvatarUrl is > 255 characters
		 @throws \TypeError if $newAdultAvatarUrl is not a string
		*/

	public function setAdultAvatarUrl($newAdultAvatarUrl): void {
		//verify url is secure
		$newAdultAvatarUrl = trim($newAdultAvatarUrl);
		$newAdultAvatarUrl = filter_var($newAdultAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newAdultAvatarUrl)===true) {
			throw(new \InvalidArgumentException("url is empty or insecure"));
		}
		//verify url will fit database
		if(strlen($newAdultAvatarUrl) > 255) {
			throw(new \RangeException("adult avatar url is too large"));
		}

		$this->adultAvatarUrl = $newAdultAvatarUrl;
	} //end of set avatar function

	/**
	 * accessor method for Adult cloudinary Token
	 *
	 * @return string value of Adult cloudinary token
	 **/
	public function getAdultCloudinaryToken(): string {
		return $this->adultCloudinaryToken;
	} //end of getAdultCloudinaryToken function

	/* Mutator method for avatar url
		 @param string $newAdultCloudinaryToken new value of avatar url
		 @throws \InvalidArgumentException if $newAdultCloudinaryToken is insecure
		 @throws \RangeException if $newAdultCloudinaryToken is > 255 characters
		 @throws \TypeError if $newAdultCloudinaryToken is not a string
		*/
	public function setAdultCloudinaryToken($newAdultCloudinaryToken): void {
		//verify string is secure
		$newAdultCloudinaryToken = trim($newAdultCloudinaryToken);
		$newAdultCloudinaryToken = filter_var($newAdultCloudinaryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAdultCloudinaryToken)===true) {
			throw(new \InvalidArgumentException("token is insecure"));
		}
		//verify url will fit database
		if(strlen($newAdultCloudinaryToken) > 255) {
			throw(new \RangeException("adult cloudinary token is too large"));
		}

		$this->adultCloudinaryToken = $newAdultCloudinaryToken;
	} //end of setAdultCloudinaryToken function

	/*
		 *@return string value of email
		 */
	public function getAdultEmail(): string {
		return $this->adultEmail;
	} // end getAdultEmail function

	/**
	 * mutator method for email
	 *
	 * @param string $newAdultEmail new value of email
	 * @throws \InvalidArgumentException if $newAdultEmail is not a valid email or insecure
	 * @throws \RangeException if $newAdultEmail is > 128 characters
	 * @throws \TypeError if $newAdultEmail is not a string
	 **/
	public function setAdultEmail(string $newAdultEmail): void {
		// verify the email is secure
		$newAdultEmail = trim($newAdultEmail);
		$newAdultEmail = filter_var($newAdultEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAdultEmail) === true) {
			throw(new \InvalidArgumentException("adult email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newAdultEmail) > 128) {
			throw(new \RangeException("adult email is too large"));
		}

		// store the email
		$this->adultEmail = $newAdultEmail;
	} // end of setAdultEmail function

	/**
	 * accessor method for AdultHash
	 *
	 * @return string value of hash
	 */
	public function getAdultHash(): string {
		return $this->adultHash;
	} //end of getAdultHash function

	/**
	 * mutator method for Adult hash password
	 *
	 * @param string $newAdultHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setAdultHash(string $newAdultHash): void {
		//enforce that the hash is properly formatted
		$newAdultHash = trim($newAdultHash);
		if(empty($newAdultHash) === true) {
			throw(new \InvalidArgumentException("Adult password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$adultHashInfo = password_get_info($newAdultHash);
		if($adultHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("Adult hash is not a valid hash"));
		}
		//enforce that the hash is exactly 98 characters.
		if(strlen($newAdultHash) !== 98) {
			throw(new \RangeException("Adult hash must be 98 characters"));
		}
		//store the hash
		$this->adultHash = $newAdultHash;
	} //end of setAdultHash function

	/*
	 * Accessor method for adultName
	 *
	 * @return string value of Name
	 */
	public function getAdultName(): string {
		return $this->adultName;
	}//end of getAdultName method

	/*
	 * mutator method for Name
	 *
	 * @param string newAdultName value of adult name
	 * @throws \RangeException if $new is > 255 characters
	 * @throws \TypeError if $newAdultAvatarUrl is not a string
	 */
	public function setAdultName(string $newAdultName): void {
		//remove whitespace and validate adult name
		$newAdultName = trim($newAdultName);
		$newAdultName = filter_var($newAdultName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if($newAdultName === null) {
			$this->adultName = null;
			return;
		}
		if(strlen($newAdultName) > 255) {
			throw(new \RangeException("Name is too large"));
		}

		//store adult name
		$this->adultName = $newAdultName;
	}

	/*
	* @return string value of username
	**/
	public function getAdultUsername(): string {
		return $this->adultUsername;
	} // end getAdultUsername function

	/**
	 * mutator method for Username
	 *
	 * @param string $newAdultUsername new value of username
	 * @throws \InvalidArgumentException if the username is empty
	 * @throws \RangeException if $newAdultUsername is > 32 characters
	 * @throws \TypeError if $newAdultUsername is not a string
	 **/
	public function setAdultUsername(string $newAdultUsername): void {
		//remove whitespace and validate adult name
		$newAdultUsername = trim($newAdultUsername);
		$newAdultUsername = filter_var($newAdultUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newAdultUsername) === true) {
			throw(new \InvalidArgumentException("username is empty"));
		}

		// store the username
		$this->adultUsername = $newAdultUsername;
	} // end of setAdultUsername function

	/**
	 * inserts this Adult into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO adult(adultId, adultActivationToken, adultAvatarUrl, adultCloudinaryToken, adultEmail, adultHash, adultName, adultUsername) VALUES(:adultId, :adultActivationToken, :adultAvatarUrl, :adultCloudinaryToken, :adultEmail, :adultHash, :adultName, :adultUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["adultId" => $this->adultId->getBytes(), "adultActivationToken" => $this->adultActivationToken, "adultAvatarUrl" => $this->adultAvatarUrl, "adultCloudinaryToken" => $this->adultCloudinaryToken, "adultEmail" => $this->adultEmail, "adultHash" => $this->adultHash, "adultName" => $this->adultName, "adultUsername" => $this->adultUsername];
		$statement->execute($parameters);
	}//end of pdo insert function

	/**
	 * updates this Adult in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE adult SET adultActivationToken = :adultActivationToken, adultAvatarUrl = :adultAvatarUrl, adultCloudinaryToken =:adultCloudinaryToken, adultEmail = :adultEmail, adultHash = :adultHash, adultName = :adultName, adultUsername = :adultUsername WHERE adultId = :adultId";
		$statement = $pdo->prepare($query);

		$parameters = ["adultId" => $this->adultId->getBytes(), "adultActivationToken" => $this->adultActivationToken, "adultAvatarUrl" => $this->adultAvatarUrl, "adultCloudinaryToken" => $this->adultCloudinaryToken, "adultEmail" => $this->adultEmail, "adultHash" => $this->adultHash, "adultName" => $this->adultName, "adultUsername" => $this->adultUsername];
		$statement->execute($parameters);
	}//end of update pdo method

	/**
	 * deletes this Adult from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM adult WHERE adultId = :adultId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["adultId" => $this->adultId->getBytes()];
		$statement->execute($parameters);
	} //end of delete pdo method

	/**
	 * gets the Adult by adultId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $adultId adult id to search for
	 * @return Adult|null Adult found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAdultByAdultId(\PDO $pdo, $adultId) : ?Adult {
		// sanitize the adultId before searching
		try {
			$adultId = self::validateUuid($adultId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT adultId, adultActivationToken, adultAvatarUrl, adultCloudinaryToken, adultEmail, adultHash, adultName, adultUsername FROM adult WHERE adultId = :adultId";
		$statement = $pdo->prepare($query);

		// bind the adult id to the place holder in the template
		$parameters = ["adultId" => $adultId->getBytes()];
		$statement->execute($parameters);

		// grab the adult from mySQL
		try {
			$adult = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$adult = new Adult($row["adultId"], $row["adultActivationToken"], $row["adultAvatarUrl"], $row["adultCloudinaryToken"], $row["adultEmail"], $row["adultHash"], $row["adultName"], $row["adultUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($adult);
	} // end of getAdultByAdultId

	/**
	 * gets the Adult by adultActivationToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $adultActivationToken adult activation token to search for
	 * @return Adult|null Adult found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAdultByAdultActivationToken(\PDO $pdo, $adultActivationToken) : ?Adult {
		// sanitize the adultId before searching
		$adultActivationToken = strtolower(trim($adultActivationToken));
		$adultActivationToken = filter_var($adultActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($adultActivationToken) === true) {
			throw(new \PDOException("adult activation token is empty of invalid"));
		}

		// create query template
		$query = "SELECT adultId, adultActivationToken, adultAvatarUrl, adultCloudinaryToken, adultEmail, adultHash, adultName, adultUsername FROM adult WHERE adultActivationToken = :adultActivationToken";
		$statement = $pdo->prepare($query);

		// bind the adult activation token to the place holder in the template
		$parameters = ["adultActivationToken" => $adultActivationToken];
		$statement->execute($parameters);

		// grab the adult from mySQL
		try {
			$adult = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$adult = new Adult($row["adultId"], $row["adultActivationToken"], $row["adultAvatarUrl"], $row["adultCloudinaryToken"], $row["adultEmail"], $row["adultHash"], $row["adultName"], $row["adultUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($adult);
	} // end of getAdultByActivationToken

	/**
	 * gets the Adult by adultUsername
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $adultUsername adult username to search for
	 * @return Adult|null Adult found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAdultByAdultUsername(\PDO $pdo, $adultUsername) : ?Adult {
		//trim and sanitize username
		$adultUsername = strtolower(trim($adultUsername));
		$adultUsername = filter_var($adultUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($adultUsername) === true) {
			throw(new \PDOException("adult Username type is empty of invalid"));
		}

		// create query template
		$query = "SELECT adultId, adultActivationToken, adultAvatarUrl, adultCloudinaryToken, adultEmail, adultHash, adultName, adultUsername FROM adult WHERE adultUsername = :adultUsername";
		$statement = $pdo->prepare($query);

		// bind the adult username to the place holder in the template
		$parameters = ["adultUsername" => $adultUsername];
		$statement->execute($parameters);

		// grab the adult from mySQL
		try {
			$adult = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$adult = new Adult($row["adultId"], $row["adultActivationToken"], $row["adultAvatarUrl"], $row["adultCloudinaryToken"], $row["adultEmail"], $row["adultHash"], $row["adultName"], $row["adultUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($adult);
	}  //end of getAdultByAdultUsername

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		$fields["adultId"] = $this->adultId->toString();

		return($fields);
	} //end of jsonSerialize
}//end of Adult class