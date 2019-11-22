<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidWodrs::class,
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            (new $inspection())->detect($body);
        }

        return false;
    }
}
