<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\Collection;

use AsyncBot\Plugin\OpenGrok\ValueObject\SearchResult;

final class SearchResults implements \Iterator, \Countable
{
    /** @var array<SearchResult> */
    private array $searchResults;

    public function __construct(SearchResult ...$searchResults)
    {
        $this->searchResults = $searchResults;
    }

    public function filterByType(string $type): self
    {
        $filtered = array_filter($this->searchResults, fn (SearchResult $result) => $result instanceof $type);

        return new self(...$filtered);
    }

    public function getFirst(): ?SearchResult
    {
        return $this->searchResults[0] ?? null;
    }

    public function current(): SearchResult
    {
        return current($this->searchResults);
    }

    public function next(): void
    {
        next($this->searchResults);
    }

    public function key(): ?int
    {
        return key($this->searchResults);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind(): void
    {
        reset($this->searchResults);
    }

    public function count(): int
    {
        return count($this->searchResults);
    }
}
