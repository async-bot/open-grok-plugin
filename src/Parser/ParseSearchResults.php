<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\Parser;

use AsyncBot\Plugin\OpenGrok\Collection\SearchResults;
use AsyncBot\Plugin\OpenGrok\ValueObject\FunctionDefinition;
use AsyncBot\Plugin\OpenGrok\ValueObject\MacroDefinition;
use AsyncBot\Plugin\OpenGrok\ValueObject\MethodDefinition;
use AsyncBot\Plugin\OpenGrok\ValueObject\Unclassified;

final class ParseSearchResults
{
    public function parse(array $searchResults): SearchResults
    {
        $parsedResults = [];

        foreach ($searchResults['results'] as $fileName => $file) {
            if (strpos($fileName, '/php-src/') !== 0) {
                continue;
            }

            foreach ($file as $line) {
                $parsedLine = $this->parseLine($fileName, $line);

                if ($parsedLine === null) {
                    continue;
                }

                $parsedResults[] = $parsedLine;
            }
        }

        return new SearchResults(...$parsedResults);
    }

    private function parseLine(string $fileName, array $line)
    {
        if (MethodDefinition::isValid($line['line'])) {
            return MethodDefinition::fromLine($fileName, $line);
        }

        if (MacroDefinition::isValid($line['line'])) {
            return MacroDefinition::fromLine($fileName, $line);
        }

        if (FunctionDefinition::isValid($line['line'])) {
            return FunctionDefinition::fromLine($fileName, $line);
        }

        return Unclassified::fromLine($fileName, $line);
    }
}
