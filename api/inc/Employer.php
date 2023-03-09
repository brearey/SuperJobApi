<?php

namespace inc;

class Employer
{
    public $token;
    public $name;
    public $town;

    /**
     * @param $token
     * @param $name
     * @param $town
     */
    public function __construct($token, $name, $town)
    {
        $this->token = $token;
        $this->name = $name;
        $this->town = $town;
    }


}