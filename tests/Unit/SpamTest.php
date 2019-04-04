<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use PHPUnit\Framework\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function spamfilter_can_detect_spam_words()
    {
        $this->expectException(\Exception::class);
        (new Spam())->detect('spam word');
    }
}
