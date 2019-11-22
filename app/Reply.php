<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordActivity;

    protected $appends = ['isFavorited', 'favorited_count'];
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
        return $this->thread->path().'#reply'.$this->id;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritedCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function wasCreatedNow()
    {
        return  $this->created_at->gt(Carbon::now()->subMinute());
    }
}
