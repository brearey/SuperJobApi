<?php

namespace inc;

class Worker
{
    public $token;
    public $name;
    public $age;
    public $town;

    /**
     * @param $token
     * @param $name
     * @param $age
     * @param $town
     */
    public function __construct($token, $name, $age, $town)
    {
        $this->token = $token;
        $this->name = $name;
        $this->age = $age;
        $this->town = $town;
    }


}