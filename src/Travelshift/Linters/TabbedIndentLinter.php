<?hh // strict

namespace Travelshift\Linters;

use Facebook\HHAST\Linters\{
	FixableLineLintError,
	AutoFixingLineLinter,
	LineLinter,
	BaseLinter,
	LintError,
	LineLintError,
};
use namespace HH\Lib\Str;

/**
 * A linter to make sure that all lines are tab indented
 */
final class TabbedIndentLinter extends AutoFixingLineLinter<FixableLineLintError>
{
	<<__Override>>
	public function getLintErrors(): Traversable<FixableLineLintError>
	{
		$lines = $this->getLinesFromFile();
		$errs = vec[];
		foreach ($lines as $ln => $line)
		{
			for($i = 0; $i < strlen($line); $i++)
			{
				$char = $line[$i];

				//Fix for dockblocks...
				{
					$nextChar = (($i + 1) < strlen($line))?$line[$i+1]:null;
					if($char === ' ' && $nextChar && $nextChar === '*')
					{
						break;
					}
				}

				if($char === "\t")
				{
					continue;
				}

				if(Str\contains(" \r", $char))
				{
					$errs[] = new FixableLineLintError(
						$this,
						'Lines must be indented by tabs',
						tuple($ln + 1, $i + 1),
					);
					break;
				}
				break;
			}
		}
		return $errs;
	}

	<<__Override>>
	public function getFixedLine(string $line): string {
		$foundTabs = 0;
		$lastToReplace = 0;
		for($i = 0; $i < strlen($line); $i++)
		{
			$char = $line[$i];
			if($char === "\t")
			{
				$foundTabs++;
				$lastToReplace++;
				continue;
			}

			if(Str\contains(" \r", $char))
			{
				$lastToReplace++;
				continue;
			}
			break;
		}

		$tabs = $foundTabs + ($lastToReplace - $foundTabs) / 4;

		$newLine = Str\trim_left($line, "\t\r ");

		for($i = 0; $i < $tabs; $i++)
		{
			$newLine = "\t" . $newLine;
		}
		return $newLine;
	}

}