<?php declare(strict_types=1);

namespace AsyncBot\Plugin\OpenGrok\Validation\JsonSchema;

use AsyncBot\Core\Http\Validation\JsonSchema;

final class SearchResultResponse extends JsonSchema
{
    public function __construct()
    {
        parent::__construct(
            [
                '$id'        => 'AsyncBot/Plugin/OpenGrok/search-result-response.json',
                '$schema'    => 'http://json-schema.org/draft-07/schema#',
                'title'      => 'OpenGrok search result response',
                'type'       => 'object',
                'required'   => [
                    'time',
                    'resultCount',
                    'results',
                ],
                'properties' => [
                    'time' => [
                        'type'  => 'integer',
                    ],
                    'resultCount' => [
                        'type'  => 'integer',
                    ],
                    'results' => [
                        'type'  => 'object',
                    ],
                ],
            ],
        );
    }
}
