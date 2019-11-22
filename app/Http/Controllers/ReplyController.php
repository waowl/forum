<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Gate;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(4);
    }

    public function create(Channel $channel, Thread $thread)
    {
        if (Gate::denies('create', new Reply())) {
            return response('You post too frequently!', 422);
        }

        try {
            \request()->validate(['body' => 'required|spamfree']);
            $reply = $thread->addReply([
                'body'    => \request('body'),
                'user_id' => auth()->id(),
            ]);
        } catch (\Exception $exception) {
            return response('Your reply could not be saved!', 422);
        }

        if (\request()->expectsJson()) {
            return $reply->load('owner');
        }

        return response('Reply was added', 200);
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
        try {
            \request()->validate(['body' => 'required|spamfree']);
        } catch (\Exception $exception) {
            return response('Your reply could not be saved!', 422);
        }
        $reply->update(\request()->all());

        return ['status' => 'Reply updated!'];
    }
}
