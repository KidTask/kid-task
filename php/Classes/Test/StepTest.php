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
		$pdoStep = Step::getStepById($this->getPDO(), $step->getStepId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("step"));
		$this->assertEquals($pdoStep->getStepTaskId(), $this->task->getTaskId());
		$this->assertEquals($pdoStep->getStepContent(), $this->VALID_STEP_CONTENT);
		$this->assertEquals($pdoStep->getStepOrder(), $this->VALID_STEP_ORDER);
	} // end of testInsertValidStep()


}//end StepTest