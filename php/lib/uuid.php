<?php
namespace Club\KidTask;

require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\Codec\StringCodec;
/**
 * generates an optimized uuid v4 for efficient mySQL storage and indexing
 *
 * @return string
 **/
function generateUuidV4() : string
{
	try {
		$factory = new UuidFactory();
		$codec = new StringCodec($factory->getUuidBuilder());
		$factory->setCodec($codec);
		$uuid = $factory->uuid4();
		return(ValidateUuid::class);
	} catch(Exception $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}