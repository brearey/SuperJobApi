<?php

namespace inc;

class Employer
{

    /*
    1-Токен
    2-Название организации
    3-Город
    4-ФИO
    5-uri
     */

    public string $token;
    public string $company_name;
    public string $town;
    public string $full_name;
    public ?string $photo_uri;

    /**
     * @param string $token
     * @param string $company_name
     * @param string $town
     * @param string $full_name
     * @param string|null $photo_uri
     */
    public function __construct(string $token, string $company_name, string $town, string $full_name, ?string $photo_uri)
    {
        $this->token = $token;
        $this->company_name = $company_name;
        $this->town = $town;
        $this->full_name = $full_name;
        $this->photo_uri = $photo_uri;
    }
}