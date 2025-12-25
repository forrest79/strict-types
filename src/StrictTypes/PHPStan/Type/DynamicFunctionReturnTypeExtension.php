<?php declare(strict_types=1);

namespace Forrest79\StrictTypes\PHPStan\Type;

use Forrest79\TypeValidator;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type;
use PhpParser\Node\Expr\FuncCall;

final class DynamicFunctionReturnTypeExtension extends TypeValidator\PHPStan\Type\ReturnTypeExtension implements Type\DynamicFunctionReturnTypeExtension
{

	public function isFunctionSupported(FunctionReflection $functionReflection): bool
	{
		return in_array($functionReflection->getName(), self::getSupportedMethodsList(), true);
	}


	public function getTypeFromFunctionCall(
		FunctionReflection $functionReflection,
		FuncCall $functionCall,
		Scope $scope,
	): Type\Type|null
	{
		if (!self::isMethodSupported($functionReflection->getName(), count($functionCall->getArgs()))) {
			return null;
		}

		$args = $functionCall->getArgs();
		$originalType = $scope->getType($args[0]->value);
		$preparedType = $this->prepareType($args[1]->value, $scope, $typeDescription);

		if ($originalType->accepts($preparedType, $scope->isDeclareStrictTypes())->no()) {
			self::error(
				$scope->getFile(),
				sprintf('Type \'%s\' is not compatible with \'%s\'', $typeDescription, $originalType->describe(type\VerbosityLevel::precise())),
				$args[1]->value,
			);
		}

		return Type\TypeCombinator::intersect($originalType, $preparedType);
	}


	/**
	 * @inheritDoc
	 */
	protected static function getSupportedMethodsList(): array
	{
		return ['as_type'];
	}

}
