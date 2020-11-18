<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidWords::class,
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            (new $inspection())->detect($body);
        }

        return false;
    }
}
