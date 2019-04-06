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

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

    }


    /**
     * @test
     *
     * */
    public function an_unauthorized_user_may_not_create_a_reply()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();
        $this->post($thread->path() . '/reply', $reply->toArray());

    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . "/reply", $reply->toArray())->assertStatus(422);

    }


    /** @test */
    public function an_unauthorized_user_cant_delete_a_reply()
    {
        $reply = create(Reply::class);

        $this->delete("/reply/{$reply->id}")->assertRedirect('/login');
    }

    /** @test */
    public function an_authorized_user_can_delete_a_reply()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/reply/{$reply->id}");

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

    /** @test */
    public function an_authorized_user_can_update_a_reply()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->patch("/reply/{$reply->id}", ['body' => 'Hi']);

        $this->assertDatabaseHas('replies', ['body' => 'Hi']);

    }


    /** @test */
    public function reply_contains_spam_may_not_be_created()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, [
            'body' => 'spam'
        ]);

        $response = $this->post($thread->path() . '/reply', $reply->toArray());
        $response->assertStatus(422);
    }

    /** @test */
    public function an_user_can_add_reply_only_one_time_per_minute()
    {
        $this->signIn();

        $thread = create(Thread::class);
        $reply1 = make(Reply::class, ['body' => 'hey']);

        $this->post($thread->path() . '/reply', $reply1->toArray())->assertStatus(200);

        $reply2 = make(Reply::class, ['body' => 'he33']);

        $this->post($thread->path() . '/reply', $reply2->toArray())
            ->assertStatus(422);

    }

}
