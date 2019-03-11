<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();

    }

    /**
     * @test
     */
    public function user_can_see_all_threads()
    {
        $response = $this->get('/thread');

        $response->assertSee($this->thread->title);

    }

    /**
     * @test
     *
     * */
    public function user_can_see_a_single_thread()
    {

        $response = $this->get("/thread/{$this->thread->id}");

        $response->assertSee($this->thread->title);
    }
}
