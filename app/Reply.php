<?php

namespace App;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoritable;

class Reply extends Model
{
    use Favoritable, RecordActivity;

    protected $appends = ['isFavorited'];
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];

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
        return $this->thread->path() .'#reply' . $this->id;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}
