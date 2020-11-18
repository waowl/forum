<?php

namespace App\Inspections;

use Exception;

class InvalidWords
{
    public function detect($body)
    {
        $this->detectSpamWords($body);

        return false;
    }

    private function detectSpamWords($body)
    {
        $list = ['spam', 'ads'];

        foreach ($list as $word) {
            if (stripos($body, $word) !== false) {
                throw  new Exception('Your reply contains spam!');
            }
        }
    }
}
