<?php

namespace inc;

class Vacancy
{
    public int $payment_from;
    public int $payment_to;
    public string $profession;
    public ?string $work;
    public string $candidat;
    public ?TypeOfWork $type_of_work;
    public ?PlaceOfWork $place_of_work;
    public ?Education $education;
    public Experience $experience;
    public ?array $catalogues;
    public ?Town $town;
    public ?string $client_logo;
    public int $age_from;
    public int $age_to;
    public ?string $firm_name;
    public ?string $firm_activity;
    public ?string $phone;

    /**
     * @param int $payment_from
     * @param int $payment_to
     * @param string $profession
     * @param string|null $work
     * @param string $candidat
     * @param TypeOfWork|null $type_of_work
     * @param PlaceOfWork|null $place_of_work
     * @param Education|null $education
     * @param Experience $experience
     * @param array|null $catalogues
     * @param Town|null $town
     * @param string|null $client_logo
     * @param int $age_from
     * @param int $age_to
     * @param string|null $firm_name
     * @param string|null $firm_activity
     * @param string|null $phone
     */
    public function __construct(int $payment_from, int $payment_to, string $profession, ?string $work, string $candidat, ?TypeOfWork $type_of_work, ?PlaceOfWork $place_of_work, ?Education $education, Experience $experience, ?array $catalogues, ?Town $town, ?string $client_logo, int $age_from, int $age_to, ?string $firm_name, ?string $firm_activity, ?string $phone)
    {
        $this->payment_from = $payment_from;
        $this->payment_to = $payment_to;
        $this->profession = $profession;
        $this->work = $work;
        $this->candidat = $candidat;
        $this->type_of_work = $type_of_work;
        $this->place_of_work = $place_of_work;
        $this->education = $education;
        $this->experience = $experience;
        $this->catalogues = $catalogues;
        $this->town = $town;
        $this->client_logo = $client_logo;
        $this->age_from = $age_from;
        $this->age_to = $age_to;
        $this->firm_name = $firm_name;
        $this->firm_activity = $firm_activity;
        $this->phone = $phone;
    }

}