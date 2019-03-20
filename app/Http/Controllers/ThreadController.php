<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'view');
    }

    public function index(Channel $channel)
    {
        $threads = $channel->threads()->exists() ? $channel->threads()->latest()->get() : Thread::latest()->get();
        return view('thread.index', compact('threads'));
    }

    public function view(Channel $channel, Thread $thread)
    {
        return view('thread.view', compact('thread'));
    }

    public function create()
    {
        return view('thread.create');
    }

    public function store()
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => \request('channel_id'),
            'title' => \request('title'),
            'body' => \request('body')
        ]);

        return redirect($thread->path());
    }

}
