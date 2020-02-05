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
	 * @var Uuid $ParentId
	 */
	private $ParentId;
	/*
	 * activation token for this Parent
	 * @var $ParentActivationToken
	 */
	private $ParentActivationToken;
	/*
	 * avatar url for this Parent
	 * @var string $ParentAvatarUrl
	 */
	private $ParentAvatarUrl;
	/*
	 * email for this Parent; unique
	 * @var string $ParentEmail
	 */
	private $ParentEmail;
	/*
	 * State variable containing the Hash of Parent in question
	 * @var $ParentHash
	 */
	private $ParentHash;
	/*
	 * name of this Parent
	 * @var $ParentName
	 */
	private $ParentName;
	/*
		 * State variable containing the Username of Parent in question
		 * Unique
		 * @var string $ParentUsername
		 */
	private $ParentUsername;

	/**
	 * constructor for this Parent
	 *
	 * @param string|Uuid $newParentId id of this Parent or null if a new Parent
	 * @param $newParentActivationToken
	 * @param $newParentAvatarUrl
	 * @param $newParentEmail
	 * @param $newParentHash
	 * @param $newParentName
	 * @param $newParentUsername
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newParentId, $newParentActivationToken, $newParentAvatarUrl, $newParentEmail, $newParentHash, $newParentName, $newParentUsername) {
		try {
			$this->setParentId($newParentId);
			$this->setParentActivationToken($newParentActivationToken);
			$this->setParentAvatarUrl($newParentAvatarUrl);
			$this->setParentEmail($newParentEmail);
			$this->setParentHash($newParentHash);
			$this->setParentName($newParentName);
			$this->setParentUsername($newParentUsername);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} //end of construct function

}//end of Parent class