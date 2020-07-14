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
use Ray\IdentityValueModule\UuidInterface;
use Ray\Query\Annotation\Query;

/**
 * @Cacheable()
 */
class WishBooks extends ResourceObject
{
    /** @var callable */
    private $createWishBook;

    private UuidInterface $uuid;

    /**
     * @Named("createWishBook=wish_book_insert")
     */
    public function __construct(callable $createWishBook, UuidInterface $uuid)
    {
        $this->createWishBook = $createWishBook;
        $this->uuid = $uuid;
    }

    /**
     * @JsonSchema(schema="wish_books.json")
     * @Query("wish_book_list")
     */
    public function onGet(): ResourceObject
    {
        return $this;
    }

    /**
     * @ReturnCreatedResource()
     * @Transactional()
     * @Purge(uri="app://self/wish-books")
     */
    public function onPost(string $isbn): ResourceObject
    {
        $id = (string) $this->uuid;
        ($this->createWishBook)([
            'id' => $id,
            'isbn' => $isbn,
        ]);
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = "/wish-book?id=$id";

        return $this;
    }
}
