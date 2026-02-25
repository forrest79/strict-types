# StrictTypes

[![Latest Stable Version](https://poser.pugx.org/forrest79/strict-types/v)](//packagist.org/packages/forrest79/strict-types)
[![Monthly Downloads](https://poser.pugx.org/forrest79/strict-types/d/monthly)](//packagist.org/packages/forrest79/strict-types)
[![License](https://poser.pugx.org/forrest79/strict-types/license)](//packagist.org/packages/forrest79/strict-types)
[![Build](https://github.com/forrest79/strict-types/actions/workflows/build.yml/badge.svg?branch=master)](https://github.com/forrest79/strict-types/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/forrest79/strict-types/graph/badge.svg?token=VSFCW66JSZ)](https://codecov.io/gh/forrest79/strict-types)

## Introduction

Provides global `as_*` functions that **check** (not cast) variable types and narrow them for [PHPStan](https://phpstan.org/). In development, when PHP assertions are enabled, an `AssertionError` is thrown if the variable does not match the expected type.

These functions are useful anywhere you receive data as `mixed` and need to assert a concrete type — for example, when reading from a database, decoding JSON, or extracting values from arrays. Instead of writing `@var` annotations that are never verified, you let the library both document and validate the type.

```php
// Before: annotation is not checked at all
/** @var int $id */
$id = $row['id'];

// After: type is narrowed for PHPStan and verified in development
$id = as_int($row['id']);
```

> **Important:** These functions do **not** cast values. `as_int('42')` will throw an exception in development — the value must already be an `int`.

## Installation

```
composer require forrest79/strict-types
```

For development install also [forrest79/type-validator](https://github.com/forrest79/type-validator):

```
composer require --dev forrest79/type-validator
```

To enable type narrowing in PHPStan, include `extension.neon` in your PHPStan config:

```yaml
includes:
    - vendor/forrest79/strict-types/extension.neon
```

## Functions

### Simple type functions

| Function                                         |
|--------------------------------------------------|
| `as_int(mixed $value): int`                      |
| `as_int_nullable(mixed $value): int\|null`       |
| `as_float(mixed $value): float`                  |
| `as_float_nullable(mixed $value): float\|null`   |
| `as_bool(mixed $value): bool`                    |
| `as_bool_nullable(mixed $value):bool\|null`      |
| `as_string(mixed $value): string`                |
| `as_string_nullable(mixed $value): string\|null` |

All functions return the original value unchanged if it matches the expected type, or throw an `AssertionError` in development (when assertions are enabled) if it does not.

### Complex type function

```php
as_type(mixed $value, string $type): mixed
```

Checks `$value` against a PHPDoc type string. The runtime check (powered by [forrest79/type-validator](https://packagist.org/packages/forrest79/type-validator)) runs only when assertions are enabled, so `forrest79/type-validator` is only a dev dependency. The PHPStan extension included with this library narrows the type for PHPStan regardless of whether assertions are enabled.

> Because of PHPStan, the type description must be a static string — it cannot be generated dynamically.

## Examples

### Simple types

```php
// Reading from a database row (mixed values)
$id    = as_int($row['id']);          // int
$name  = as_string($row['name']);     // string
$score = as_float($row['score']);     // float
$active = as_bool($row['active']);    // bool

// Nullable variants accept null as well
$deletedAt = as_string_nullable($row['deleted_at']); // string|null
$parentId  = as_int_nullable($row['parent_id']);     // int|null
```

### Complex types with `as_type()`

```php
// Decoded JSON is mixed — tell PHPStan and verify at runtime
$data = json_decode($json, true);
$data = as_type($data, 'array<string, mixed>');

// A nested structure from an external API
$items = as_type($response['items'], 'list<array{id: int, name: string, tags: array<string>}>');

// class-string narrowing
$className = as_type($config['handler'], 'class-string<HandlerInterface>');

// Union types
$value = as_type($input, 'int|string');
```

> All types supported by [forrest79/type-validator](https://github.com/forrest79/type-validator) are supported, which covers almost all PHPStan PHPDoc types.

### Replacing `@var` annotations

```php
// Before — the annotation is never enforced
/** @var array<string, list<int>> $grouped */
$grouped = buildGroups($data);

// After — verified in development, narrowed for PHPStan
$grouped = as_type(buildGroups($data), 'array<string, list<int>>');
```

### Passing narrowed values directly to typed parameters

```php
function processUser(int $id, string $name): void { /* ... */ }

// PHPStan knows the return types, so no extra annotation needed
processUser(
    as_int($payload['id']),
    as_string($payload['name']),
);
```
