<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\RepositoryModule\Annotation\Purge;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Ray\AuraSqlModule\Annotation\Transactional;
use Ray\Di\Di\Named;
use Ray\IdentityValueModule\NowInterface;
use Ray\IdentityValueModule\UuidInterface;
use Ray\Query\Annotation\Query;

/**
 * @Cacheable()
 */
class ReadBooks extends ResourceObject
{
    /** @var callable */
    private $createReadBook;
    private NowInterface $now;
    private UuidInterface $uuid;

    /**
     * @Named("createReadBook=read_book_insert")
     */
    public function __construct(callable $createReadBook, NowInterface $now, UuidInterface $uuid)
    {
        $this->createReadBook = $createReadBook;
        $this->now = $now;
        $this->uuid = $uuid;
    }

    /**
     * @JsonSchema(schema="read_books.json")
     * @Query("read_book_list")
     */
    public function onGet(): ResourceObject
    {
        return $this;
    }

    /**
     * @ReturnCreatedResource()
     * @Transactional()
     * @Purge(uri="app://self/read-books")
     */
    public function onPost(string $isbn): ResourceObject
    {
        $id = (string) $this->uuid;
        $time = (string) $this->now;
        ($this->createReadBook)([
            'id' => $id,
            'isbn' => $isbn,
            'read_at' => $time,
        ]);
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = "/read-book?id=$id";

        return $this;
    }
}
