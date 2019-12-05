<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\ValueObject;

final class Unclassified extends SearchResult
{
    public static function isValid(string $line): bool
    {
        return true;
    }

    public static function fromLine(string $filename, array $line): self
    {
        return new self($filename, $line['line'], (int) $line['lineNumber']);
    }
}
