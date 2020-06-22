<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable
{
    public static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $this->favorites()->create(['user_id' => auth()->id()]);
    }

    public function unfavorite()
    {
        $this->favorites()->where(['user_id' => auth()->id()])->get()->each(function ($favotite) {
            $favotite->delete();
        });
    }

    public function isFavorited()
    {
        return (bool) $this->favorites()->where(['user_id' => auth()->id()])->count();
    }
}
