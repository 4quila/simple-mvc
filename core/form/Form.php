<?php

namespace app\core\form;
use app\core\Model;

class Form
{
    public static function start(string $action, string $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new self();
    }

    public function field(Model $model, string $attr)
    {
        return new Field($model, $attr);
    }

    public static function end()
    {
        echo '</form>';
    }
}