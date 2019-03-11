<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('thread.index', compact('threads'));
    }

    public function view(Thread $thread)
    {
        return view('thread.view', compact('thread'));
    }

}
