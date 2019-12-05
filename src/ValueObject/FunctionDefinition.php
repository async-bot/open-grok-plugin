<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\ValueObject;

final class FunctionDefinition extends SearchResult
{
    private const PATTERN = '~/\* {{{ proto (?P<returnType>[^ ]+) <b>(?P<functionName>[^<]+)</b>\((?P<parameters>.*)\)~';

    private string $returnType;

    private string $function;

    private string $parameters;

    public function __construct(
        string $filename,
        string $line,
        int $lineNumber,
        string $returnType,
        string $function,
        string $parameters
    ) {
        parent::__construct($filename, $line, $lineNumber);

        $this->returnType = $returnType;
        $this->function   = $function;
        $this->parameters = $parameters;
    }

    public static function isValid(string $line): bool
    {
        return preg_match(self::PATTERN, $line) === 1;
    }

    public static function fromLine(string $filename, array $line): self
    {
        preg_match(self::PATTERN, $line['line'], $matches);

        return new self(
            $filename,
            $line['line'],
            (int) $line['lineNumber'],
            $matches['returnType'],
            $matches['functionName'],
            $matches['parameters'],
        );
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getParameters(): string
    {
        return $this->parameters;
    }
}
