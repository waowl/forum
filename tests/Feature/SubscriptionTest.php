<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_user_can_subscribes_to_test()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path().'/subscription');
        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribes_to_test()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path().'/subscription');
        $this->delete($thread->path().'/subscription');
        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function a_user_will_be_notified()
    {
        $this->signIn();
        $producer = create(User::class);
        $thread = create(Thread::class);
        $this->post($thread->path().'/subscription');
        $thread->addReply([
            'body' => 'test',
            'user_id' => $producer->id
        ]);

        $this->assertCount(1, auth()->user()->notifications);
    }

}
