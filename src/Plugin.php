<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\OpenGrok\Collection\SearchResults;
use AsyncBot\Plugin\OpenGrok\Retriever\FindFunction;
use AsyncBot\Plugin\OpenGrok\Retriever\FindMacro;
use AsyncBot\Plugin\OpenGrok\Retriever\FindMethod;
use AsyncBot\Plugin\OpenGrok\Retriever\Search;
use AsyncBot\Plugin\OpenGrok\ValueObject\FunctionDefinition;
use AsyncBot\Plugin\OpenGrok\ValueObject\MacroDefinition;
use AsyncBot\Plugin\OpenGrok\ValueObject\MethodDefinition;

final class Plugin
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Promise<SearchResults<MethodDefinition>>
     */
    public function findMethod(string $method): Promise
    {
        return (new FindMethod($this->httpClient))->retrieve($method);
    }

    /**
     * @return Promise<SearchResults<MacroDefinition>>
     */
    public function findMacro(string $macro): Promise
    {
        return (new FindMacro($this->httpClient))->retrieve($macro);
    }

    /**
     * @return Promise<SearchResults<FunctionDefinition>>
     */
    public function findFunction(string $function): Promise
    {
        return (new FindFunction($this->httpClient))->retrieve($function);
    }

    /**
     * @return Promise<SearchResults>
     */
    public function search(string $keywords): Promise
    {
        return (new Search($this->httpClient))->retrieve($keywords);
    }
}
