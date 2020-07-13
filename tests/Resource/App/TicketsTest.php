<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Resource\App;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use PHPUnit\Framework\TestCase;
use Ysato\BookLogger\Injector;

class TicketsTest extends TestCase
{
    private ResourceInterface $resource;

    protected function setUp(): void
    {
        $this->resource = Injector::getInstance('test-app')->getInstance(ResourceInterface::class);
    }

    /**
     * @return ResourceObject
     */
    public function testOnPost()
    {
        $ro = $this->resource->post('app://self/tickets', [
            'title' => 'title1',
            'status' => 'status1',
            'description' => 'description1',
            'assignee' => 'assignee1',
        ]);
        self::assertSame(StatusCode::CREATED, $ro->code);
        self::assertStringContainsString('/ticket?id=', $ro->headers[ResponseHeader::LOCATION]);

        return $ro;
    }

    /**
     * @return void
     *
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $ro = $this->resource->get('app://self' . $location);
        self::assertSame('title1', $ro->body['title']);
        self::assertSame('description1', $ro->body['description']);
        self::assertSame('assignee1', $ro->body['assignee']);
    }
}
