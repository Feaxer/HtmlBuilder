<?php
namespace Feax\Html;


class Facade {
    public static function __callStatic($method, $args) {
        $instance = new static::$class();
        var_dump(is_object($instance));
        
        switch (count($args)) {
            case 0:
                return $instance->$method();
                
            case 1:
                return $instance->$method($args[0]);
                
            case 2:
                return $instance->$method($args[0], $args[1]);
                
            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);
                
            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);
                
            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }
}