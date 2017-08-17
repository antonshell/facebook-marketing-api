<?php

namespace classes;

/**
 * Class Config
 */
class Config{

    public $data = [];

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $path = __DIR__ . '/../_config.php';

        if(!file_exists($path)){
            throw new \Exception('Config file not exists');
        }

        $this->data = require $path;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key){
        return $this->data[$key];
    }
}