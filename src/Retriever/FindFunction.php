<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\Retriever;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\OpenGrok\Collection\SearchResults;
use AsyncBot\Plugin\OpenGrok\Parser\ParseSearchResults;
use AsyncBot\Plugin\OpenGrok\Validation\JsonSchema\SearchResultResponse;
use AsyncBot\Plugin\OpenGrok\ValueObject\FunctionDefinition;
use function Amp\call;

final class FindFunction
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
    public function retrieve(string $functionName): Promise
    {
        return call(function () use ($functionName) {
            $response = yield $this->httpClient->requestJson(
                sprintf(self::SEARCH_URL, urlencode($functionName)),
                new SearchResultResponse(),
            );

            $searchResults = (new ParseSearchResults())->parse($response);

            return $searchResults->filterByType(FunctionDefinition::class);
        });
    }
}
