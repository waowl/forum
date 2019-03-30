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
        $this->thread = create(Thread::class);

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
    public function user_can_see_a_reply_that_asosiated_with_a_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id
        ]);
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

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithThreeReplies = create(Thread::class);
        $threadWithTwoReplies = create(Thread::class);
         create(Reply::class,['thread_id'=> $threadWithThreeReplies->id], 3);
        create(Reply::class,['thread_id'=> $threadWithTwoReplies->id], 2);

        $response = $this->getJson('/thread?popularity=1')->json();

        $this->assertEquals([3, 2, 0],array_column($response, 'replies_count') );

    }

    /** @test */
    public function a_user_can_get_all_replies_from_given_thread()
    {
        $thread = create(Thread::class);

        create(Reply::class, ['thread_id' => $thread->id], 3);

        $response = $this->getJson($thread->path().'/reply')->json();
        $this->assertCount(1, $response['data']);
        $this->assertEquals(3, $response['total']);
    }
}
