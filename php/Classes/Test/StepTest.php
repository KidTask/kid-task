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
 * Full PHPUnit test for the Adult class
 *
 * This is a complete PHPUnit test of the Adult class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Step
 * @author Gabriel Town <gtown@cnm.edu>
 **/
class StepTest extends KidTaskTest {
	/**
	 * valid activation for adult
	 * @var $VALID_ACTIVATION;
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid hash to create the adult + kid object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid content of step
	 * @var string $VALID_STEP_CONTENT
	 */
	protected $VALID_STEP_CONTENT = "Pick up shoes.";

	/**
	 * valid order for step
	 * @var int $VALID_STEP_ORDER
	 **/
	protected $VALID_STEP_ORDER = 1;

	/**
	 * valid order for step
	 * @var int $VALID_STEP_ORDER2
	 **/
	protected $VALID_STEP_ORDER2 = 5;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();

		$password = "password_what";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 7]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));


		// create and insert a Adult to own the test Task
		$this->adult = new Adult(generateUuidV4(), $this->VALID_ACTIVATION, "https://images.unsplash.com/photo-1539213690067-dab68d432167?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80", null, "test@phpunit.co", $this->VALID_HASH, "Ben", "BenDover");
		$this->adult->insert($this->getPDO());

		// create and insert a Kid to own the test Task
		$this->kid = new Kid(generateUuidV4(), $this->adult->getAdultId(), "https://images.unsplash.com/photo-1539213690067-dab68d432167?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80", "adfdf435gsdf86434gfd", $this->VALID_HASH, null, "BenDoverSon");
		$this->kid->insert($this->getPDO());

		// create and insert a Task for this test
		$this->task = new Task(generateUuidV4(), $this->adult->getAdultId(), $this->kid->getKidId(), "https://www.fillmurray.com/g/200/300", null, $this->VALID_STEP_CONTENT, null, 0, "You get a pony!");
		$this->task->insert($this->getPDO());
	} //end of setUp()

	/**
	 * test inserting a valid Step and verify that the actual mySQL data matches
	 **/
	public function testInsertValidStep() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("step");

		$stepId = generateUuidV4();

		// create a new Step and insert to into mySQL
		$step = new Step($stepId, $this->task->getTaskId(), $this->VALID_STEP_CONTENT, $this->VALID_STEP_ORDER);
		$step->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoStep = Step::getStepByStepId($this->getPDO(), $step->getStepId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("step"));
		$this->assertEquals($pdoStep->getStepTaskId(), $this->task->getTaskId());
		$this->assertEquals($pdoStep->getStepContent(), $this->VALID_STEP_CONTENT);
		$this->assertEquals($pdoStep->getStepOrder(), $this->VALID_STEP_ORDER);
	} // end of testInsertValidStep()

	/**
	 * test inserting a Adult, editing it, and then updating it
	 **/
	public function testUpdateValidStep() {
// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("step");

// create a new Step and insert to into mySQL
		$stepId = generateUuidV4();
		// create a new Step and insert to into mySQL
		$step = new Step($stepId, $this->task->getTaskId(), $this->VALID_STEP_CONTENT, $this->VALID_STEP_ORDER);
		$step->insert($this->getPDO());


// edit the Adult and update it in mySQL
		$step->setStepOrder($this->VALID_STEP_ORDER2);
		$step->update($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
		$pdoStep = Step::getStepByStepId($this->getPDO(), $step->getStepId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("step"));
		$this->assertEquals($pdoStep->getStepTaskId(), $this->task->getTaskId());
		$this->assertEquals($pdoStep->getStepContent(), $this->VALID_STEP_CONTENT);
		$this->assertEquals($pdoStep->getStepOrder(), $this->VALID_STEP_ORDER2);
	} //end of testUpdateValid Adult

	/**
	 * test creating a Step and then deleting it
	 **/
	public function testDeleteValidStep() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("step");

		$stepId = generateUuidV4();

		// create a new Step and insert to into mySQL
		$step = new Step($stepId, $this->task->getTaskId(), $this->VALID_STEP_CONTENT, $this->VALID_STEP_ORDER);
		$step->insert($this->getPDO());

		// delete the Step from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("step"));
		$step->delete($this->getPDO());

		// grab the data from mySQL and enforce the Step does not exist
		$pdoStep = Step::getStepByStepId($this->getPDO(), $step->getStepId());
		$this->assertNull($pdoStep);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("step"));
	} // end of testDeleteValidStep()

	/**
	 * test grabbing a Step that does not exist
	 **/
	public function testGetInvalidStepByStepId() : void {
// grab a adult id that exceeds the maximum allowable adult id
		$fakeStepId = generateUuidV4();
		$step = Step::getStepByStepId($this->getPDO(), $fakeStepId );
		$this->assertNull($step);
	} // end of testGetInvalidAdultByAdultId method


	/**
	 * test grabbing a Step by task id
	 **/
	public function testGetValidStepByStepTaskId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("step");

		// create a new Step and insert to into mySQL
		$stepId = generateUuidV4();
		$step = new Step($stepId, $this->task->getTaskId(), $this->VALID_STEP_CONTENT, $this->VALID_STEP_ORDER);
		$step->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Step::getStepByStepTaskId($this->getPDO(), $step->getStepTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("step"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Club\\KidTask\\Step", $results);

		// grab the result from the array and validate it
		$pdoStep = $results[0];

		$this->assertEquals($pdoStep->getStepId(), $stepId);
		$this->assertEquals($pdoStep->getStepTaskId(), $this->task->getTaskId());
		$this->assertEquals($pdoStep->getStepContent(), $this->VALID_STEP_CONTENT);
		$this->assertEquals($pdoStep->getStepOrder(), $this->VALID_STEP_ORDER);
	} //end of testGetValidStepByTaskId() 

	/**
	 * test grabbing a Step by invalid task id
	 **/
	public function testGetInvalidStepByStepTaskId(): void {
		$step = Step::getStepByStepTaskId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $step);
	}


}//end StepTest