<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\ValueObject;

final class MacroDefinition extends SearchResult
{
    private const PATTERN = '~^\s*#\s*(<b>)?define(</b>)? (<b>)(?P<macroName>[^<]+)(</b>)~';

    private string $macroName;

    /** @var array<string> */
    private array $parameters;

    public function __construct(string $filename, string $line, int $lineNumber, string $macroName)
    {
        parent::__construct($filename, $line, $lineNumber);

        $this->macroName = $macroName;
    }

    public static function isValid(string $line): bool
    {
        return preg_match(self::PATTERN, $line) === 1;
    }

    public static function fromLine(string $filename, array $line): self
    {
        preg_match(self::PATTERN, $line['line'], $matches);

        return new self($filename, $line['line'], (int) $line['lineNumber'], $matches['macroName']);
    }

    public function getMacroName(): string
    {
        return $this->macroName;
    }
}
