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


}//end of Step class