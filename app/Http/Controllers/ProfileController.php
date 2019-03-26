<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activities = Activity::feed($user);
        $threads = $user->threads()->paginate(30);
        return view('profile.view', compact('user','threads', 'activities'));
    }


}
