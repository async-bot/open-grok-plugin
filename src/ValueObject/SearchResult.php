<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\ValueObject;

abstract class SearchResult
{
    private string $filename;

    private string $line;

    private int $lineNumber;

    public function __construct(string $filename, string $line, int $lineNumber)
    {
        $this->filename   = $filename;
        $this->line       = $line;
        $this->lineNumber = $lineNumber;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getLine(): string
    {
        return $this->line;
    }

    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }
}
