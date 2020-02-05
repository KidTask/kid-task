<?php
namespace Club\KidTask;

require_once("Kid.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Kid implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;
    /*
     * id for this Kid; this is the primary key
     * @var Uuid $kidId
     */
    private $kidId;
    /*
     *  id of the kid's parent; this is the foreign key
     * @var $kidParentId
     */
    private $kidParentId;
    /*
     * avatar url for the kid
     * @var string $kidAvatarUrl
     */
    private $kidAvatarUrl;
    /*
     * State variable containing the Hash of kid
     * @var string $kidHash
     */
    private $kidHash;
    /*
     * name of the Kid
     * @var $kidName
     */
    private $kidName;
    /*
     * The Kid's Username
     * Unique
     * @var $kidUsername
     */
    private $kidUsername;

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}//end of Kid class