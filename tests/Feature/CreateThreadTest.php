<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * */
    public function an_unauthenticated_user_may_not_create_a_thread()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make(Thread::class);

        $this->post('/thread', $thread->toArray());
    }

    /**
     * @test
     *
     * */
    public function an_unauthenticated_user_may_not_see_create_thread_page()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/thread/create')->assertRedirect('/login');
    }

    /**
     * @test
     *
     * */
    public function a_user_may_create_a_thread()
    {
        $this->actingAs(create(User::class));

        $thread = create(Thread::class);

        $this->post('/thread', $thread->toArray());

        $this->get('/thread')->assertSee($thread->title)->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function a_thread_requires_a_title()
    {
        $this->withExceptionHandling();

        $this->signIn(create(User::class));

        $thread = make(Thread::class, ['title' => null]);

        $this->post('/thread', $thread->toArray())->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_body()
    {
        $this->withExceptionHandling();

        $this->signIn(create(User::class));

        $thread = make(Thread::class, ['body' => null]);

        $this->post('/thread', $thread->toArray())->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_channel_id()
    {
        $this->withExceptionHandling();

        $this->signIn(create(User::class));

        $thread = make(Thread::class, ['channel_id' => null]);
        $threadTwo = make(Thread::class, ['channel_id' => 9999]);

        $this->post('/thread', $thread->toArray())->assertSessionHasErrors('channel_id');
        $this->post('/thread', $threadTwo->toArray())->assertSessionHasErrors('channel_id');
    }
}
