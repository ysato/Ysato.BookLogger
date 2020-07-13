<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

(new Dotenv())->loadEnv(dirname(__DIR__) . '/.env');

chdir(dirname(__DIR__));
passthru('rm -rf ./var/tmp/*');
passthru('chmod 775 var/tmp');
passthru('chmod 775 var/log');

$dsn = sprintf('mysql:host=%s;port=%s;', $_ENV['DB_HOST'], $_ENV['DB_PORT']);
$pdo = new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
$pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $_ENV['DB_NAME']);
$pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $_ENV['DB_NAME'] . '_test');
passthru('./vendor/bin/phinx migrate -c var/phinx/phinx.php -e development');
passthru('./vendor/bin/phinx migrate -c var/phinx/phinx.php -e test');
