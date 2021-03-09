<?php


namespace traits;

use Closure;


trait hasGetters
{

    public function __call($closure, $args)
    {
        return call_user_func_array($this->{$closure}, $args);
    }

    public function __construct()
    {
        $obj = new \ReflectionClass($this);
        $props = $obj->getProperties();

        foreach($props as $prop) {
            $propName = $prop->getName();
            $propString = ucfirst($prop->getName());
            $funcName =  'get' . $propString;
            $this->$funcName = function() use ($propName) {
                return $this->$propName;
            };
        }
    }
}