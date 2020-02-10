<?php
namespace Club\KidTask;

require_once("Kid.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Cassandra\Uuid;


class Kid implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;
    /*
     * id for this Kid; this is the primary key
     * @var Uuid $kidId
     */
    private $kidId;
    /*
     *  id of the kid's parent; this is the foreign key
     * @var $kidParentId
     */
    private $kidParentId;
    /*
     * avatar url for the kid
     * @var string $kidAvatarUrl
     */
    private $kidAvatarUrl;
    /*
     * State variable containing the Hash of kid
     * @var string $kidHash
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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
    /**
     * constructor for this Tweet
     *
     * @param string|Uuid $newkidId id of this Kid
     * @param string|Uuid $newkidParentId id of the Kid's Parent
     * @param string $newkidAvatarUrl The Kid's Avatar
     * @param string|null $newkidHash hash for the kid
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manual/en/language.oop5.decon.php
     **/
    public function __construct($newkidId, $newkidParentId, string $newkidAvatarUrl, $newkidHash = null) {
        try {
            $this->setkidId($newkidId);
            $this->setkidParentId($newkidParentId);
            $this->setkidAvatarUrl($newkidAvatarUrl);
            $this->setkidHash($newkidHash);
        }
            //determine what exception type was thrown
        catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for kid id
     *
     * @return Uuid value of kid id
     **/
    public function getKidId() : Uuid {
        return($this->kidId);
    }

    /**
     * mutator method for tweet id
     *
     * @param Uuid|string $newKidId new value of kid id
     * @throws \RangeException if $newKidId is not positive
     * @throws \TypeError if $newKidId is not a uuid or string
     **/
    public function setTweetId( $newKidId) : void {
        try {
            $uuid = self::validateUuid($newKidId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the kid id
        $this->kidId = $uuid;
    }

    /**
     * accessor method for kid parent id
     *
     * @return Uuid value of kid parent id
     **/
    public function getKidParentId() : Uuid{
        return($this->kidParentId);
    }

    /**
     * mutator method for kid parent id
     *
     * @param string | Uuid $newkidParentId new value of tweet profile id
     * @throws \RangeException if $newkidParentId is not positive
     * @throws \TypeError if $newkidParentId is not an integer
     **/
    public function setTweetProfileId( $newkidParentId) : void {
        try {
            $uuid = self::validateUuid($newkidParentId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the profile id
        $this->kidParentId = $uuid;
    }

    /**
     * accessor method for Kid Avatar Url
     *
     * @return string value of Kid Avatar Url
     **/
    public function getkidAvatarUrl() : string {
        return($this->kidAvatarUrl);
    }

    /**
     * mutator method for Kid Avatar Url
     *
     * @param string $newkidAvatarUrl new value of tweet content
     * @throws \InvalidArgumentException if $newkidAvatarUrl is not a string or insecure
     * @throws \RangeException if $newkidAvatarUrl is > 140 characters
     * @throws \TypeError if $newkidAvatarUrl is not a string
     **/
    public function setTweetContent(string $newkidAvatarUrl) : void {
        // verify the tweet content is secure
        $newkidAvatarUrl = trim($newkidAvatarUrl);
        $newkidAvatarUrl = filter_var($newkidAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newkidAvatarUrl) === true) {
            throw(new \InvalidArgumentException("kid avatar url is empty or insecure"));
        }

        // verify the tweet content will fit in the database
        if(strlen($newkidAvatarUrl) > 140) {
            throw(new \RangeException("kid avatar url too large"));
        }

        // store the tweet content
        $this->kidAvatarUrl = $newkidAvatarUrl;
    }

    /**
     * accessor method for Kid Hash
     *
     * @return \DateTime value of Kid Hash
     **/
    public function getkidHash() : \Null {
        return($this->kidHash);
    }

    /**
     * mutator method for kid hash
     *
     * @param \Null|string|null $newkidHash kid hash as a Null object or string (or null
     * @throws \InvalidArgumentException if $newkidHash is not a valid object or string
     * @throws \RangeException if $newkidHash is a null that does not exist
     **/
    public function setkidHash($newkidHash = null) : void {
        if($newkidHash=== null) {
            $this->kidHash = new \Null();
            return;
        }

        // store the like date using the ValidateDate trait
        try {
            $newkidHash = self::($newkidHash);
        } catch(\InvalidArgumentException | \RangeException $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->kidHash = $newkidHash;
    }

    /**
     * inserts this Kid into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        // create query template
        $query = "INSERT INTO kid(kidId,kidParentId, kidAvatarUrl, kidHash) VALUES(:kidId, :kidParentId, :kidAvatarUrl, :kidHash)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $parameters = ["kidId" => $this->kidId->getBytes(), "kidParentId" => $this->kidAvatarUrl->getBytes(), "Kid Avatar Url" => $this->kidAvatarUrl, "kidHash" => $kidHash];
        $statement->execute($parameters);
    }


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
        $parameters = ["tweetId" => $this->kidId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * updates this Kid in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) : void {

        // create query template
        $query = "UPDATE kid SET kidId = :kidId, kidAvatarUrl = :kidAvatarUrl, kidHash = :kidHash WHERE kidId = :kidId";
        $statement = $pdo->prepare($query);


        $parameters = ["tweetId" => $this->kidId->getBytes(),"kidParentId" => $this->kidParentId->getBytes(), "kidAvatarUrl" => $this->kidAvatarUrl, "kidHash" => $kidHash];
        $statement->execute($parameters);
    }

    /**
     * gets the Kid by kidId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $kidId tweet id to search for
     * @return Kid|null Kid found or null if not found
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
        $query = "SELECT kidId, kidParentId, kidAvatarUrl, kidHash FROM kid WHERE kidId = :kidId";
        $statement = $pdo->prepare($query);

        // bind the tweet id to the place holder in the template
        $parameters = ["kid" => $kidId->getBytes()];
        $statement->execute($parameters);

        // grab the kid from mySQL
        try {
            $kidId = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $tweet = new Kid($row["kidId"], $row["kidParentId"], $row["kidAvatarUrl"], $row["kidHash"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($kid);
    }

    /**
     * gets the Kid by kid parent id
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $tweetProfileId profile id to search by
     * @return \SplFixedArray SplFixedArray of Tweets found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getKidByKidParentId(\PDO $pdo, $tweetProfileId) : \SplFixedArray {

        try {
            $kidParentId = self::validateUuid($kidParentId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        // create query template
        $query = "SELECT kidId, kidParentId, kidAvatarUrl, kidHash FROM kid WHERE kidParentId = :kidParentId";
        $statement = $pdo->prepare($query);
        // bind the tweet profile id to the place holder in the template
        $parameters = ["kidParentId" => $kidParentId->getBytes()];
        $statement->execute($parameters);
        // build an array of tweets
        $kid = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $kid = new Kid($row["kidId"], $row["kidParentId"], $row["kidAvatarUrl"], $row["kidHash"]);
                $kid[$kid->key()] = $kid;
                $kid->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return($kid);
    }

    /**
     * gets all Kids
     *
     * @param \PDO $pdo PDO connection object
     * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getAllKids(\PDO $pdo) : \SPLFixedArray {
        // create query template
        $query = "SELECT kidId, kidParentId, kidAvatarUrl, kidHash FROM kid";
        $statement = $pdo->prepare($query);
        $statement->execute();

        // build an array of tweets
        $kids = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $kid = new Kid($row["kidId"], $row["kidParentId"], $row["kidAvatarUrl"], $row["kidHash"]);
                $kids[$kids->key()] = $kid;
                $kids->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($kids);
    }

    /**
     * formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize() : array {
        $fields = get_object_vars($this);

        $fields["kidId"] = $this->kidId->toString();
        $fields["kidParentId"] = $this->kidParentId->toString();

        //format the hash so that the front end can consume it
        $fields["kidHash"] = round(floatval($this->kidHash->format("U.u")) * 1000);
        return($fields);
    }
}
     }//end of Kid class