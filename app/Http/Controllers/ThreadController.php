<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'view');
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $channel->threads()->exists() ? $channel->threads()->latest() : Thread::latest();
        if (request('by')) {
            $threads = Thread::filter($filters);
        }
        $threads = $threads->get();
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => \request('channel_id'),
            'title' => \request('title'),
            'body' => \request('body')
        ]);

        return redirect($thread->path());
    }

}
