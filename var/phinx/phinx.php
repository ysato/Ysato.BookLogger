<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

(new Dotenv())->loadEnv(dirname(__DIR__, 2) . '/.env');

$development = new \PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$test = new \PDO($_ENV['DB_DSN'] . '_test', $_ENV['DB_USER'], $_ENV['DB_PASS']);

return [
    'paths' => [
        'migrations' => __DIR__ . '/migrations',
    ],
    'environments' => [
        'development' => [
            'name' => $development->query("SELECT DATABASE()")->fetchColumn(),
            'connection' => $development,
        ],
        'test' => [
            'name' => $test->query("SELECT DATABASE()")->fetchColumn(),
            'connection' => $test,
        ],
    ],
];
