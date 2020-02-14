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
	 * valid NAME to use
	 * @var $VALID_NAME2
	 */
	protected $VALID_NAME2 ="姓";

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

		$password = "mypassword12";
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

		$parent = new Parent($parentId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
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
		$this->assertEquals($pdoParent->getParentUsername(), $this->VALID_USERNAME);
	} // end of testInsertValidParent() method

	/**
	 * test inserting a Parent, editing it, and then updating it
	 **/
	public function testUpdateValidParent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("parent");

		// create a new Parent and insert to into mySQL
		$parentId = generateUuidV4();
		$parent = new Parent($parentId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$parent->insert($this->getPDO());


		// edit the Parent and update it in mySQL
		$parent->setParentName($this->VALID_NAME2);
		$parent->update($this->getPDO());

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
		$this->assertEquals($pdoParent->getParentUsername(), $this->VALID_USERNAME);
	} //end of testUpdateValid Parent

	/**
	 * test creating a Parent and then deleting it
	 **/
	public function testDeleteValidParent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("parent");

		$parentId = generateUuidV4();
		$parent = new Parent($parentId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$parent->insert($this->getPDO());

		// delete the Parent from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("parent"));
		$parent->delete($this->getPDO());

		// grab the data from mySQL and enforce the Parent does not exist
		$pdoParent = Parent::getParentByParentId($this->getPDO(), $parent->getParentId());
		$this->assertNull($pdoParent);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("parent"));
	} // end of testDeleteValidParent method

	/**
	 * test inserting a Parent and regrabbing it from mySQL
	 **/
	public function testGetValidParentByParentId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("parent");

		$parentId = generateUuidV4();
		$parent = new Parent($parentId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
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
		$this->assertEquals($pdoParent->getParentUsername(), $this->VALID_USERNAME);
	} //end of testGetValidParentByParentId

	/**
	 * test grabbing a Parent that does not exist
	 **/
	public function testGetInvalidParentByParentId() : void {
		// grab a parent id that exceeds the maximum allowable parent id
		$fakeParentId = generateUuidV4();
		$parent = Parent::getParentByParentId($this->getPDO(), $fakeParentId );
		$this->assertNull($parent);
	}

	/**
	 * test grabbing a Parent by activation token
	 **/
	public function testGetValidParentByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("parent");

		$parentId = generateUuidV4();
		$parent = new Parent($parentId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$parent->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoParent = Parent::getParentByParentActivationToken($this->getPDO(), $parent->getParentActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("parent"));
		$this->assertEquals($pdoParent->getParentId(), $parentId);
		$this->assertEquals($pdoParent->getParentActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoParent->getParentAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoParent->getParentCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoParent->getParentEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoParent->getParentHash(), $this->VALID_HASH);
		$this->assertEquals($pdoParent->getParentName(), $this->VALID_NAME);
		$this->assertEquals($pdoParent->getParentUsername(), $this->VALID_USERNAME);
	} //end of testGetValidParentByActivationToken method

	/**
	 * test grabbing a Parent by an activation token that does not exists
	 **/
	public function testGetInvalidParentActivationToken() : void {
		// grab an email that does not exist
		$profile = Parent::getParentByParentActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
		$this->assertNull($profile);
	}




} //end of Parent Test class