<?php

namespace Tests\Unit;

use App\Activity;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_an_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);
        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => 'App\Thread',
        ]);
    }

    /** @test */
    public function it_records_an_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $thread = create(Reply::class);
        $this->assertCount(2, Activity::all());
    }

    /** @test */
    public function it_may_feed_activities()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $activities = Activity::feed(auth()->user());

        $this->assertContains(Carbon::now()->format('Y-m-d'), $activities->keys());
    }
}
