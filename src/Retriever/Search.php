<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\Retriever;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\OpenGrok\Collection\SearchResults;
use AsyncBot\Plugin\OpenGrok\Parser\ParseSearchResults;
use AsyncBot\Plugin\OpenGrok\Validation\JsonSchema\SearchResultResponse;
use function Amp\call;

final class Search
{
    private const SEARCH_URL = 'https://heap.space/api/v1/search?project=php-src&full=%s&defs=&refs=&path=&hist=&type=c&si=full&searchall=true';

    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Promise<SearchResults>
     */
    public function retrieve(string $keywords): Promise
    {
        return call(function () use ($keywords) {
            $response = yield $this->httpClient->requestJson(
                sprintf(self::SEARCH_URL, urlencode($keywords)),
                new SearchResultResponse(),
            );

            return (new ParseSearchResults())->parse($response);
        });
    }
}
