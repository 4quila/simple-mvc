<?php

namespace app\core;
use \PDO;

class Database
{
    public $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $applied_migrations = $this->getAppliedMigrations();

        $files = scandir(Application::$app->ROOT_DIR . '/migrations');
        $toApllyMigrations = array_diff($files, $applied_migrations);
        $new_migrations = [];
        
        foreach ($toApllyMigrations as $migration)
        {
            if ($migration === "." || $migration === "..")
            {
                continue;
            }
            require_once Application::$app->ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log('Apllying migration ' . $className);
            $instance->up();
            $new_migrations[] = $migration;
            $this->log($className . ' applied.');
        }
        if ($new_migrations){
            $this->saveMigrations($new_migrations);
        }
        $this->log('All migrations are applied.');
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `migration` VARCHAR(255),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations()
    {
        $stmt = $this->pdo->prepare('SELECT `migration` FROM `migrations`');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $migrations = array_map(fn($m) => "('{$m}')", $migrations);
        $values = implode(', ', $migrations);
        $sql = 'INSERT INTO `migrations` (`migration`) VALUES ' . $values;
        $this->pdo->exec($sql);
    }
    
    public function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}