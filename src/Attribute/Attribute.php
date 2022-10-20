<?php

namespace Lackoxygen\ExceptionPush\Attribute;

trait Attribute
{
    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }
}
