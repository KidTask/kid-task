<?php


namespace Club\KidTask;

require_once("autoload.php");

require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Cassandra\Tinyint;
use Ramsey\Uuid\Uuid;

/**
 *
 * Phase 1
 *State Variables, Accessors, Mutators, and constructor
 * *Write and document all state variables in the class.
 * *Write and document an accessor/getter method for each state variable.
 * *Write and document a mutator/setter method for each state variable.
 * *Write and document constructor method.
 *
 * @author Demetria Gutierrez <fullstack@calyx.studio>
 * @version 4.0.0
 **/
class Task {
	use ValidateUuid;

	//All STATE VARIABLES
	/**
	 * id for this Task; this is the primary key
	 * @var Uuid $taskId
	 **/
	private $taskId;


	/**
	 * id for this Task; this is the foreign key
	 * @var Uuid $taskParentId
	 **/
	private $taskParentId;

	/**
	 * id for this Task; this is a foreign key
	 * @var Uuid $taskKidId
	 **/
	private $taskKidId;


	/**
	 * task content
	 * @var string $taskContent
	 **/
	private $taskContent;

	/**
	 * Date for this Task
	 * @var \DateTime $taskDueDate
	 **/
	private $taskDueDate;

	/**
	 * email for this Author; this is a unique index
	 * @var Tinyint $taskIsComplete
	 **/
	private $taskIsComplete;
	/**
	 * reward for Task
	 * @var $taskReward
	 **/
	private $taskReward;




	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newTaskId id of this Task or null if a new Author
	 * @param string|Uuid $newTaskParentId id of the Parent making task
	 * @param string|Uuid $newTaskKidId id if the Kid that has task
	 * @param string $newTaskContent string containing task content
	 * @param \DateTime|string|null $newTaskDueDate date and time Task is due
	 * @param Tinyint|null $newTaskIsComplete tiny int to show task if Task is complete
	 * @param string|null $newTaskReward string containing reward for Task
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newTaskId, $newTaskParentId, $newTaskKidId, $newTaskContent, $newTaskDueDate,
										 $newTaskIsComplete, $newTaskReward = null) {
		try {
			$this->setTaskId($newTaskId);
			$this->setTaskParentId($newTaskParentId);
			$this->setTaskKidId($newTaskKidId);
			$this->setTaskContent($newTaskContent);
			$this->setTaskDueDate($newTaskDueDate);
			$this->setTaskIsComplete($newTaskIsComplete);
			$this->setTaskReward($newTaskReward);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for task id
	 *
	 * @return Uuid value of task id (or null if new Task)
	 **/
	public function getTaskId(): Uuid {
		return ($this->taskId);
	}

	/**
	 * mutator method for task id
	 *
	 * @param Uuid| string $newTaskId value of new task id
	 * @throws \RangeException if $newTaskId is not positive
	 * @throws \TypeError if the task Id is not
	 **/
	public function setTaskId($newTaskId): void {
		try {
			$uuid = self::validateUuid($newTaskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the task id
		$this->taskId = $uuid;
	}

	/**
	 * accessor method for task by parent id
	 *
	 * @return Uuid value of task parent id (or null if new Task)
	 **/
	public function getTaskParentId(): Uuid {
		return ($this->taskParentId);
	}

	/**
	 * mutator method for task parent id
	 *
	 * @param Uuid| string $newTaskParentId value of new task parent id
	 * @throws \RangeException if $newTaskParentId is not positive
	 * @throws \TypeError if the task parent Id is not
	 **/
	public function setTaskParentId($newTaskParentId): void {
		try {
			$uuid = self::validateUuid($newTaskParentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the task parent id
		$this->taskParentId = $uuid;
	}

	/**
	 * accessor method for task kid id
	 *
	 * @return Uuid value of task kid id (or null if new Task)
	 **/
	public function getTaskKidId(): Uuid {
		return ($this->taskKidId);
	}

	/**
	 * mutator method for task kid id
	 *
	 * @param Uuid| string $newTaskKidId value of new task kid id
	 * @throws \RangeException if $newTaskKidId is not positive
	 * @throws \TypeError if the task kid Id is not
	 **/
	public function setTaskKidId($newTaskKidId): void {
		try {
			$uuid = self::validateUuid($newTaskKidId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the task kid id
		$this->taskKidId = $uuid;
	}


	/**
	 * accessor method for task content
	 *
	 * @return string value of the task content
	 */
	public function getTaskContent(): ?string {
		return ($this->taskContent);
	}

	/**
	 * mutator method for task content
	 *
	 * @param string $newTaskContent new value of task content
	 * @throws \InvalidArgumentException  if the task content is not a string or insecure
	 * @throws \RangeException if the string is not less than 1000 characters
	 * @throws \TypeError if the task content is not a string
	 */
	public function setTaskContent(?string $newTaskContent): void {
		if($newTaskContent === null) {
			$this->taskContent = null;
			return;
		}
		$newTaskContent = strtolower(trim($newTaskContent));
		if(ctype_xdigit($newTaskContent) === false) {
			throw(new\RangeException("task content is not valid"));
		}
		//make sure user activation token is only 1000 characters
		if(strlen($newTaskContent) > 1000) {
			throw(new\RangeException("task content has to be less than 1000"));
		}
		$this->taskContent = $newTaskContent;
	}


	/**
	 * accessor method for task due date
	 *
	 * @return \DateTime value of task due date
	 **/
	public function getTaskDueDate(): \DateTime {
		return $this->taskDueDate;
	}

	/**
	 * mutator method for task due date
	 *
	 * @param \DateTime|string|null $newTaskDueDate new task due date as a DateTime object or string
	 * (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTaskDueDate is not a valid object or string
	 * @throws \RangeException if $newTaskDueDate is a date that does not exist
	 * @throws \Exception if some other error occurs
	 **/
	public function setTaskDueDate($newTaskDueDate = null): void {
		// base case: if the date is null, use the current date and time
		if($newTaskDueDate === null) {
			$this->taskDueDate = new \DateTime();
		}
		// store the task due date using the ValidateDate trait
		try {
			$newTaskDueDate = self::validateDateTime($newTaskDueDate);
		} catch(\InvalidArgumentException |  \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType ($exception->getMessage(), 0, $exception));

		}
		$this->taskDueDate = $newTaskDueDate;
	}

	/**
	 * accessor method for task is complete
	 *
	 * @return Tinyint value of task is complete
	 **/
	public function getTaskIsComplete(): Tinyint {
		return $this->taskIsComplete;
	}

	/**
	 * mutator method for task is complete
	 *
	 * @param Tinyint $newTaskIsComplete new value task is complete
	 * @throws \InvalidArgumentException if $newTaskIsComplete is not a valid int
	 * @throws \RangeException if $newTaskIsComplete is > 3
	 **/
	public function setTaskIsComplete(Tinyint $newTaskIsComplete): void {
		// verify task is complete is 0, 1, 2
		$newTaskIsComplete = trim($newTaskIsComplete);
		$newTaskIsComplete = filter_var($newTaskIsComplete);
		if(!($newTaskIsComplete === 0 || $newTaskIsComplete === 1 || $newTaskIsComplete === 2) ) {
			throw(new \InvalidArgumentException("task is complete should be a whole number between 0-2"));
		}

		// store the task is complete
		$this->taskIsComplete = $newTaskIsComplete;
	}

	/**
	 * accessor method for taskReward
	 *
	 * @return string value of task Reward
	 */
	public function getTaskReward(): string {
		return $this->getTaskReward();
	}

	/**
	 * mutator method for task Reward
	 *
	 * @param string $newTaskReward
	 * @throws \InvalidArgumentException if the task reward is empty or not secure
	 * @throws \RangeException if the task Reward is not less than 255 characters
	 * @throws \TypeError if task reward is not a string
	 */
	public function setTaskReward(string $newTaskReward): void {
		//enforce that the task reward is properly formatted
		$newTaskReward = trim($newTaskReward);
		if(empty($newTaskReward) === true) {
			throw(new \InvalidArgumentException("task reward empty or insecure"));
		}
		//enforce that the hash is less than 255 characters.
		if(strlen($newTaskReward) > 255) {
			throw(new \RangeException("task reward must be less than 255 characters"));
		}
		//store the task reward
		$this->taskReward = $newTaskReward;
	}

	/**
	 * inserts this Task into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO task(taskId,taskParentId,taskKidId, taskContent, taskDueDate, taskIsComplete, taskReward) 
VALUES( :taskId, :taskParentId, :taskKidId, :taskContent, :taskDueDate, :taskIsComplete, :taskReward)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->taskDueDate->format("Y-m-d H:i:s.u");
		$parameters = ["taskId" => $this->taskId->getBytes(), "taskParentId" => $this->taskParentId->getBytes(), "taskKidId" => $this->taskKidId,
			"taskContent" => $this->taskContent->getBytes(), "taskDueDate" => $formattedDate, "taskIsComplete"=> $this->taskIsComplete->getBytes(),
			"taskReward" => $this->taskReward->getBytes() ];
		$statement->execute($parameters);
	}

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
		// sanitize the parentActivationToken before searching
		$parentActivationToken = strtolower(trim($parentActivationToken));
		if(ctype_xdigit($ParentActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
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
	} // end of getParentByActivationToken

}