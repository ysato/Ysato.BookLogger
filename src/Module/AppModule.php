<?php

declare(strict_types=1);

namespace Ysato\BookLogger\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use BEAR\Resource\Module\JsonSchemaLinkHeaderModule;
use BEAR\Resource\Module\JsonSchemaModule;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\IdentityValueModule\IdentityValueModule;
use Ray\Query\SqlQueryModule;
use Symfony\Component\Dotenv\Dotenv;

use function dirname;

class AppModule extends AbstractAppModule
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
        $this->install(new SqlQueryModule($appDir . '/var/sql'));
        $this->install(new IdentityValueModule());
        $this->install(
            new JsonSchemaModule(
                $appDir . '/var/json_schema',
                $appDir . '/var/json_validate',
            )
        );
        $this->install(new JsonSchemaLinkHeaderModule('https://ysato.github.io/Ysato.BookLogger/schema/'));
        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new PackageModule());
    }
}
