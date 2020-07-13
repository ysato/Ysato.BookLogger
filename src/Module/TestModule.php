<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Module;

use BEAR\Package\AbstractAppModule;
use Ray\AuraSqlModule\AuraSqlModule;
use Symfony\Component\Dotenv\Dotenv;

use function dirname;
use function getenv;

class TestModule extends AbstractAppModule
{
    protected function configure(): void
    {
        $appDir = dirname(__DIR__, 2);
        (new Dotenv())->usePutenv()->loadEnv($appDir . '/.env');
        $this->install(
            new AuraSqlModule(
                getenv('DB_DSN') . '_test',
                getenv('DB_USER'),
                getenv('DB_PASS'),
                getenv('DB_SLAVE'),
            )
        );
    }
}
