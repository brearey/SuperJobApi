<?php

namespace inc;

class Town
{
    public int $id;
    public string $title;
    public string $declension;
    public string $genitive;

    /**
     * @param int $id
     * @param string $title
     * @param string $declension
     * @param string $genitive
     */
    public function __construct(int $id, string $title, string $declension, string $genitive)
    {
        $this->id = $id;
        $this->title = $title;
        $this->declension = $declension;
        $this->genitive = $genitive;
    }
}