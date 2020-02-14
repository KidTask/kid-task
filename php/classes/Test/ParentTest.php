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
 * @see Parent
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
	 * valid cloudinary token to use
	 * @var string $VALID_CLOUDINARY_TOKEN
	 **/
	protected $VALID_CLOUDINARY_TOKEN = "www.twitter.com";

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
	} //end setUp method

	/**
	 * test inserting a valid Parent and verify that the actual mySQL data matches
	 **/
	public function testInsertValidParent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("parent");

		$parentId = generateUuidV4();



		$parent = new Parent($parentId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$parent->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoParent = Parent::getParentByParentId($this->getPDO(), $parent->getParentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("parent"));
		$this->assertEquals($pdoParent->getParentId(), $parentId);
		$this->assertEquals($pdoParent->getParentActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoParent->getParentAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoParent->getParentCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoParent->getParentEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoParent->getParentHash(), $this->VALID_HASH);
		$this->assertEquals($pdoParent->getParentName(), $this->VALID_NAME);
		$this->assertEquals($pdoParent->getParentUsername(), $this->VALID_NAME);
	}


} //end of Parent Test class