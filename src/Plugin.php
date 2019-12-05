<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\OpenGrok\Retriever\FindFunction;
use AsyncBot\Plugin\OpenGrok\Retriever\FindMacro;
use AsyncBot\Plugin\OpenGrok\Retriever\FindMethod;

final class Plugin
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function findMethod(string $method): Promise
    {
        return (new FindMethod($this->httpClient))->retrieve($method);
    }

    public function findMacro(string $macro): Promise
    {
        return (new FindMacro($this->httpClient))->retrieve($macro);
    }

    public function findFunction(string $function): Promise
    {
        return (new FindFunction($this->httpClient))->retrieve($function);
    }
}
