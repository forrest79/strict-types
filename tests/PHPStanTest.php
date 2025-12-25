<?php declare(strict_types=1);

namespace Forrest79\StrictTypes\Tests;

use Forrest79\StrictTypes;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

class PHPStanTest
{

	public static function test(
		mixed $intValue,
		mixed $intNullableValue,
		mixed $floatValue,
		mixed $floatNullableValue,
		mixed $boolValue,
		mixed $boolNullableValue,
		mixed $stringValue,
		mixed $stringNullableValue,
		mixed $objectValue,
		mixed $arrayValue,
	): void
	{
		self::testInt(as_int($intValue));
		self::testIntNullable(as_int_nullable($intNullableValue));

		self::testFloat(as_float($floatValue));
		self::testFloatNullable(as_float_nullable($floatNullableValue));

		self::testBool(as_bool($boolValue));
		self::testBoolNullable(as_bool_nullable($boolNullableValue));

		self::testString(as_string($stringValue));
		self::testStringNullable(as_string_nullable($stringNullableValue));

		self::testObject(as_type($objectValue, 'StrictTypes\Helpers\RuntimeSourceFilename'));
		self::testArray(as_type($arrayValue, 'array<int, string>'));
	}


	private static function testInt(int $value): void
	{
		print_r($value);
	}


	private static function testIntNullable(int|null $value): void
	{
		print_r($value);
	}


	private static function testFloat(float $value): void
	{
		print_r($value);
	}


	private static function testFloatNullable(float|null $value): void
	{
		print_r($value);
	}


	private static function testBool(bool $value): void
	{
		print_r($value);
	}


	private static function testBoolNullable(bool|null $value): void
	{
		print_r($value);
	}


	private static function testString(string $value): void
	{
		print_r($value);
	}


	private static function testStringNullable(string|null $value): void
	{
		print_r($value);
	}


	private static function testObject(StrictTypes\Helpers\RuntimeSourceFilename $value): void
	{
		print_r($value);
	}


	/**
	 * @param array<int, string> $value
	 */
	private static function testArray(array $value): void
	{
		print_r($value);
	}

}

Assert::noError(static function (): void {
	PHPStanTest::test(
		1,
		null,
		1.1,
		null,
		true,
		null,
		'foo',
		null,
		new StrictTypes\Helpers\RuntimeSourceFilename(),
		[1 => 'bar'],
	);
});
