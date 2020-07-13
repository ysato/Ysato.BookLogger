<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Module;

use BEAR\Package\AbstractAppModule;
use Ray\AuraSqlModule\AuraSqlModule;
use Symfony\Component\Dotenv\Dotenv;

use function dirname;

class TestModule extends AbstractAppModule
{
    protected function configure(): void
    {
        $appDir = dirname(__DIR__, 2);
        (new Dotenv())->loadEnv($appDir . '/.env');
        $this->install(
            new AuraSqlModule(
                $_ENV['DB_DSN'] . '_test',
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                $_ENV['DB_SLAVE'],
            )
        );
    }
}
