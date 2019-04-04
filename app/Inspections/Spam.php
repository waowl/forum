<?php


namespace App\Inspections;
use App\Inspections\InvalidWodrs;

class Spam
{
    protected $inspections = [
        InvalidWodrs::class
    ];

   public function detect($body)
   {
       foreach ($this->inspections as $inspection) {
           (new $inspection)->detect($body);
       }
       return false;

   }
}
