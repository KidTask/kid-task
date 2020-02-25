<?php


namespace Club\KidTask;

require_once("autoload.php");

require_once(dirname(__DIR__) . "/vendor/autoload.php");

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
class Task implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;

	//All STATE VARIABLES
	/**
	 * id for this Task; this is the primary key
	 * @var Uuid $taskId
	 **/
	private $taskId;

	/**
	 * adult id for this Task; this is the foreign key
	 * @var Uuid $taskAdultId
	 **/
	private $taskAdultId;

	/**
	 * kid id for this Task; this is a foreign key
	 * @var Uuid $taskKidId
	 **/
	private $taskKidId;


	/**
	 * avatar for this Task;
	 * @var string $taskAvatarUrl
	 **/
	private $taskAvatarUrl;

	/**
	 * id for this avatar from cloudinary Task;
	 * @var string $taskCloudinaryToken
	 **/
	private $taskCloudinaryToken;

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
	 * int showing progress of task
	 * @var int $taskIsComplete
	 **/
	private $taskIsComplete;

	/**
	 * reward for Task
	 * @var $taskReward
	 **/
	private $taskReward;


	/**
	 * constructor for this Task
	 *
	 * @param string|Uuid $newTaskId id of this Task
	 * @param string|Uuid $newTaskAdultId id of the Adult making task
	 * @param string|Uuid $newTaskKidId id if the Kid that has task
	 * @param string|null $newTaskAvatarUrl avatar URL of task
	 * @param string|null $newTaskCloudinaryToken id of avatar image for task
	 * @param string $newTaskContent string containing task content
	 * @param \DateTime|string|null $newTaskDueDate date and time Task is due
	 * @param int|null $newTaskIsComplete tiny int to show task if Task is complete
	 * @param string|null $newTaskReward string containing reward for Task
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct( $newTaskId, $newTaskAdultId, $newTaskKidId, ?string $newTaskAvatarUrl, ?string $newTaskCloudinaryToken,
										 string $newTaskContent, $newTaskDueDate = null, $newTaskIsComplete = null, ?string $newTaskReward ) {
		try {
			$this->setTaskId($newTaskId);
			$this->setTaskAdultId($newTaskAdultId);
			$this->setTaskKidId($newTaskKidId);
			$this->setTaskAvatarUrl($newTaskAvatarUrl);
			$this->setTaskCloudinaryToken($newTaskCloudinaryToken);
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
	 * @return Uuid value of task id
	 **/
	public function getTaskId(): Uuid {
		return ($this->taskId);
	}



	/**
	 * mutator method for task id
	 *
	 * @param Uuid|string $newTaskId value of new task id
	 * @throws \RangeException if $newTaskId is not positive
	 * @throws \TypeError if the task Id is not uuid or string
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
	 * accessor method for task  adult id
	 *
	 * @return Uuid value of task adult id
	 **/
	public function getTaskAdultId(): Uuid {
		return ($this->taskAdultId);
	} //end of getTaskAdultId

	/**
	 * mutator method for task adult id
	 *
	 * @param Uuid| string $newTaskAdultId value of new task adult id
	 * @throws \RangeException if $newTaskAdultId is not positive
	 * @throws \TypeError if the task adult Id is not
	 **/
	public function setTaskAdultId($newTaskAdultId): void {
		try {
			$uuid = self::validateUuid($newTaskAdultId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the task adult id
		$this->taskAdultId = $uuid;
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
	 * @throws \TypeError if the task kid Id is not a UUID
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
	 * accessor method for task avatar url
	 *
	 * @return string value of the task avatar url
	 */
	public function getTaskAvatarUrl(): ?string {
		return ($this->taskAvatarUrl);
	}

	/**
	 * mutator method for task avatar url
	 *
	 * @param string $newTaskAvatarUrl new value of task avatar url
	 * @throws \InvalidArgumentException  if the task avatar is not a string or insecure
	 * @throws \RangeException if the string is not less than 1000 characters
	 * @throws \TypeError if the task content is not a string
	 */
	public function setTaskAvatarUrl(?string $newTaskAvatarUrl): void {
		//verify url is secure
		$newTaskAvatarUrl = trim($newTaskAvatarUrl);
		$newTaskAvatarUrl = filter_var($newTaskAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newTaskAvatarUrl)===true) {
			throw(new \InvalidArgumentException("url is empty or insecure"));
		}
		//verify url will fit database
		if(strlen($newTaskAvatarUrl) > 255) {
			throw(new \RangeException("Adult avatar url is too large"));
		}

		$this->taskAvatarUrl = $newTaskAvatarUrl;
	}



	/**
	 * accessor method for task Cloudinary token
	 *
	 * @return string value of the task cloudinary token
	 */
	public function getTaskCloudinaryToken(): ?string {
		return ($this->taskCloudinaryToken);
	}

	/**
	 * mutator method for task cloudinary token
	 *
	 * @param string $newTaskCloudinaryToken new value of task cloudinary token
	 * @throws \InvalidArgumentException  if the task cloudinary token is not a string or insecure
	 * @throws \RangeException if the string is not less than 255 characters
	 * @throws \TypeError if the task content is not a string
	 */
	public function setTaskCloudinaryToken(?string $newTaskCloudinaryToken): void {
		$newTaskCloudinaryToken = trim($newTaskCloudinaryToken);
		$newTaskCloudinaryToken = filter_var($newTaskCloudinaryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTaskCloudinaryToken) === true) {
			$this->taskCloudinaryToken = null;
			return;
		}
		$newTaskCloudinaryToken = strtolower(trim($newTaskCloudinaryToken));
		if(ctype_xdigit($newTaskCloudinaryToken) === false) {
			throw(new\RangeException("task cloudinary token is not valid"));
		}
		//make sure user activation token is only 255 characters
		if(strlen($newTaskCloudinaryToken) > 255) {
			throw(new\RangeException("task cloudinary token has to be less than 255"));
		}
		$this->taskCloudinaryToken = $newTaskCloudinaryToken;
	}


	/**
	 * accessor method for task content
	 *
	 * @return string value of the task content
	 */
	public function getTaskContent(): string {
		return ($this->taskContent);
	}

	/**
	 * mutator method for task content
	 *
	 * @param string $newTaskContent new value of task content
	 * @throws \InvalidArgumentException  if the task content is not a string or insecure
	 * @throws \RangeException if the string is not less than 255 characters
	 * @throws \TypeError if the task content is not a string
	 */
	public function setTaskContent(string $newTaskContent): void {
		$newTaskContent = trim($newTaskContent);
		$newTaskContent = filter_var($newTaskContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTaskContent) === true) {
			throw(new \InvalidArgumentException("task content is empty or insecure"));
		}

		//make sure task content is only 255 characters
		if(strlen($newTaskContent) > 255) {
			throw(new\RangeException("task content has to be less than 255"));
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
			return;
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
	 * @return int value of task is complete
	 **/
	public function getTaskIsComplete(): ?int {
		return $this->taskIsComplete;
	}

	/**
	 * mutator method for task is complete
	 *
	 * @param int $newTaskIsComplete new value task is complete
	 * @throws \InvalidArgumentException if $newTaskIsComplete is not a valid int
	 * @throws \RangeException if $newTaskIsComplete is > 3
	 **/
	public function setTaskIsComplete(?int $newTaskIsComplete): void {
		// verify task is complete is 0, 1, 2
		$newTaskIsComplete = trim($newTaskIsComplete);
		$newTaskIsComplete = filter_var($newTaskIsComplete);
		if(empty($newTaskIsComplete) === true) {
			$this->taskIsComplete = null;
			return;
		}
		if(!($newTaskIsComplete === 0 || $newTaskIsComplete === 1 || $newTaskIsComplete === 2)) {
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
	public function getTaskReward(): ?string {
		return $this->taskReward;
	}

	/**
	 * mutator method for task Reward
	 *
	 * @param string $newTaskReward
	 * @throws \InvalidArgumentException if the task reward is not a string or not secure
	 * @throws \RangeException if the task Reward is not less than 255 characters
	 * @throws \TypeError if task reward is not a string
	 */
	public function setTaskReward(?string $newTaskReward): void {
		//enforce that the task reward is properly formatted

		$newTaskReward = trim($newTaskReward);
		$newTaskReward = filter_var($newTaskReward, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if($newTaskReward === null) {
		$this->taskReward = null;
		return;
		}
		//enforce that the reward is less than 255 characters.
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
		$query = "INSERT INTO task(taskId, taskAdultId, taskKidId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward) 
VALUES( :taskId, :taskAdultId, :taskKidId, :taskAvatarUrl, :taskCloudinaryToken,  :taskContent, :taskDueDate, :taskIsComplete, :taskReward)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->taskDueDate->format("Y-m-d H:i:s.u");

		$parameters = ["taskId" => $this->taskId->getBytes(), "taskAdultId" => $this->taskAdultId->getBytes(), "taskKidId" => $this->taskKidId->getBytes(),
			"taskAvatarUrl" => $this->taskAvatarUrl, "taskCloudinaryToken" => $this->taskCloudinaryToken,
			"taskContent" => $this->taskContent, "taskDueDate" => $formattedDate, "taskIsComplete"=> $this->taskIsComplete,
			"taskReward" => $this->taskReward ];

		$statement->execute($parameters);
	}



	/**
	 * updates this Task in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE task SET  taskId = :taskId, taskAdultId = :taskAdultId, taskKidId = :taskKidId, taskAvatarUrl = :taskAvatarUrl, taskCloudinaryToken = :taskCloudinaryToken,
    taskContent = :taskContent, taskDueDate = :taskDueDate, taskIsComplete = :taskIsComplete, taskReward = :taskReward WHERE taskId = :taskId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->taskDueDate->format("Y-m-d H:i:s.u");

		$parameters = ["taskId" => $this->taskId->getBytes(), "taskAdultId" => $this->taskAdultId->getBytes(), "taskKidId" => $this->taskKidId->getBytes(),
			"taskAvatarUrl" => $this->taskAvatarUrl, "taskCloudinaryToken" =>$this->taskCloudinaryToken,
			"taskContent" => $this->taskContent, "taskDueDate" => $formattedDate, "taskIsComplete"=> $this->taskIsComplete,
			"taskReward" => $this->taskReward];
		$statement->execute($parameters);
	}//end of update pdo method

	/**
	 * deletes this Task from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM task WHERE taskId = :taskId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["taskId" => $this->taskId->getBytes()];
		$statement->execute($parameters);
	} //end of delete pdo method




	/**
	 * gets the task by taskId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $taskId task id to search for
	 * @return Task|null task found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTaskByTaskId(\PDO $pdo, $taskId) : ?Task {
		// sanitize the taskId before searching
		try {
			$taskId = self::validateUuid($taskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT taskId, taskAdultId, taskKidId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskId = :taskId";
		$statement = $pdo->prepare($query);

		// bind the Adult id to the place holder in the template
		$parameters = ["taskId" => $taskId->getBytes()];
		$statement->execute($parameters);

		// grab the task from mySQL
		try {
			$task = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$task = new Task($row["taskId"], $row["taskAdultId"], $row["taskKidId"], $row["taskAvatarUrl"], $row["taskCloudinaryToken"], $row["taskContent"], $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($task);
	} // end of getTaskByTaskId




	/**
	 * Gets all tasks by task kid id.
	 *
	 * @param \PDO $pdo The database connection object.
	 * @param Uuid $taskKidId The kid id associate with task.
	 * @return \SplFixedArray An array of task objects that match the task adult id.
	 * @throws \PDOException MySQL errors generated by the statement.
	 **/
	public static function getTaskByTaskKidId(\PDO $pdo, Uuid $taskKidId) : \SplFixedArray {
		try {
			// sanitize the taskKidId before searching
			$taskKidId = self::validateUuid($taskKidId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT taskId, taskAdultId, taskKidId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskKidId = :taskKidId";
		$statement = $pdo->prepare($query);

		// bind the task kid id to the place holder in the template
		$parameters = ["taskKidId" => $taskKidId->getBytes()];
		$statement->execute($parameters);

		// build an array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tasks = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$tasks = new Task($row["taskId"], $row["taskAdultId"], $row["taskKidId"],
						$row["taskAvatarUrl"], $row["taskCloudinaryToken"],
						$row["taskContent"], $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
				}
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);
	}



	/**
	 * gets the Tasks by task content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $taskContent task content to search for
	 * @return \SplFixedArray SplFixedArray of Tasks found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTaskByTaskContent(\PDO $pdo, string $taskContent) : \SplFixedArray {
		// sanitize the description before searching
		$taskContent = trim($taskContent);
		$taskContent = filter_var($taskContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($taskContent) === true) {
			throw(new \PDOException("task content is invalid"));
		}

		// escape any mySQL wild cards
		$taskContent = str_replace("_", "\\_", str_replace("%", "\\%", $taskContent));

		// create query template
		$query = "SELECT taskId, taskAdultId, taskKidId,  taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskContent = :taskContent";
		$statement = $pdo->prepare($query);

		// bind the task content to the place holder in the template
		$taskContent = "%$taskContent%";
		$parameters = ["taskContent" => $taskContent];
		$statement->execute($parameters);

		// build an array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$task = new Task($row["taskId"], $row["taskAdultId"], $row["taskKidId"],
					$row["taskAvatarUrl"], $row["taskCloudinaryToken"],
					$row["taskContent"], $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
				$tasks[$tasks->key()] = $task;
				$tasks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);
	}



	/**
	 * Gets all tasks posted by task adult id.
	 *
	 * @param \PDO $pdo The database connection object.
	 * @param string $taskAdultId The adult id associate with task.
	 * @return \SplFixedArray An array of task objects that match the task adult id.
	 * @throws \PDOException MySQL errors generated by the statement.
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTaskByTaskAdultId(\PDO $pdo, $taskAdultId) : \SPLFixedArray {
		try {
			// sanitize the taskAdultId before searching
			$taskAdultId = self::validateUuid($taskAdultId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT taskId, taskAdultId, taskKidId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskAdultId = :taskAdultId";
		$statement = $pdo->prepare($query);

		// bind the task adult id to the place holder in the template
		$parameters = ["taskAdultId" => $taskAdultId->getBytes()];
		$statement->execute($parameters);

		// build an array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {

					$task = new Task($row["taskId"], $row["taskAdultId"], $row["taskKidId"],
						$row["taskAvatarUrl"], $row["taskCloudinaryToken"],
						$row["taskContent"], $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
					$tasks[$tasks->key()] = $task;
					$tasks->next();

			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);
	} // end of getTasksByTaskAdultId




	/**
	 * gets the Tasks by task is complete
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $taskIsComplete task completion level
	 * @return \SplFixedArray An array of task objects that show completion levels.
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTaskByTaskIsComplete(\PDO $pdo, int $taskIsComplete) : \SplFixedArray {
		try {
			// sanitize the int before searching
			$taskIsComplete = filter_var($taskIsComplete, FILTER_SANITIZE_NUMBER_INT);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// verify task is complete is 0, 1, 2
		if(empty($taskIsComplete) === true) {
			$taskIsComplete = null;
		}
		if(!($taskIsComplete === 0 || $taskIsComplete === 1 || $taskIsComplete === 2)) {
			throw(new \InvalidArgumentException("task is complete should be a whole number between 0-2"));
		}


		// create query template
		$query = "SELECT taskId, taskAdultId, taskKidId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskIsComplete = :taskIsComplete";
		$statement = $pdo->prepare($query);


		// bind the task is complete to the place holder in the template
		$parameters = ["taskIsComplete" => $taskIsComplete];
		$statement->execute($parameters);


		// build an array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$task = new Task($row["taskId"], $row["taskAdultId"], $row["taskKidId"],
					$row["taskAvatarUrl"], $row["taskCloudinaryToken"],
					$row["taskContent"], $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
				$tasks[$tasks->key()] = $task;
				$tasks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);


	} // end of getTaskByTaskIsComplete







	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["taskId"] = $this->taskId->toString();
		$fields["taskAdultId"] = $this->taskAdultId->toString();
		$fields["taskKidId"] = $this->taskKidId->toString();


		//format the date so that the front end can consume it
		$fields["taskDueDate"] = round(floatval($this->taskDueDate->format("U.u")) * 1000);
		return($fields);
	}


} // End of Task class

