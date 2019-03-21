<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
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

    /**
     * @test
     *
     * */
    public function user_can_see_threads_in_a_channel()
    {
        $channel = create(Channel::class);
        $threadIn = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotIn = create(Thread::class);

        $this->get("/thread/{$channel->slug}")->assertSee($threadIn->title)->assertDontSee($threadNotIn->title);
    }

    /** @test */
    public function a_user_can_read_thread_created_by_concrete_user()
    {
        $user = create(User::class, ['name'=> 'John']);

        $this->signIn($user);
        $thread = create(Thread::class, ['user_id' => $user->id, 'channel_id' => 1]);
        $this->get('/thread?by=John')
            ->assertSee($thread->title);

    }
}
