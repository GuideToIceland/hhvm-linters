# Linter for use in Hacklang projects

## Setup

Add the repository to the composer file
```
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/GuideToIceland/hhvm-linters"
        }
    ],
```

then you should be able to do
```
composer require travelshift/hhvm-linters@dev-master
```

To use the hhast linter you have to hava folder named "hhast-lint.json"
Example: 
```
{
	"roots": [
		"src/"
	],
	"builtinLinters": "all",
	"extraLinters" : [
		"Travelshift\\Linters\\TabbedIndentLinter",

		"Facebook\\HHAST\\Linters\\NoWhitespaceAtEndOfLineLinter",
		"Facebook\\HHAST\\Linters\\MustUseBracesForControlFlowLinter",
		"Facebook\\HHAST\\Linters\\CamelCasedMethodsUnderscoredFunctionsLinter"
	],
	"disabledLinters": [
		"Facebook\\HHAST\\Linters\\NoStringInterpolationLinter"
  ]
}
```

## Usage

From the root of the project run the folowing command

<small>Where the composer.json file is</small>
```
./vendor/bin/hhast-lint src/
```


## Linter ideas
- DockBlock linter
 - Verify datatypes in dockblocks??