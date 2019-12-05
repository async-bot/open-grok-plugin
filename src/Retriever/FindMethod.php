<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\Retriever;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\OpenGrok\Collection\SearchResults;
use AsyncBot\Plugin\OpenGrok\Parser\ParseSearchResults;
use AsyncBot\Plugin\OpenGrok\Validation\JsonSchema\SearchResultResponse;
use AsyncBot\Plugin\OpenGrok\ValueObject\MethodDefinition;
use function Amp\call;

final class FindMethod
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
    public function retrieve(string $methodName): Promise
    {
        return call(function () use ($methodName) {
            $methodName = sprintf('"%s"', $methodName);
var_dump(urlencode($methodName));
var_dump(sprintf(self::SEARCH_URL, urlencode($methodName)));
            $response = yield $this->httpClient->requestJson(
                sprintf(self::SEARCH_URL, urlencode($methodName)),
                new SearchResultResponse(),
            );

            $searchResults = (new ParseSearchResults())->parse($response);

            $searchResults->filterByType(MethodDefinition::class);

            return $searchResults;
        });
    }
}
