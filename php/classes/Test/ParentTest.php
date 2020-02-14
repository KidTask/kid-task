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
 * Full PHPUnit test for the Parent class
 *
 * This is a complete PHPUnit test of the Parent class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Gabriel Town <gtown@cnm.edu>
 **/
class ParentTest extends KidTaskTest {
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid avatar url to use
	 * @var string $VALID_AVATAR_URL
	 **/
	protected $VALID_AVATAR_URL = "www.twitter.com";

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.com";

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid NAME to use
	 * @var $VALID_NAME
	 */
	protected $VALID_NAME;

	/**
	 * valid username to use
	 * @var $VALID_USERNAME
	 */
	protected $VALID_USERNAME = "ben_dover";

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp() : void {
		parent::setUp();

		//
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}


} //end of Parent Test class