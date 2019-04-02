<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel, Thread $thread)
    {
        return $thread->subscribe();
    }

    public function destroy(Channel $channel, Thread $thread)
    {
        return $thread->unsubscribe();
    }
}
