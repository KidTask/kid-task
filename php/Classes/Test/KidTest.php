<?php

namespace Club\KidTask\Test;
use Club\KidTask\{Adult, Kid};

require_once(dirname(__DIR__) . "/autoload.php");

require_once(dirname(__DIR__,2) . "/lib/uuid.php");

/**
 * unit test for the Kid Class
 * PDO methods are located in the Kid Class
 * @ see php/Classes/Kid.php
 * @author Jacob Lott
 */

class KidTest extends KidTaskTest {

    /**
     * Kid's Adult Id
     * @var string Adult
     */
    protected $adult = null;

    /**
     * Avatar Url for Kid
     * @var string $VALID_AVATAR_URL
     */
    protected $VALID_AVATAR_URL = "https://img.webmd.com/dtmcms/live/webmd/consumer_assets/site_images/article_thumbnails/other/cat_weight_other/1800x1200_cat_weight_other.jpg?resize=600px:*";

    /**
     * Cloudinary Token for Kid
     * @var $VALID_CLOUDINARY_TOKEN
     **/
    protected $VALID_CLOUDINARY_TOKEN = "@passingtests";

    /**
     * valid hash to use
     * @var $VALID_HASH
     */
    protected $VALID_HASH;

    /**
     * valid username
     * @var string $VALID_USERNAME
     **/
    protected $VALID_USERNAME = "Username";

    /**
     * valid Name
     * @var $VALID_NAME
     */
    protected $VALID_NAME = "Name";

    /**
     * valid Name
     * @var $VALID_NAME2
     */
    protected $VALID_NAME2 = "Name2";
    /**
     * run the default setup operation to create salt and hash.
     * @throws \Exception
     */
    public final function setUp(): void

