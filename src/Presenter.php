<?php

namespace Laracodes\Presenter;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $property
     * @return bool
     */
    public function __isset($property)
    {
        return method_exists($this, Str::camel($property));
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        $camel_property = Str::camel($property);

        if (method_exists($this, $camel_property)) {
            return $this->{$camel_property}();
        }

        return $this->model->{Str::snake($property)};
    }
}
