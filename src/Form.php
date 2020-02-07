<?php

namespace QuarkLaravel;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Form
{
    /**
     * Available fields.
     *
     * @var array
     */
    public static $availableFields = [
        'text' => Form\Fields\Input::class,
    ];

    /**
     * Create a new form instance.
     *
     * @param $model
     * @param \Closure $callback
     */
    public function __construct()
    {
        $this->component = 'form';
    }

    /**
     * Find field class.
     *
     * @param string $method
     *
     * @return bool|mixed
     */
    public static function findFieldClass($method)
    {
        $class = Arr::get(static::$availableFields, $method);

        if (class_exists($class)) {
            return $class;
        }

        return false;
    }

    public function __call($method, $arguments) {
        if ($className = static::findFieldClass($method)) {
            $column = Arr::get($arguments, 0, ''); //[0];

            $element = new $className($column, array_slice($arguments, 1));

            return $element;
        }
    }
}