    {
        parent::setUp();
        $password = "abc123";
        $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 7]);
        //create and insert a Profile to own the test Tweet
        $this->adult = new Adult(generateUuidV4(),null ,"https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif","null" , "test@phpunit.de","$this->VALID_HASH", "Name", "null");
        $this->adult->insert($this->getPDO());
    }

    /**
     * test inserting a valid Kid and verify that the actual mySQL data matches
     *
     * @throws \Exception
     */
    public function testInsertValidKid(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("kid");

        $kidId = generateUuidV4();


        $kid = new Kid($kidId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
        $kid->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoKid = Kid::getKidByKidId($this->getPDO(), $kid->getKidId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("kid"));
        $this->assertEquals($pdoKid->getKidId(), $kidId);
        $this->assertEquals($pdoKid->getKidAdultId(), $this->adult->getAdultId());
        $this->assertEquals($pdoKid->getKidAvatarUrl(), $this->VALID_AVATAR_URL);
        $this->assertEquals($pdoKid->getKidCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
        $this->assertEquals($pdoKid->getKidHash(), $this->VALID_HASH);
        $this->assertEquals($pdoKid->getKidName(), $this->VALID_NAME);
        $this->assertEquals($pdoKid->getKidUsername(), $this->VALID_USERNAME);

    }


    /**
     * test inserting a Kid, editing it, and then updating it
     *
     * @throws \Exception
     */
    public function testUpdateValidKid()
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("kid");

        // create a new Kid and insert to into mySQL
        $kidId = generateUuidV4();
        $kid = new Kid($kidId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
        $kid->insert($this->getPDO());


        // edit the Kid and update it in mySQL
        $kid->setKidName($this->VALID_NAME2);
        $kid->update($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoKid = Kid::getKidByKidId($this->getPDO(), $kid->getKidId());


        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("kid"));
        $this->assertEquals($pdoKid->getKidId(), $kidId);
        $this->assertEquals($pdoKid->getKidAdultId(), $this->adult->getAdultId());
        $this->assertEquals($pdoKid->getKidAvatarUrl(), $this->VALID_AVATAR_URL);
        $this->assertEquals($pdoKid->getKidCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
        $this->assertEquals($pdoKid->getKidHash(), $this->VALID_HASH);
        $this->assertEquals($pdoKid->getKidName(), $this->VALID_NAME2);
        $this->assertEquals($pdoKid->getKidUsername(), $this->VALID_USERNAME);
    }


    /**
     * test creating a Kid and then deleting it
     *
     * @throws \Exception
     */
    public function testDeleteValidKid(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("kid");

        $kidId = generateUuidV4();
        $kid = new Kid($kidId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
        $kid->insert($this->getPDO());


        // delete the Kid from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("kid"));
        $kid->delete($this->getPDO());

        // grab the data from mySQL and enforce the Kid does not exist
        $pdoKid = Kid::getKidByKidId($this->getPDO(), $kid->getKidId());
        $this->assertNull($pdoKid);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("kid"));
    }

    /**
     * test inserting a Kid and regrabbing it from mySQL
     *
     * @throws \Exception
     */
    public function testGetValidKidByKidId(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("kid");

        $kidId = generateUuidV4();
        $kid = new Kid($kidId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
        $kid->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoKid = Kid::getKidByKidId($this->getPDO(), $kid->getKidId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("kid"));
        $this->assertEquals($pdoKid->getKidId(), $kidId);
        $this->assertEquals($pdoKid->getKidAdultId(), $this->adult->getAdultId());
        $this->assertEquals($pdoKid->getKidAvatarUrl(), $this->VALID_AVATAR_URL);
        $this->assertEquals($pdoKid->getKidCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
        $this->assertEquals($pdoKid->getKidHash(), $this->VALID_HASH);
        $this->assertEquals($pdoKid->getKidName(), $this->VALID_NAME);
        $this->assertEquals($pdoKid->getKidUsername(), $this->VALID_USERNAME);
    }

    /**
     * test grabbing a Kid that does not exist
     **/
    public function testGetInvalidKidByKidId(): void
    {
        // grab a Kid id that exceeds the maximum allowable Kid id
        $fakeKidId = generateUuidV4();
        $Kid = Kid::getKidByKidId($this->getPDO(), $fakeKidId);
        $this->assertNull($Kid);
    }

    /**
     * test grabbing a Kid by Username
     **/
    public function testGetValidKidByUsername(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("kid");

        $kidId = generateUuidV4();
        $kid = new Kid($kidId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
        $kid->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoKid = Kid::getKidByKidUsername($this->getPDO(), $kid->getKidUsername());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("kid"));
        $this->assertEquals($pdoKid->getKidId(), $kidId);
        $this->assertEquals($pdoKid->getKidAdultId(), $this->adult->getAdultId());
        $this->assertEquals($pdoKid->getKidAvatarUrl(), $this->VALID_AVATAR_URL);
        $this->assertEquals($pdoKid->getKidCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
        $this->assertEquals($pdoKid->getKidHash(), $this->VALID_HASH);
        $this->assertEquals($pdoKid->getKidName(), $this->VALID_NAME);
        $this->assertEquals($pdoKid->getKidUsername(), $this->VALID_USERNAME);
    }

    /**
     * test grabbing a Kid by Kid Adult Id
     */
    public function testGetValidKidByKidAdultId() : void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("kid");

        $kidId = generateUuidV4();
        $kid = new Kid($kidId, $this->adult->getAdultId(), $this->VALID_AVATAR_URL, $this->VALID_CLOUDINARY_TOKEN, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_USERNAME);
        $kid->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Kid::getKidByKidAdultId($this->getPDO(), $kid->getKidAdultId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("kid"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Club\\KidTask\\Kid", $results);


        // grab the results from the array and validate it
        $pdoKid = $results[0];
        $this->assertEquals($pdoKid->getKidId(), $kidId);
        $this->assertEquals($pdoKid->getKidAdultId(), $this->adult->getAdultId());
        $this->assertEquals($pdoKid->getKidAvatarUrl(), $this->VALID_AVATAR_URL);
        $this->assertEquals($pdoKid->getKidCloudinaryToken(), $this->VALID_CLOUDINARY_TOKEN);
        $this->assertEquals($pdoKid->getKidHash(), $this->VALID_HASH);
        $this->assertEquals($pdoKid->getKidName(), $this->VALID_NAME);
        $this->assertEquals($pdoKid->getKidUsername(), $this->VALID_USERNAME);
    }
}
