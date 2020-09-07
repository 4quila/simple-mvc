<?php

namespace app\core\form;
use app\core\Model;

class Field
{
    const TYPE_TEXT = 'text';
    const TYPE_EMAIL = 'email';
    const TYPE_PASSWORD = 'password';
    protected string $type;
    protected $model;
    protected $attr;

    public function __construct(Model $model, string $attr)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attr = $attr;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
              <label>%s</label>
              <input type="%s" name="%s" value="%s" class="form-control%s">
              <div class="invalid-feedback">
                %s
              </div>
            </div>
        ',
        $this->model->getLabels()[$this->attr],
        $this->type,
        $this->attr,
        $this->type !== self::TYPE_PASSWORD ? $this->model->{$this->attr} : '',
        $this->model->hasError($this->attr) ? ' is-invalid': '',
        $this->model->getFirstError($this->attr)
        );
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function emailField()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
}