<?php
namespace Club\StepTask;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Step implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/*
	 * id for this Step; this is the primary key
	 * @var Uuid $stepId
	 */
	private $stepId;
	/*
	 * Taskid for this Step; this is the foreign key
	 * @var Uuid $stepTaskId
	 */
	private $stepTaskId;
	/*
	 * Content of this Step
	 * @var string $stepContent
	 */
	private $stepContent;
	/*
	 * Order of this Step
	 * @var tinyint $stepOrder
	 */
	private $stepOrder;
	

	/**
	 * constructor for this Step
	 *
	 * @param string|Uuid $newStepId id of this Step or null if a new Step
	 * @param string|Uuid $newStepTaskId id of this stepTask or null if a new stepTask
	 * @param $newStepContent
	 * @param $newStepOrder
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newStepId, $newStepTaskId, $newStepContent, $newStepOrder) {
		try {
			$this->setStepId($newStepId);
			$this->setStepTaskId($newStepTaskId);
			$this->setStepContent($newStepContent);
			$this->setStepOrder($newStepOrder);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} //end of construct function

	/**
	 * accessor method for step id
	 *
	 * @return Uuid value of step id (or null if new Profile)
	 **/
	public function getStepId() : Uuid {
		return($this->stepId);
	} //end of getStepId function

	/**
	 * mutator method for step id
	 *
	 * @param Uuid|string $newStepId new value of step id
	 * @throws \RangeException if $newStepId is not positive
	 * @throws \TypeError if $newStepId is not a uuid or string
	 **/
	public function setStepId($newStepId): void {
		try {
			$uuid = self::validateUuid($newStepId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the step id
		$this->stepId = $uuid;
	} //end of setStepId function

	/**
	 * accessor method for stepTask id
	 *
	 * @return Uuid value of stepTask id (or null if new Profile)
	 **/
	public function getStepTaskId() : Uuid {
		return($this->stepTaskId);
	} //end of getStepTaskId function

	/**
	 * mutator method for stepTask id
	 *
	 * @param Uuid|string $newStepTaskId new value of stepTask id
	 * @throws \RangeException if $newStepTaskId is not positive
	 * @throws \TypeError if $newStepTaskId is not a uuid or string
	 **/
	public function setStepTaskId($newStepTaskId): void {
		try {
			$uuid = self::validateUuid($newStepTaskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the stepTask id
		$this->stepTaskId = $uuid;
	} //end of setStepTaskId function



}//end of Step class