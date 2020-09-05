<?php

class m0001_users
{
    public function up()
    {
        $db = \app\core\Application::$app->database;
        $db->pdo->exec("CREATE TABLE `users`(
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `firstname` VARCHAR(255) NOT NULL,
        `lastname` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `status` TINYINT NOT NULL
        ) ENGINE=INNODB;");
    }

    public function down()
    {
        $db = \app\core\Application::$app->database;
        $db->pdo->exec("DROP TABLE `users`;");
    }
}