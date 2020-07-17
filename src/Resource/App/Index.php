<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Resource\App;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /** @var array<string, mixed> */
    public $body = [
        'overview' => 'This is the BookLogger REST API',
        'issue' => 'https://github.com/ysato/Ysato.BookLogger/issues',
        '_links' => [
            'self' => ['href' => '/'],
            'curies' => [
                'href' => 'rels/{rel}.html',
                'name' => 'bl',
                'templated' => true,
            ],
            'bl:read-book' => [
                'href' => '/read-books/{id}',
                'title' => 'The read book item',
                'templated' => true,
            ],
            'bl:read-books' => [
                'href' => '/read-books',
                'title' => 'The read book list',
            ],
        ],
    ];

    public function onGet(): ResourceObject
    {
        return $this;
    }
}
