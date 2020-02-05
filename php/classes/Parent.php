<?php
namespace Club\KidTask;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Parent implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/*
	 * id for this Parent; this is the primary key
	 * @var Uuid $parentId
	 */
	private $parentId;
	/*
	 * activation token for this Parent
	 * @var $parentActivationToken
	 */
	private $parentActivationToken;
	/*
	 * avatar url for this parent
	 * @var string $parentAvatarUrl
	 */
	private $parentAvatarUrl;
	/*
	 * email for this Parent; unique
	 * @var string $parentEmail
	 */
	private $parentEmail;
	/*
	 * State variable containing the Hash of parent in question
	 * @var $parentHash
	 */
	private $parentHash;
	/*
	 * name of this Parent
	 * @var $parentName
	 */
	private $parentName;
	/*
		 * State variable containing the Username of parent in question
		 * Unique
		 * @var string $parentUsername
		 */
	private $parentUsername;


}//end of Parent class