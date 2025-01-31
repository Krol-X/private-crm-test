<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create the database specified in the .env file using the configured DB_CONNECTION';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Получаем параметры из .env
        $connection = env('DB_CONNECTION');
        $databaseName = env('DB_DATABASE');

        if (!$databaseName) {
            $this->error('Database name is not specified in the .env file (DB_DATABASE).');
            return;
        }

        switch ($connection) {
            case 'mysql':
                $this->createMySQLDatabase($databaseName);
                break;

            case 'pgsql':
                $this->createPostgresDatabase($databaseName);
                break;

            case 'sqlite':
                $this->createSQLiteDatabase($databaseName);
                break;

            default:
                $this->error("Unsupported database connection: $connection");
        }
    }

    private function createMySQLDatabase($databaseName)
    {
        $config = Config::get('database.connections.mysql');
        $config['database'] = null;

        try {
            $pdo = new \PDO(
                "mysql:host={$config['host']};port={$config['port']}",
                $config['username'],
                $config['password']
            );

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->info("MySQL database '$databaseName' created successfully.");
        } catch (\PDOException $e) {
            $this->error("Error creating MySQL database: " . $e->getMessage());
        }
    }

    private function createPostgresDatabase($databaseName)
    {
        $config = Config::get('database.connections.pgsql');
        $config['database'] = null;

        try {
            $pdo = new \PDO(
                "pgsql:host={$config['host']};port={$config['port']}",
                $config['username'],
                $config['password']
            );

            $pdo->exec("CREATE DATABASE \"$databaseName\"");
            $this->info("PostgreSQL database '$databaseName' created successfully.");
        } catch (\PDOException $e) {
            $this->error("Error creating PostgreSQL database: " . $e->getMessage());
        }
    }

    private function createSQLiteDatabase($databaseName)
    {
        $filePath = database_path($databaseName);

        if (file_exists($filePath)) {
            $this->info("SQLite database '$databaseName' already exists.");
        } else {
            try {
                touch($filePath);
                $this->info("SQLite database '$databaseName' created successfully at: $filePath");
            } catch (\Exception $e) {
                $this->error("Error creating SQLite database: " . $e->getMessage());
            }
        }
    }
}
