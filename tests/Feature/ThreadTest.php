<?php

namespace Tests\Feature;

use App\Reply;
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

        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     *
     * */
    public function user_can_see_a_reply_that_assosiated_with_a_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());

        $response->assertSee($reply->body);
    }
}
