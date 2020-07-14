<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Resource\App;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use PHPUnit\Framework\TestCase;
use Ysato\BookLogger\Injector;

class WishBooksTest extends TestCase
{
    private ResourceInterface $resource;

    protected function setUp(): void
    {
        $this->resource = Injector::getInstance('test-app')->getInstance(ResourceInterface::class);
    }

    public function testOnPost(): ResourceObject
    {
        $ro = $this->resource->post('app://self/wish-books', ['isbn' => '9783161484100']);
        self::assertSame(StatusCode::CREATED, $ro->code);
        self::assertStringContainsString('/wish-book?id=', $ro->headers[ResponseHeader::LOCATION]);

        return $ro;
    }

    /**
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro): void
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $ro = $this->resource->get('app://self' . $location);
        self::assertSame('9783161484100', $ro->body['isbn']);
    }
}
