<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Channel $channel, Thread $thread) {
        return $thread->replies()->paginate(4);
    }

    public function create(Channel $channel, Thread $thread)
    {
        $this->validate(\request(), [
           'body' => 'required'
        ]);
        $reply = $thread->addReply([
           'body' => \request('body'),
           'user_id' => auth()->id()
        ]);

        if(\request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Reply was added.');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        if (\request()->expectsJson()) {
            return response(['status' => 'Reply was deleted!']);
        }
        return back();
    }

    public function update(Reply $reply)
    {
        $reply->update(\request()->all());

        return ['status' => 'Reply updated!'];
    }

}
