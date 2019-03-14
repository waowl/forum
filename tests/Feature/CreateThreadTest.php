<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * @test
     *
     * */
    public function an_unauthenticated_user_may_not_create_a_thread()
    {
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
        $this->withoutExceptionHandling(['Illuminate\Auth\AuthenticationException'])->get('/thread/create')->assertRedirect('/login');
    }

    /**
     * @test
     *
     * */
    public function a_user_may_create_a_thread()
    {
        $this->actingAs(create(User::class));

        $thread = make(Thread::class);

        $this->post('/thread', $thread->toArray());

        $this->get('/thread')->assertSee($thread->title)->assertSee($thread->body);
    }

}
