<?php

declare(strict_types=1);

namespace App\Entity;

class Owner
{
    public string $name;
    public string $firstname;
    public string $job;

    public function __construct(string $name, string $firstname, string $job)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->job = $job;
    }
}
