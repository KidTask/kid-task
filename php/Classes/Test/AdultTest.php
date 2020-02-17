<?php

namespace Club\KidTask\Test;
use Club\KidTask\Adult;

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
 * @see Adult
 * @author Gabriel Town <gtown@cnm.edu>
 **/
class AdultTest extends KidTaskTest {
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
	protected $VALID_EMAIL = "bad@gmail.com";

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
	 * test inserting a valid Adult and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAdult() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("adult");

		$adultId = generateUuidV4();

		$adult = new Adult($adultId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$adult->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAdult = Adult::getAdultByAdultId($this->getPDO(), $adult->getAdultId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("adult"));
		$this->assertEquals($pdoAdult->getAdultId(), $adultId);
		$this->assertEquals($pdoAdult->getAdultActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoAdult->getAdultAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoAdult->getAdultCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoAdult->getAdultEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoAdult->getAdultHash(), $this->VALID_HASH);
		$this->assertEquals($pdoAdult->getAdultName(), $this->VALID_NAME);
		$this->assertEquals($pdoAdult->getAdultUsername(), $this->VALID_USERNAME);
	} // end of testInsertValidAdult() method

	/**
	 * test inserting a Adult, editing it, and then updating it
	 **/
	public function testUpdateValidAdult() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("adult");

		// create a new Adult and insert to into mySQL
		$adultId = generateUuidV4();
		$adult = new Adult($adultId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$adult->insert($this->getPDO());


		// edit the Adult and update it in mySQL
		$adult->setAdultName($this->VALID_NAME2);
		$adult->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAdult = Adult::getAdultByAdultId($this->getPDO(), $adult->getAdultId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("adult"));
		$this->assertEquals($pdoAdult->getAdultId(), $adultId);
		$this->assertEquals($pdoAdult->getAdultActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoAdult->getAdultAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoAdult->getAdultCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoAdult->getAdultEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoAdult->getAdultHash(), $this->VALID_HASH);
		$this->assertEquals($pdoAdult->getAdultName(), $this->VALID_NAME);
		$this->assertEquals($pdoAdult->getAdultUsername(), $this->VALID_USERNAME);
	} //end of testUpdateValid Adult

	/**
	 * test creating a Adult and then deleting it
	 **/
	public function testDeleteValidAdult() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("adult");

		$adultId = generateUuidV4();
		$adult = new Adult($adultId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$adult->insert($this->getPDO());

		// delete the Adult from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("adult"));
		$adult->delete($this->getPDO());

		// grab the data from mySQL and enforce the Adult does not exist
		$pdoAdult = Adult::getAdultByAdultId($this->getPDO(), $adult->getAdultId());
		$this->assertNull($pdoAdult);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("adult"));
	} // end of testDeleteValidAdult method

	/**
	 * test inserting a Adult and regrabbing it from mySQL
	 **/
	public function testGetValidAdultByAdultId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("adult");

		$adultId = generateUuidV4();
		$adult = new Adult($adultId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$adult->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAdult = Adult::getAdultByAdultId($this->getPDO(), $adult->getAdultId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("adult"));
		$this->assertEquals($pdoAdult->getAdultId(), $adultId);
		$this->assertEquals($pdoAdult->getAdultActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoAdult->getAdultAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoAdult->getAdultCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoAdult->getAdultEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoAdult->getAdultHash(), $this->VALID_HASH);
		$this->assertEquals($pdoAdult->getAdultName(), $this->VALID_NAME);
		$this->assertEquals($pdoAdult->getAdultUsername(), $this->VALID_USERNAME);
	} //end of testGetValidAdultByAdultId

	/**
	 * test grabbing a Adult that does not exist
	 **/
	public function testGetInvalidAdultByAdultId() : void {
		// grab a adult id that exceeds the maximum allowable adult id
		$fakeAdultId = generateUuidV4();
		$adult = Adult::getAdultByAdultId($this->getPDO(), $fakeAdultId );
		$this->assertNull($adult);
	} // end of testGetInvalidAdultByAdultId method


	/**
	 * test grabbing a Adult by activation token
	 **/
	public function testGetValidAdultByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("adult");

		$adultId = generateUuidV4();
		$adult = new Adult($adultId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$adult->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAdult = Adult::getAdultByAdultActivationToken($this->getPDO(), $adult->getAdultActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("adult"));
		$this->assertEquals($pdoAdult->getAdultId(), $adultId);
		$this->assertEquals($pdoAdult->getAdultActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoAdult->getAdultAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoAdult->getAdultCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoAdult->getAdultEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoAdult->getAdultHash(), $this->VALID_HASH);
		$this->assertEquals($pdoAdult->getAdultName(), $this->VALID_NAME);
		$this->assertEquals($pdoAdult->getAdultUsername(), $this->VALID_USERNAME);
	} //end of testGetValidAdultByActivationToken method

	/**
	 * test grabbing a Adult by an activation token that does not exists
	 **/
	public function testGetInvalidAdultActivationToken() : void {
		// grab an email that does not exist
		$profile = Adult::getAdultByAdultActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
		$this->assertNull($profile);
	} //end of testGetInvalidAdultActivationToken method

	/**
	 * test grabbing a Adult by username
	 **/
	public function testGetValidAdultByUsername() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("adult");

		$adultId = generateUuidV4();
		$adult = new Adult($adultId, $this->VALID_ACTIVATION, $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
		$adult->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAdult = Adult::getAdultByAdultUsername($this->getPDO(), $adult->getAdultUsername());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("adult"));
		$this->assertEquals($pdoAdult->getAdultId(), $adultId);
		$this->assertEquals($pdoAdult->getAdultActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoAdult->getAdultAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoAdult->getAdultCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
		$this->assertEquals($pdoAdult->getAdultEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoAdult->getAdultHash(), $this->VALID_HASH);
		$this->assertEquals($pdoAdult->getAdultName(), $this->VALID_NAME);
		$this->assertEquals($pdoAdult->getAdultUsername(), $this->VALID_USERNAME);
	} //end of testGetValidAdultByUsername method

	/**
	 * test grabbing a Adult by a username that does not exists
	 **/
	public function testGetInvalidAdultUsername() : void {
		// grab an email that does not exist
		$profile = Adult::getAdultByAdultUsername($this->getPDO(), "yourmom");
		$this->assertNull($profile);
	} //end of testGetInvalidAdultUsername method


} //end of Adult Test class