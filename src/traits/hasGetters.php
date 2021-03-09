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
        try {
            $fillable = $obj->getProperty('fillable')->getValue($this);
            foreach ($fillable as $prop) {
                $getter = 'get' . ucfirst($prop);
                if (property_exists($this, $prop)) {
                    $this->$getter = function () use ($prop) {
                        return $this->$prop;
                    };
                } else {
                    $this->$getter = function () use ($prop) {
                        return '';
                    };
                }
            }
        }
        catch (\ReflectionException $e) {
            if($_ENV['app_debug'] == true)
            {
                echo $e->getCode();
                echo $e->getMessage();
            }
        }

    }
}