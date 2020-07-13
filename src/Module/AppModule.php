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
use function getenv;

class AppModule extends AbstractAppModule
{
    protected function configure(): void
    {
        $appDir = dirname(__DIR__, 2);
        (new Dotenv())->usePutenv()->loadEnv($appDir . '/.env');
        $this->install(
            new AuraSqlModule(
                getenv('DB_DSN'),
                getenv('DB_USER'),
                getenv('DB_PASS'),
                getenv('DB_SLAVE'),
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
        $this->install(new JsonSchemaLinkHeaderModule('http://www.example.com/'));
        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new PackageModule());
    }
}
