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
        $this->data = require __DIR__ . '/../config.php';
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key){
        return $this->data[$key];
    }
}