<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipationForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     *
     * @test
     */
    public function an_authorized_user_may_create_a_reply()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();

        $this->post($thread->path() . '/reply', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);

    }


    /**
     * @test
     *
     * */
    public function an_unauthorized_user_may_not_create_a_reply()
    {
        $this->expectException(AuthenticationException::class);
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();
        $this->post($thread->path() . '/reply', $reply->toArray());

    }
}
