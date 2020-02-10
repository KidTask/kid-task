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
class Task {
	use ValidateUuid;

	//All STATE VARIABLES
	/**
	 * id for this Task; this is the primary key
	 * @var Uuid $taskId
	 **/
	private $taskId;

	/**
	 * kid id for this Task; this is a foreign key
	 * @var Uuid $taskKidId
	 **/
	private $taskKidId;

	/**
	 * parent id for this Task; this is the foreign key
	 * @var Uuid $taskParentId
	 **/
	private $taskParentId;

	/**
	 * avatar for this Task;
	 * @var Uuid $taskAvatarUrl
	 **/
	private $taskAvatarUrl;

	/**
	 * id for this avatar from cloudinary Task;
	 * @var Uuid $taskCloudinaryToken
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
	 * tinyint showing progress of task
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
	 * @param string|Uuid $newTaskKidId id if the Kid that has task
	 * @param string|Uuid $newTaskParentId id of the Parent making task
	 * @param string|null $newTaskAvatarUrl avatar URL of task
	 * @param string|null $newTaskCloudinaryToken id of avatar image for task
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
	public function __construct($newTaskId, $newTaskKidId, $newTaskParentId, $newTaskAvatarUrl, $newTaskCloudinaryToken,
										 $newTaskContent, $newTaskDueDate, $newTaskIsComplete, $newTaskReward = null) {
		try {
			$this->setTaskId($newTaskId);
			$this->setTaskKidId($newTaskKidId);
			$this->setTaskParentId($newTaskParentId);
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
	 * accessor method for task avatar url
	 *
	 * @return string value of the task avatar url
	 */
	public function getTaskAvatarUrl(): string {
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
	public function setTaskAvatarUrl(string $newTaskAvatarUrl): void {
		$newTaskAvatarUrl = trim($newTaskAvatarUrl);
		$newTaskAvatarUrl = filter_var($newTaskAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTaskAvatarUrl) === true) {
			$this->taskAvatarUrl = null;
			return;
		}
		$newTaskAvatarUrl = strtolower(trim($newTaskAvatarUrl));
		if(ctype_xdigit($newTaskAvatarUrl) === false) {
			throw(new\RangeException("task avatar url is not valid"));
		}
		//make sure user activation token is only 1000 characters
		if(strlen($newTaskAvatarUrl) > 1000) {
			throw(new\RangeException("task avatar url has to be less than 1000"));
		}
		$this->taskAvatarUrl = $newTaskAvatarUrl;
	}



	/**
	 * accessor method for task Cloudinary token
	 *
	 * @return string value of the task cloudinary token
	 */
	public function getTaskCloudinaryToken(): string {
		return ($this->taskCloudinaryToken);
	}

