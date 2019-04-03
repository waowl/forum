<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_read_all_notifications()
    {
        $this->signIn();
        $producer = create(User::class);

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscription');

        $thread->addReply([
            'body' => '1',
            'user_id' => $producer->id
        ]);
        $response = $this->getJson( "/profiles/".auth()->user()->name."/notifications")->json();
        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_notifications_as_read()
    {
        $this->signIn();
        $producer = create(User::class);

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscription');

        $thread->addReply([
            'body' => '1',
            'user_id' => $producer->id
        ]);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete( "/profiles/".auth()->user()->name."/notifications/".$notificationId);

        $this->assertCount(0, auth()->user()->unReadNotifications);
    }
}
