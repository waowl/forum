<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
class FavoriteTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_guest_cant_favorite_anything()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = create(Reply::class);
        $this->post("/reply/{$reply->id}/favorite");

    }

    /** @test */
    public function a_user_can_favorite_any_reply()
    {
        $this->signIn(create(User::class));
        $reply = create(Reply::class);

        $this->post("/reply/{$reply->id}/favorite");

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function a_user_may_favorite_any_reply()
    {
        $this->withoutExceptionHandling();

        $this->signIn(create(User::class));
        $reply = create(Reply::class);

        $this->post("/reply/{$reply->id}/favorite");

        $this->assertDatabaseHas('favorites', ['favorited_id' => $reply->id]);
    }

    /** @test */
    public function a_user_may_unfavorite_any_reply()
    {
        $this->withoutExceptionHandling();

        $this->signIn(create(User::class));
        $reply = create(Reply::class);

        $this->post("/reply/{$reply->id}/favorite");

        $this->assertDatabaseHas('favorites', ['favorited_id' => $reply->id]);

        $this->delete("/reply/{$reply->id}/favorite");
        $this->assertDatabaseMissing('favorites', ['favorited_id' => $reply->id]);
    }
}
