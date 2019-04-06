<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function read($thread)
    {
        $key = $this->getVisitedThreadCacheKey($thread);
        cache()->forever($key, Carbon::now());
    }

    /**
     * @param $thread
     * @return string
     */
    public function getVisitedThreadCacheKey($thread): string
    {
          return sprintf("user.%s.visits.%s", $this->id, $thread->id);
    }


    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }
}
