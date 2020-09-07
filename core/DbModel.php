<?php

namespace app\core;

abstract class DbModel extends Model
{
    abstract public function attributes(): array;

    abstract public function tableName(): string;

    public function save()
    {
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $sql = "INSERT INTO ".$this->tableName()." (".implode(', ', $attributes).") "."VALUES (".implode(', ', $params).")";
        $stmt = self::prepare($sql);
        foreach ($attributes as $attribute)
        {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }
        $stmt->execute();
        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->database->pdo->prepare($sql);
    }
}