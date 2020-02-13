<?php

namespace Club\KidTask\Test;
use Club\KidTask\{
	Parent, Kid, Task, Step
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
	 * Kid that is assigned the Task; this is for foreign key relations
	 * @var Kid profile
	 **/
	protected $kid = null;

	/**
	 * Parent that created the Task; this is for foreign key relations
	 * @var Parent profile
	 **/
	protected $parent = null;

	/**
	 * valid kid hash to create the parent profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_KID_HASH;

	/**
	 * valid parent hash to create the parent profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PARENT_HASH;

	/**
	 * content of the Task
	 * @var string $VALID_TASKCONTENT
	 **/
	protected $VALID_TASKCONTENT = "PHPUnit test passing";

	/**
	 * Task due date; this starts as null and is assigned later
	 * @var \DateTime $VALID_TASKDUEDATE
	 **/
	protected $VALID_TASKDUEDATE = null;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Profile to own the test Tweet
		$this->profile = new Profile(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_TWEETDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));



	}








}// end of TaskTest