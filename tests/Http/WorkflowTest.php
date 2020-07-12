<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Http;

use BEAR\Dev\Http\BuiltinServerStartTrait;
use BEAR\Resource\ResourceObject;
use Ysato\BookLogger\Hypermedia\WorkflowTest as Workflow;
use Ysato\BookLogger\Injector;

class WorkflowTest extends Workflow
{
    use BuiltinServerStartTrait;

    protected function setUp(): void
    {
        $_SERVER['Authorization'] = '_secret_token_';
        $this->resource = $this->getHttpResourceClient(Injector::getInstance('app'), self::class);
    }

    public function testIndex(): ResourceObject
    {
        $index = $this->resource->get($this->httpHost . '/');
        $this->assertSame(200, $index->code);

        return $index;
    }
}
