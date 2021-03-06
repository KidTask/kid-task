<?php
namespace Club\KidTask;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\uuid;


class Kid implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;
    /*
     * id for this Kid; this is the primary key
     * @var Uuid $kidId
     */
    private $kidId;
    /*
     *  id of the kid's Adult; this is the foreign key
     * @var $kidAdultId
     */
    private $kidAdultId;
    /*
     * avatar url for the kid
     * @var string $kidAvatarUrl
     */
    private $kidAvatarUrl;
    /*
     * State variable containing the Hash of kid
     * @var string $kidHash
     */

    private $kidCloudinaryToken;
    /*
     * Cloudinary Token for Kid
     * @var string $kidCloudinaryToken
     */

    private $kidHash;
    /*
     * name of the Kid
     * @var $kidName
     */
    private $kidName;
    /*
     * The Kid's Username
     * Unique
     * @var $kidUsername
     */
    private $kidUsername;

    /**
     * constructor for this Kid
     *
     * @param string|Uuid $newKidId The Kid's Id, primary id
     * @param string|Uuid $newKidAdultId The Kid's Adult Id, foreign key
     * @param string|$newKidAvatarUrl avatar url for kid, can be null
     * @param string|$newKidCloudinaryToken cloudinary token for kid, can be null
     * @param string|$newKidHash password hash for kid
     * @param string|$newKidName name of kid, can be null
     * @param string|$newKidUsername username for kid, used to log in
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manual/en/language.oop5.decon.php
     */
    public function __construct( $newKidId, $newKidAdultId, ?string $newKidAvatarUrl, ?string $newKidCloudinaryToken, string $newKidHash, ?string $newKidName, string $newKidUsername) {
        try {
            $this->setKidId($newKidId);
            $this->setKidAdultId($newKidAdultId);
            $this->setKidAvatarUrl($newKidAvatarUrl);
            $this->setKidCloudinaryToken($newKidCloudinaryToken);
            $this->setKidHash($newKidHash);
            $this->setKidName($newKidName);
            $this->setKidUsername($newKidUsername);
        }
            //determine what exception type was thrown
        catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    } //end of construct function

    /**
     * accessor method for Kid id
     *
     * @return Uuid value of Kid id (or null if new Profile)
     **/
    public function getKidId() : Uuid {
        return($this->kidId);
    } //end of getKidId function

    /**
     * mutator method for Kid id
     *
     * @param Uuid|string $newKidId new value of Adult id
     * @throws \RangeException if $newAuthorId is not positive
     * @throws \TypeError if $newKidId is not a uuid or string
     **/
    public function setKidId($newKidId): void {
        try {
            $uuid = self::validateUuid($newKidId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the Kid id
        $this->kidId = $uuid;
    } //end of setKidId function

    /**
     * accessor method for Kid Adult id
     *
     * @return Uuid value of Kid Adult id (or null if new Profile)
     **/
    public function getKidAdultId() : Uuid {
        return($this->kidAdultId);
    } //end of getKidAdultId function

    /**
     * mutator method for Kid Adult id
     * @param Uuid|string $newKidAdultId new value of Adult id
     * @throws \RangeException if $newAuthorId is not positive
     * @throws \TypeError if $newKidAdultId is not a uuid or string
     **/
    public function setKidAdultId($newKidAdultId): void {
        try {
            $uuid = self::validateUuid($newKidAdultId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the Kid Adult id

        $this->kidAdultId = $uuid;
    } //end of setKidAdultId function
    /**
     * accessor method for Kid avatar url
     *
     * @return string value of Kid avatar url
     **/
    public function getKidAvatarUrl(): ?string {
        return $this->kidAvatarUrl;
    } //end of getKidAvatarUrl function

    /* Mutator method for avatar url
         @param string $newKidAvatarUrl new value of avatar url
         @throws \InvalidArgumentException if $newKidAvatarUrl is not a valid url or insecure
         @throws \RangeException if $newKidAvatarUrl is > 255 characters
         @throws \TypeError if $newKidAvatarUrl is not a string
        */

    public function setKidAvatarUrl(?string $newKidAvatarUrl): void {
        //verify url is secure
        $newKidAvatarUrl = trim($newKidAvatarUrl);
        $newKidAvatarUrl = filter_var($newKidAvatarUrl, FILTER_VALIDATE_URL);
        if(empty($newKidAvatarUrl)===true) {
			  $this->kidAvatarUrl = null;
			  return;
		  }
        //verify url will fit database
        if(strlen($newKidAvatarUrl) > 255) {
            throw(new \RangeException("Adult avatar url is too large"));
        }

        $this->kidAvatarUrl = $newKidAvatarUrl;
    } //end of set avatar function


    /**
     * accessor method for KidHash
     *
     * @return string value of hash
     */
    public function getKidHash(): string {
        return $this->kidHash;
    } //end of getKidHash function

    /**
     * mutator method for Kid hash password
     *
     * @param string $newKidHash
     * @throws \InvalidArgumentException if the hash is not secure
     * @throws \RangeException if the hash is not 128 characters
     * @throws \TypeError if profile hash is not a string
     */
    public function setKidHash(string $newKidHash): void {
        //enforce that the hash is properly formatted
        $newKidHash = trim($newKidHash);
        if(empty($newKidHash) === true) {
            throw(new \InvalidArgumentException("Kid password hash empty or insecure"));
        }
        //enforce the hash is really an Argon hash
        $kidHashInfo = password_get_info($newKidHash);
        if($kidHashInfo["algoName"] !== "argon2i") {
            throw(new \InvalidArgumentException("Kid hash is not a valid hash"));
        }
        //enforce that the hash is exactly 97 characters.
        if(strlen($newKidHash) > 97 || strlen($newKidHash) < 89) {
            throw(new \RangeException("Kid hash must be 97 characters"));
        }
        //store the hash
        $this->kidHash = $newKidHash;
    } //end of setKidHash function

    /**
     * accessor method for kid cloudinary token
     *
     * @return string value of Kid Cloudinary Token
     **/
    public function getKidCloudinaryToken(): ?string {
        return $this->kidCloudinaryToken;
    } //end of getKidCloudinaryToken function

    /**
     * mutator method for kid cloudinary token
     *
     * @param string $newKidCloudinaryToken kid cloudinary token
     * @throws \InvalidArgumentException  if the token is not a string or insecure
     * @throws \RangeException if $newKidCloudinaryToken is not exactly 32 characters
     * @throws \TypeError if $newKidCloudinaryToken is not a string
     **/

    public function setKidCloudinaryToken(?string $newKidCloudinaryToken): void {
        //verify string is secure
        $newKidCloudinaryToken = trim($newKidCloudinaryToken);
        $newKidCloudinaryToken = filter_var($newKidCloudinaryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newKidCloudinaryToken)===true) {
			  $this->kidCloudinaryToken = null;
			  return;
        }
        //verify url will fit database
        if(strlen($newKidCloudinaryToken) > 255) {
            throw(new \RangeException("kid cloudinary token is too large"));
        }

        $this->kidCloudinaryToken = $newKidCloudinaryToken;
    } //end of setKidCloudinaryToken function


    /*
     * Accessor method for kidName
     *
     * @return string value of Name
     */
    public function getKidName(): ?string {
        return $this->kidName;
    }//end of getKidName method

    /*
     * mutator method for Name
     *
     * @param string newKidName value of Adult name
     * @throws \RangeException if $new is > 255 characters
     * @throws \TypeError if $newKidAvatarUrl is not a string
     */
    public function setKidName(?string $newKidName): void {
        $newKidName = trim($newKidName);
        $newKidName = filter_var($newKidName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if($newKidName === null) {
            $this->kidName = null;
            return;
        }
        if(strlen($newKidName) > 255) {
            throw(new \RangeException("Name is too large"));
        }
        //store Kid name
        $this->kidName = $newKidName;
    }

    /*
    * @return string value of username
    **/
    public function getKidUsername(): string {
        return $this->kidUsername;
    } // end getKidUsername function

    /**
     * mutator method for Username
     *
     * @param string $newKidUsername new value of username
     * @throws \InvalidArgumentException if the username is empty
     * @throws \RangeException if $newKidUsername is > 32 characters
     * @throws \TypeError if $newKidUsername is not a string
     **/
    public function setKidUsername(string $newKidUsername): void {
		 $newKidUsername = trim($newKidUsername);
		 $newKidUsername = filter_var($newKidUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newKidUsername) === true) {
            throw(new \InvalidArgumentException("username is empty"));
        }

		 if(strlen($newKidUsername) > 255) {
			 throw(new \RangeException("Username is too large"));
		 }

        // store the username
        $this->kidUsername = $newKidUsername;
    } // end of setKidUsername function

    /**
     * inserts this Kid into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        // create query template
        $query = "INSERT INTO kid(kidId, kidAdultId, kidAvatarUrl, kidCloudinaryToken, kidHash, kidName, kidUsername) VALUES(:kidId, :kidAdultId, :kidAvatarUrl, :kidCloudinaryToken, :kidHash, :kidName, :kidUsername)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $parameters = ["kidId" => $this->kidId->getBytes(), "kidAdultId" => $this->kidAdultId->getBytes(), "kidAvatarUrl" => $this->kidAvatarUrl, "kidCloudinaryToken" => $this->kidCloudinaryToken, "kidHash" => $this->kidHash, "kidName" => $this->kidName, "kidUsername" => $this->kidUsername];
        $statement->execute($parameters);
    }//end of pdo insert function

    /**
     * updates this Kid in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) : void {

        // create query template
        $query = "UPDATE kid SET kidId = :kidId, kidAdultId = :kidAdultId, kidAvatarUrl = :kidAvatarUrl, kidCloudinaryToken = :kidCloudinaryToken, kidHash = :kidHash, kidName = :kidName, kidUsername = :kidUsername WHERE kidId = :kidId";
        $statement = $pdo->prepare($query);

        $parameters = ["kidId" => $this->kidId->getBytes(), "kidAdultId" => $this->kidAdultId->getBytes(), "kidAvatarUrl" => $this->kidAvatarUrl, "kidCloudinaryToken" => $this->kidCloudinaryToken, "kidHash" => $this->kidHash, "kidName" => $this->kidName, "kidUsername" => $this->kidUsername];
        $statement->execute($parameters);
    }//end of update pdo method

    /**
     * deletes this Kid from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo) : void {

        // create query template
        $query = "DELETE FROM kid WHERE kidId = :kidId";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holder in the template
        $parameters = ["kidId" => $this->kidId->getBytes()];
        $statement->execute($parameters);
    }//end of delete pdo method


    /**
     * gets the Kid by kidId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $kidId kid id to search for
     * @return Kid|null kid found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable are not the correct data type
     **/
    public static function getKidByKidId(\PDO $pdo, $kidId) : ?Kid {
        // sanitize the kidId before searching
        try {
            $kidId = self::validateUuid($kidId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        // create query template
        $query = "SELECT kidId, kidAdultId, kidAvatarUrl, kidCloudinaryToken, kidHash, kidName, kidUsername FROM kid WHERE kidId = :kidId";
        $statement = $pdo->prepare($query);

        // bind the Adult id to the place holder in the template
        $parameters = ["kidId" => $kidId->getBytes()];
        $statement->execute($parameters);

        // grab the kid from mySQL
        try {
            $kid = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $kid = new Kid($row["kidId"], $row["kidAdultId"], $row["kidAvatarUrl"], $row["kidCloudinaryToken"], $row["kidHash"], $row["kidName"], $row["kidUsername"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($kid);
    } // end of getKidByKidId

    /**
     * gets the Kid by kidAdultId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $kidAdultId kid id to search for
     * @return \SplFixedArray kid found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable are not the correct data type
     **/
    public static function getKidByKidAdultId(\PDO $pdo, $kidAdultId) : \SplFixedArray {
        // sanitize the description before searching
        try {
            $kidAdultId = self::validateUuid($kidAdultId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        // create query template
        $query = "SELECT kidId, kidAdultId, kidAvatarUrl, kidCloudinaryToken, kidHash, kidName, kidUsername FROM kid WHERE kidAdultId LIKE :kidAdultId";
        $statement = $pdo->prepare($query);

        // bind the kid content to the place holder in the template
        $parameters = ["kidAdultId" => $kidAdultId ->getBytes()];
        $statement->execute($parameters);

        // build an array of kids
        $kids = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $kid = new Kid($row["kidId"], $row["kidAdultId"], $row["kidAvatarUrl"],
                    $row["kidCloudinaryToken"], $row["kidHash"],
                    $row["kidName"], $row["kidUsername"]);
                $kids[$kids->key()] = $kid;
                $kids->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return($kids);
    } //end of getKidByKidAdultId



    /**
     * gets the Kid by kidUsername
     *
     * @param \PDO $pdo PDO connection object
     * @param string $kidUsername kid username to search for
     * @return Kid|null kid found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable are not the correct data type
     **/
    public static function getKidByKidUsername(\PDO $pdo, $kidUsername) : ?Kid {
        // sanitize the kidUsername before searching
        $kidUsername = strtolower(trim($kidUsername));
        $kidUsername = filter_var($kidUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        // create query template
        $query = "SELECT kidId, kidAdultId, kidAvatarUrl, kidCloudinaryToken, kidHash, kidName, kidUsername FROM kid WHERE kidUsername = :kidUsername";
        $statement = $pdo->prepare($query);

        // bind the kid username to the place holder in the template
        $parameters = ["kidUsername" => $kidUsername];
        $statement->execute($parameters);

        // grab the kid from mySQL
        try {
            $kid = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $kid = new Kid($row["kidId"], $row["kidAdultId"], $row["kidAvatarUrl"], $row["kidCloudinaryToken"], $row["kidHash"], $row["kidName"], $row["kidUsername"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($kid);
    } // end of getKidByKidUsername
    /**
     * formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize() : array {
        $fields = get_object_vars($this);
        $fields["kidId"] = $this->kidId->toString();
        $fields["kidAdultId"] = $this->kidAdultId->toString();
		 unset($fields["kidHash"]);
		 return($fields);
    }

} //end of Kid class
