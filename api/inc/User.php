<?php

namespace inc;

class User
{
    public $id;
    public $token;
    public $name;
    public $age;

    public function __construct($id, $token, $name, $age)
    {
        $this->id = $id;
        $this->token = $token;
        $this->name = $name;
        $this->age = $age;
    }
}