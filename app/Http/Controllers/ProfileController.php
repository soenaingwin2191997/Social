<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;

class ProfileController extends Controller
{
    public function index($id)
    {
        $followers = Follower::where('sender', $id)->count();
        $following = Follower::where('receiver', $id)->count();
        $posts = Post::select('*', 'posts.id as id')
            ->join('users', 'posts.user_id', 'users.id')
            ->where('user_id', $id)->get();
        $user = User::find($id);
        return view('social.profile', [
            'user' => $user,
            'followers' => $followers,
            'following' => $following,
            'posts' => $posts,
        ]);
    }
}
