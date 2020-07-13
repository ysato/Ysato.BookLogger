<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Resource\App;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Ray\Query\Annotation\Query;

/**
 * @Cacheable()
 */
class ReadBook extends ResourceObject
{
    /**
     * @JsonSchema(schema="read_book.json")
     * @Query("read_book_item_by_id", type="row")
     */
    public function onGet(string $id): ResourceObject
    {
        unset($id);

        return $this;
    }
}
