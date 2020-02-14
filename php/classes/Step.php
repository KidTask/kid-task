<?php
namespace Club\StepTask;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Step implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/*
	 * id for this Step; this is the primary key
	 * @var Uuid $stepId
	 */
	private $stepId;
	/*
	 * Taskid for this Step; this is the foreign key
	 * @var Uuid $stepTaskId
	 */
	private $stepTaskId;
	/*
	 * Content of this Step
	 * @var string $stepContent
	 */
	private $stepContent;
	/*
	 * Order of this Step
	 * @var tinyint $stepOrder
	 */
	private $stepOrder;
	

	/**
	 * constructor for this Step
	 *
	 * @param string|Uuid $newStepId id of this Step or null if a new Step
	 * @param string|Uuid $newStepTaskId id of this stepTask or null if a new stepTask
	 * @param $newStepContent
	 * @param $newStepOrder
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newStepId, $newStepTaskId, $newStepContent, $newStepOrder) {
		try {
			$this->setStepId($newStepId);
			$this->setStepTaskId($newStepTaskId);
			$this->setStepContent($newStepContent);
			$this->setStepOrder($newStepOrder);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} //end of construct function

	/**
	 * accessor method for step id
	 *
	 * @return Uuid value of step id (or null if new Profile)
	 **/
	public function getStepId() : Uuid {
		return($this->stepId);
	} //end of getStepId function

	/**
	 * mutator method for step id
	 *
	 * @param Uuid|string $newStepId new value of step id
	 * @throws \RangeException if $newStepId is not positive
	 * @throws \TypeError if $newStepId is not a uuid or string
	 **/
	public function setStepId($newStepId): void {
		try {
			$uuid = self::validateUuid($newStepId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the step id
		$this->stepId = $uuid;
	} //end of setStepId function

	/**
	 * accessor method for stepTask id
	 *
	 * @return Uuid value of stepTask id (or null if new Profile)
	 **/
	public function getStepTaskId() : Uuid {
		return($this->stepTaskId);
	} //end of getStepTaskId function

	/**
	 * mutator method for stepTask id
	 *
	 * @param Uuid|string $newStepTaskId new value of stepTask id
	 * @throws \RangeException if $newStepTaskId is not positive
	 * @throws \TypeError if $newStepTaskId is not a uuid or string
	 **/
	public function setStepTaskId($newStepTaskId): void {
		try {
			$uuid = self::validateUuid($newStepTaskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the stepTask id
		$this->stepTaskId = $uuid;
	} //end of setStepTaskId function

	/*
		* @return string value of Content
		**/
	public function getStepContent(): string {
		return $this->stepContent;
	} // end getStepContent function

	/**
	 * mutator method for Content
	 *
	 * @param string $newStepContent new value of Content
	 * @throws \InvalidArgumentException if the content is empty
	 * @throws \RangeException if $newStepContent is > 1000 characters
	 * @throws \TypeError if $newStepContent is not a string
	 **/
	public function setStepContent(string $newStepContent): void {
		//validate content is secure
		$newStepContent = trim($newStepContent);
		$newStepContent = filter_var($newStepContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newStepContent) === true) {
			throw(new \InvalidArgumentException("content is empty"));
		}
		if(strlen($newStepContent) > 255) {
			throw(new \RangeException("Content is too large"));
		}

		// store the content
		$this->stepContent = $newStepContent;
	} // end of setStepContent function

	/**
	 * accessor method for step order
	 *
	 * @return int value of stepOrder
	 **/
	public function getStepOrder() : int {
		return $this->stepOrder;
	}//end of getStepOrder

	/**
	 * mutator method for step order
	 *
	 * @param int $newStepOrder new value of step order
	 * @throws \RangeException if 0 < $newStepOrder > 15
	 **/
	public function setStepOrder(int $newStepOrder) : void {
		if(!($newStepOrder >= 0 || $newStepOrder < 16)){
			throw(new \RangeException("too many steps added"));
		}

		// store the content
		$this->stepOrder = $newStepOrder;
	}//end of setStepOrder

	/**
	 * inserts this Step into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO step(stepId, stepTaskId, stepContent, stepOrder) VALUES(:stepId, :stepTaskId, :stepContent, :stepOrder)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["stepId" => $this->stepId->getBytes(), "stepTaskId" => $this->stepTaskId->getBytes(), "stepContent" => $this->stepContent, "stepOrder" => $this->stepOrder];
		$statement->execute($parameters);
	}// end of insert pdo

	/**
	 * Updates this Step into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE step SET stepId = :stepId, stepTaskId = :stepTaskId, stepContent = :stepContent, stepOrder = :stepOrder WHERE stepId = :stepId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["stepId" => $this->stepId->getBytes(), "stepTaskId" => $this->stepTaskId->getBytes(), "stepContent" => $this->stepContent, "stepOrder" => $this->stepOrder];
		$statement->execute($parameters);
	}// end of update pdo

	/**
	 * deletes this Step from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM step WHERE stepId = :stepId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["stepId" => $this->stepId->getBytes()];
		$statement->execute($parameters);
	} // end of delete pdo

	/**
	 * gets the Step by stepId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $stepId step id to search for
	 * @return Step|null Step found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getStepByStepId(\PDO $pdo, $stepId) : ?Step {
		// sanitize the stepId before searching
		try {
			$stepId = self::validateUuid($stepId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT stepId, stepTaskId, stepContent, stepOrder FROM step WHERE stepId = :stepId";
		$statement = $pdo->prepare($query);

		// bind the step id to the place holder in the template
		$parameters = ["stepId" => $stepId->getBytes()];
		$statement->execute($parameters);

		// grab the step from mySQL
		try {
			$step = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$step = new Step($row["stepId"], $row["stepTaskId"], $row["stepContent"], $row["stepOrder"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($step);
	} // end of getStepByStepId

	/**
	 * gets the Step by stepTaskId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $stepTaskId step task id to search for
	 * @return Step|null Step found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getStepByStepTaskId(\PDO $pdo, $stepTaskId) : ?Step {
		// sanitize the stepId before searching
		try {
			$stepTaskId = self::validateUuid($stepTaskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT stepId, stepTaskId, stepContent, stepOrder FROM step WHERE stepTaskId = :stepTaskId";
		$statement = $pdo->prepare($query);

		// bind the step id to the place holder in the template
		$parameters = ["stepTaskId" => $stepTaskId->getBytes()];
		$statement->execute($parameters);

		// grab the step from mySQL
		try {
			$step = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$step = new Step($row["stepId"], $row["stepTaskId"], $row["stepContent"], $row["stepOrder"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($step);
	} // end of getStepByStepTaskId


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["stepId"] = $this->stepId->toString();

		return($fields);
	} //end of json function
}//end of Step class