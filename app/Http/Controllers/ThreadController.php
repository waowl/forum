<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('thread.index', compact('threads'));
    }

    public function view(Thread $thread)
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
            'title' => \request('title'),
            'body' => \request('body')
        ]);

        return redirect($thread->path());
    }

}
