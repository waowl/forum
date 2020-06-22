<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();
        if (\request()->expectsJson()) {
            return response(['status'=> 'You favorited a reply']);
        }

        return redirect()->back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
        if (\request()->expectsJson()) {
            return response(['status'=> 'You unfavorited a reply']);
        }

        return redirect()->back();
    }
}
