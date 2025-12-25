<?php declare(strict_types=1);

namespace Forrest79\StrictTypes\Tests;

use Forrest79\StrictTypes;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

class RuntimeTest
{

	public static function test(): void
	{
		Assert::noError(static function (): void {
			as_int(1);
			as_int_nullable(2);
			as_int_nullable(null);

			as_float(1.1);
			as_float_nullable(2.2);
			as_float_nullable(null);

			as_bool(true);
			as_bool_nullable(false);
			as_bool_nullable(null);

			as_string('boo');
			as_string_nullable('foo');
			as_string_nullable(null);

			as_type('boo', 'string');
			as_type([1 => 'foo', 2 => 'boo'], 'array<int, string>');
			as_type(new StrictTypes\Helpers\RuntimeSourceFilename(), 'StrictTypes\Helpers\RuntimeSourceFilename');
		});
	}

}

RuntimeTest::test();
