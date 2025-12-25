<?php declare(strict_types=1);

function as_int(mixed $value): int
{
	assert(is_int($value), 'Integer value expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_int_nullable(mixed $value): int|null
{
	assert($value === null || is_int($value), 'Integer value or null expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_float(mixed $value): float
{
	assert(is_float($value), 'Float value expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_float_nullable(mixed $value): float|null
{
	assert($value === null || is_float($value), 'Float value or null expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_bool(mixed $value): bool
{
	assert(is_bool($value), 'Bool value expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_bool_nullable(mixed $value): bool|null
{
	assert($value === null || is_bool($value), 'Bool value or null expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_string(mixed $value): string
{
	assert(is_string($value), 'String value expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_string_nullable(mixed $value): string|null
{
	assert($value === null || is_string($value), 'String value or null expected, got ' . gettype($value) . ' ' . var_export($value, true));
	return $value;
}


function as_type(mixed $value, string $type): mixed
{
	assert(
		Forrest79\TypeValidator\Helpers\Runtime::check($type, Forrest79\StrictTypes\Helpers\RuntimeSourceFilename::detectFilenameCallback(), $value),
		$type . ' value expected, got ' . gettype($value) . ' ' . var_export($value, true),
	);
	return $value;
}
