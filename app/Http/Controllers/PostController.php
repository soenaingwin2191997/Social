<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('*', 'posts.id as id')
            ->join('users', 'posts.user_id', 'users.id')->get();
        return view('social.index', ['posts' => $posts]);
    }
}
