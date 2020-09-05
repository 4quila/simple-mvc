<?php

class m0002_add_column_created_at
{
    public function up()
    {
        $db = \app\core\Application::$app->database;
        $db->pdo->exec("ALTER TABLE `users` ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP;");
    }

    public function down()
    {
        $db = \app\core\Application::$app->database;
        $db->pdo->exec("ALTER TABLE `users` DROP COLUMN `created_at`;");
    }
}