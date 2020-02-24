<?php

namespace Club\KidTask\Test;

use Club\KidTask\{
	Adult, Kid, Task
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * PHPUnit test for the Task class
 *
 * This is a complete PHPUnit test of the Task class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Task
 * @author Demetria Gutierrez <fullstack@calyx.studio>
 **/
class TaskTest extends KidTaskTest {

	/**
	 * Adult that created the Task; this is for foreign key relations
	 * @var string Adult
	 **/
	protected $adult = null;


	/**
	 * Kid that is assigned the Task; this is for foreign key relations
	 * @var string Kid
	 **/
	protected $kid = null;


	/**
	 * Avatar Url for Task
	 * @var string $VALID_AVATAR_URL
	 */
	protected $VALID_AVATAR_URL = "https://media.giphy.com/media/szxw88uS1cq4M/giphy.gif";

	/**
	 * Cloudinary token for Task
	 * @var string $VALID_CLOUDINARY_TOKEN
	 */
	protected $VALID_CLOUDINARY_TOKEN = null;

	/**
	 * valid hash to create the adult + kid object to own the test
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
	 * if Task is complete
	 * @var int $VALID_TASKISCOMPLETE2
	 **/
	protected $VALID_TASKISCOMPLETE2 = 1;

	/**
	 * reward for Task
	 * @var string $VALID_TASKREWARD
	 **/
	protected $VALID_TASKREWARD = "You get $5";

	/**
	 * Valid timestamp to use as sunriseTweetDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetTweetDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 * @throws \Exception
	 **/
	public final function setUp(): void {

		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 7]);

		// create and insert a Adult to own the test Task
		$this->adult = new Adult(generateUuidV4(), null, "https://images.unsplash.com/photo-1539213690067-dab68d432167?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80", "null", "test@phpunit.co", $this->VALID_HASH, "Mom", "Mother");
		$this->adult->insert($this->getPDO());

		// create and insert a Kid to own the test Task
		$this->kid = new Kid(generateUuidV4(), $this->adult->getAdultId(), "https://images.unsplash.com/photo-1539213690067-dab68d432167?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80", "null", $this->VALID_HASH, "Timothy", "Ocho");
		$this->kid->insert($this->getPDO());


		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_TASKDUEDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

	} //end setup function

	/**
	 * test inserting a valid Task and verify that the actual mySQL data matches
	 *
	 * @throws \Exception
	 */
	public function testInsertValidTask(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		// Create a new task and insert into mySQL
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
		$this->assertEquals($pdoTask->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE -> getTimestamp());
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);

	} // end testInsertValidTask


	/**
	 * test inserting a Task, editing it, and then updating it
	 *
	 * @throws \Exception
	 **/
	public function testUpdateValidTask(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		// Create a new task and insert into mySQL
		$taskId = generateUuidV4();

		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// edit the Task and update it in mySQL
		$task->setTaskContent($this->VALID_TASKCONTENT2);
		$task->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId()->toString(), $taskId->toString());
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE -> getTimestamp());
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);

	} // end testUpdateValidTask



	/**
	 * test creating a Task and then deleting it
	 *
	 * @throws \Exception
	 */
	public function testDeleteValidTask(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());


		// delete the Task from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$task->delete($this->getPDO());

		// grab the data from mySQL and enforce the Task does not exist
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertNull($pdoTask);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("task"));
	}

	/**
	 * test inserting a Task and regrabbing it from mySQL
	 *
	 * @throws \Exception
	 */
	public function testGetValidTaskByTaskId(): void {
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
	public function testGetInvalidTaskByTaskId(): void {
		// grab a Kid id that exceeds the maximum allowable Kid id
		$fakeTaskId = generateUuidV4();
		$task = Task::getTaskByTaskId($this->getPDO(), $fakeTaskId);
		$this->assertNull($task);
	}


	/**
	 * test grabbing a Task by Task Adult Id
	 */
	public function testGetValidTaskByTaskAdultId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTask = Task::getTaskByTaskAdultId($this->getPDO(), $task->getTaskId());
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
	public function testGetInvalidTaskByTaskAdultId(): void {
		// grab a task id that exceeds the maximum allowable task Adult id
		$task = Task::getTaskByTaskAdultId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $task);
	}

	/**
	 * test grabbing a Task by task content
	 *
	 * @throws \Exception
	 **/
	public function testGetValidTaskByTaskContent(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations

		$results = Task::getTaskByTaskContent($this->getPDO(), $task->getTaskContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertCount(0, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Club\\KidTask", $results);


		// grab the results from the array and validate it
		$pdoTask = $results[0];
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate()->getTimestamp, $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);
	}

	/**
	 * test grabbing a Task that does not exist
	 **/
	public function testGetInvalidTaskByTaskContent(): void {
		// grab a task by content that does not exist
		$task = Task::getTaskByTaskContent($this->getPDO(), "this is not real content");
		$this->assertCount(0, $task);
	}



	/**
	 * test grabbing a Task by Task is complete
	 */
	public function testGetValidTaskByTaskIsComplete(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("task");

		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->adult->getAdultId(), $this->kid->getKidId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_TASKCONTENT, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKREWARD);
		$task->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Task::getTaskByTaskIsComplete($this->getPDO(), $task->getTaskIsComplete());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertCount(0, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Club\\KidTask", $results);

		// grab the result from the array to validate it
		$pdoTask = $results[0];
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskAdultId(), $this->adult->getAdultId());
		$this->assertEquals($pdoTask->getTaskKidId(), $this->kid->getKidId());
		$this->assertEquals($pdoTask->getTaskAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoTask->getTaskCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoTask->getTaskContent(), $this->VALID_TASKCONTENT);
		$this->assertEquals($pdoTask->getTaskDueDate() ->getTimestamp(), $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskReward(), $this->VALID_TASKREWARD);
	}


}// end of TaskTest