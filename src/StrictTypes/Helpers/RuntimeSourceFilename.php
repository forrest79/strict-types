<?php declare(strict_types=1);

namespace Forrest79\StrictTypes\Helpers;

class RuntimeSourceFilename
{
	/** @var (\Closure(): string)|null */
	private static \Closure|null $filenameCallback = null;


	/**
	 * @return callable(): string
	 */
	public static function detectFilenameCallback(): callable
	{
		if (self::$filenameCallback === null) {
			$functionFilename = realpath(__DIR__ . '/../../functions.php');
			if ($functionFilename === false) {
				throw new \RuntimeException('File `function.php` not exists.');
			}

			self::$filenameCallback = static function () use ($functionFilename): string {
				$filename = '';
				$debugBacktrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
				foreach ($debugBacktrace as $i => $item) {
					if (($item['file'] ?? '') === $functionFilename) {
						$filename = $debugBacktrace[$i + 1]['file'] ?? '';
						break;
					}
				}

				return $filename;
			};
		}

		return self::$filenameCallback;
	}

}