	/**
	 * mutator method for task cloudinary token
	 *
	 * @param string $newTaskCloudinaryToken new value of task cloudinary token
	 * @throws \InvalidArgumentException  if the task cloudinary token is not a string or insecure
	 * @throws \RangeException if the string is not less than 1000 characters
	 * @throws \TypeError if the task content is not a string
	 */
	public function setTaskCloudinaryToken(string $newTaskCloudinaryToken): void {
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
		//make sure user activation token is only 1000 characters
		if(strlen($newTaskCloudinaryToken) > 1000) {
			throw(new\RangeException("task cloudinary token has to be less than 1000"));
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
	 * @throws \RangeException if the string is not less than 1000 characters
	 * @throws \TypeError if the task content is not a string
	 */
	public function setTaskContent(string $newTaskContent): void {
		$newTaskContent = trim($newTaskContent);
		$newTaskContent = filter_var($newTaskContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTaskContent) === true) {
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
		$newTaskReward = filter_var($newTaskReward, FILTER_SANITIZE_STRING, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTaskReward) === true) {
		$this->taskReward = null;
		return;
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
		$query = "INSERT INTO task(taskId,taskKidId ,taskParentId, taskAvataryUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward) 
VALUES( :taskId, :taskKidId, :taskParentId, :taskAvatarUrl, :taskCloudinaryToken,  :taskContent, :taskDueDate, :taskIsComplete, :taskReward)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->taskDueDate->format("Y-m-d H:i:s.u");
		$parameters = ["taskId" => $this->taskId->getBytes(), "taskKidId" => $this->taskKidId, "taskParentId" => $this->taskParentId->getBytes(),
			"taskAvatarUrl" => $this->taskAvatarUrl, "taskCloudinaryToken" => $this->taskCloudinaryToken,
			"taskContent" => $this->taskContent->, "taskDueDate" => $formattedDate, "taskIsComplete"=> $this->taskIsComplete->(),
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
		$query = "UPDATE task SET  taskKidId = :taskKidId, taskParentId = :taskParentId,
    taskAvatarUrl = :taskAvatarUrl, taskCloudinaryToken = :taskCloudinaryToken,
    taskContent = :taskContent, taskDueDate = :taskDueDate, taskIsComplete = :taskIsComplete, taskReward = :taskReward WHERE taskId = :taskId";
		$statement = $pdo->prepare($query);

		$parameters = ["taskId" => $this->taskId->getBytes(), "taskKidId" => $this->taskKidId->getBytes(), "taskParentId" => $this->taskParentId->getBytes(),
			"taskAvatarUrl" => $this->taskAvatarUrl, "taskCloudinaryToken" =>$this->taskCloudinaryToken,
			"taskContent" => $this->taskContent->, "taskDueDate" => $formattedDate, "taskIsComplete"=> $this->taskIsComplete->,
			"taskReward" => $this->taskReward->];
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
	}//end of delete pdo method



	/**
	 * Gets all tasks by task kid id.
	 *
	 * @param \PDO $pdo The database connection object.
	 * @param Uuid $taskKidId The kid id associate with task.
	 * @return \SplFixedArray An array of task objects that match the task parent id.
	 * @throws \PDOException MySQL errors generated by the statement.
	 **/
	public static function getTasksByTaskKidId(\PDO $pdo, Uuid $taskKidId) : \SplFixedArray {
		try {
			// sanitize the taskKidId before searching
			$taskKidId = self::validateUuid($taskKidId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT taskId,taskKidId ,taskParentId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskKidId = :taskKidId";
		$statement = $pdo->prepare($query);

		// bind the task kid id to the place holder in the template
		$parameters = ["taskKidId" => $taskKidId->getBytes()];
		$statement->execute($parameters);

		// grab the tasks from mySQL
		try {
			$tasks = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tasks = new Task($row["taskId"], $row["taskKidId"], $row["taskParentId"],
					$row["taskAvatarUrl"], $row["taskCloudinaryToken"], $row["taskContent"] , $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
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
		$query = "SELECT taskId,taskKidId ,taskParentId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskContent = :taskContent";
		$statement = $pdo->prepare($query);

		// bind the tweet content to the place holder in the template
		$taskContent = "%$taskContent%";
		$parameters = ["taskContent" => $taskContent];
		$statement->execute($parameters);

		// build an array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$task = new Task($row["taskId"], $row["taskKidId"], $row["taskParentId"],
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
	 * Gets all tasks posted by task parent id.
	 *
	 * @param \PDO $pdo The database connection object.
	 * @param Uuid $taskParentId The parent id associate with task.
	 * @return \SplFixedArray An array of task objects that match the task parent id.
	 * @throws \PDOException MySQL errors generated by the statement.
	 **/
	public static function getTasksByTaskParentId(\PDO $pdo, Uuid $taskParentId) : \SplFixedArray {
		try {
			// sanitize the taskParentId before searching
			$taskParentId = self::validateUuid($taskParentId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT taskId,taskKidId ,taskParentId, taskAvatarUrl, taskCloudinaryToken, taskContent, taskDueDate, taskIsComplete, taskReward FROM task WHERE taskParentId = :taskParentId";
		$statement = $pdo->prepare($query);

		// bind the task parent id to the place holder in the template
		$parameters = ["taskParentId" => $taskParentId->getBytes()];
		$statement->execute($parameters);

		// grab the tasks from mySQL
		try {
			$tasks = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tasks = new Task($row["taskId"], $row["taskKidId"], $row["taskParentId"],
					$row["taskAvatarUrl"], $row["taskCloudinaryToken"],
					$row["taskContent"] , $row["taskDueDate"], $row["taskIsComplete"], $row["taskReward"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($tasks);
	}






	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["taskId"] = $this->taskId->toString();
		$fields["taskKidId"] = $this->taskKidId->toString();
		$fields["taskParentId"] = $this->taskParentId->toString();

		//format the date so that the front end can consume it
		$fields["taskDueDate"] = round(floatval($this->taskDueDate->format("U.u")) * 1000);
		return($fields);
	}

}