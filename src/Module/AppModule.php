<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use Symfony\Component\Dotenv\Dotenv;

use function dirname;

class AppModule extends AbstractAppModule
{
    protected function configure(): void
    {
        (new Dotenv())->loadEnv(dirname(__DIR__, 2) . '/.env');
        $this->install(new PackageModule());
    }
}
