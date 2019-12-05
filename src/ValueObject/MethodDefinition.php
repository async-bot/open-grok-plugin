<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\ValueObject;

final class MethodDefinition extends SearchResult
{
    private const PATTERN = '~/\* {{{ proto (?:(?P<visibility>[^ ]+) )?(?P<returnType>[^ ]+) (?:<b>)?(?P<className>[^:]+)(?:</b>)?::(?:<b>)?(?P<methodName>[^<]+)(?:</b>)?\((?P<parameters>.*)\)~';

    private ?string $visibility;

    private string $returnType;

    private string $class;

    private string $method;

    private string $parameters;

    public function __construct(
        string $filename,
        string $line,
        int $lineNumber,
        ?string $visibility,
        string $returnType,
        string $class,
        string $method,
        string $parameters
    ) {
        parent::__construct($filename, $line, $lineNumber);

        $this->visibility = $visibility;
        $this->returnType = $returnType;
        $this->class      = $class;
        $this->method     = $method;
        $this->parameters = $parameters;
    }

    public static function isValid(string $line): bool
    {
        return preg_match(self::PATTERN, $line) === 1;
    }

    public static function fromLine(string $filename, array $line): self
    {
        preg_match(self::PATTERN, $line['line'], $matches, PREG_UNMATCHED_AS_NULL);

        return new self(
            $filename,
            $line['line'],
            (int) $line['lineNumber'],
            $matches['visibility'] ?? null,
            $matches['returnType'],
            $matches['className'],
            $matches['methodName'],
            $matches['parameters'],
        );
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParameters(): string
    {
        return $this->parameters;
    }
}
