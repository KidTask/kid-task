<?php

namespace Club\KidTask\Test;
use Club\KidTask\{
	Adult, Kid, Task, Step
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Task class
 *
 * This is a complete PHPUnit test of the Like class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Task
 * @author Demetria Gutierrez <fullstack@calyx.studio>
 **/
class TaskTest extends KidTaskTest {

	/**
	 * Adult that created the Task; this is for foreign key relations
	 * @var string Adult profile
	 **/
	protected $adult = null;


	/**
	 * Kid that is assigned the Task; this is for foreign key relations
	 * @var string Kid profile
	 **/
	protected $kid = null;


	/**
	 * Avatar Url for Task
	 * @var string $VALID_AVATAR_URL
	 */
	protected $VALID_AVATAR_URL = "https://images.unsplash.com/photo-1543373894-5e1d9d237f41?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=751&q=80";

	/**
	 * Cloudinary token for Task
	 * @var string $VALID_CLOUDINARY_TOKEN
	 */
	protected $VALID_CLOUDINARY_TOKEN = null;

	/**
	 * valid kid hash to create the adult profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;


	/**
	 * content of the Task
	 * @var string $VALID_TASKCONTENT
	 **/
	protected $VALID_TASKCONTENT = "PHPUnit test passing";

	/**
	 * content of the Task
	 * @var string $VALID_TASKCONTENT2
	 **/
	protected $VALID_TASKCONTENT2 = "This PHPUnit test is also passing";

	/**
	 * Task due date; this starts as null and is assigned later
	 * @var \DateTime $VALID_TASKDUEDATE
	 **/
	protected $VALID_TASKDUEDATE = null;

	/**
	 * if Task is complete
	 * @var int $VALID_TASKISCOMPLETE
	 **/
	protected $VALID_TASKISCOMPLETE = 0;

	/**
	 * reward for Task
	 * @var string $VALID_TASKREWARD
	 **/
	protected $VALID_TASKREWARD = "You get $5";


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 7]);

		// create and insert a Adult to own the test Task
		$this->adult = new Adult(generateUuidV4(), null,"https://images.unsplash.com/photo-1539213690067-dab68d432167?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_HASH,  "Mom", "Mother");
		$this->adult->insert($this->getPDO());

		// create and insert a Kid to own the test Task
		$this->kid = new Kid(generateUuidV4(), null,"https://images.unsplash.com/photo-1539213690067-dab68d432167?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif",$this->VALID_HASH, "Timothy" , "Ocho");
		$this->kid->insert($this->getPDO());


		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_TASKDUEDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

	}

	/**
	 * test inserting a valid Task and verify that the actual mySQL data matches
	 *
	 * @throws \Exception
	 */
	public function testInsertValidTask(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();


		$task = new Task(taskId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate(), $this->VALID_TASKDUEDATE);
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);

	}

	/**
	 * test creating a Task and then deleting it
	 *
	 * @throws \Exception
	 */
	public function testDeleteValidTask(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());


		// delete the Task from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$task->delete($this->getPDO());

		// grab the data from mySQL and enforce the Task does not exist
		$pdoTask = Kid::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertNull($pdoTask);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("task"));
	}

	/**
	 * test inserting a Task and regrabbing it from mySQL
	 *
	 * @throws \Exception
	 */
	public function testGetValidTaskByTaskId(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate(), $this->VALID_TASKDUEDATE);
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);
	}
	/**
	 * test grabbing a Task that does not exist
	 **/
	public function testGetInvalidTaskByTaskId(): void
	{
		// grab a Kid id that exceeds the maximum allowable Kid id
		$fakeTaskId = generateUuidV4();
		$task = Task::getTaskByTaskId($this->getPDO(), $fakeTaskId);
		$this->assertNull($task);
	}


	/**
	 * test grabbing a Task by task content
	 **/
	public function testGetValidTaskByTaskContent(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskContent($this->getPDO(), $task->getTaskContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate(), $this->VALID_TASKDUEDATE);
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);
	}


	/**
	 * test grabbing a Task by Task Adult Id
	 */
	public function testGetValidTaskByTaskAdultId() : void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate(), $this->VALID_TASKDUEDATE);
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);
	}

	/**
	 * test grabbing a Task by Task Adult Id
	 */
	public function testGetValidTaskByTaskIsComplete() : void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskIsComplete($this->getPDO(), $task->getTaskIsComplete());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate(), $this->VALID_TASKDUEDATE);
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);
	}



}// end of TaskTest