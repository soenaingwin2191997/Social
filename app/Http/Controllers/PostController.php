<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('*', 'posts.id as id')
            ->join('users', 'posts.user_id', 'users.id')
            ->orderBy('posts.id','DESC')->get();
        return view('social.index', ['posts' => $posts]);
    }

    function create(Request $request){
        if($request->file('photo')){
            $photoName=uniqid().'_'.$request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/post_photos',$photoName);
        }

        Post::create([
            'user_id'=>$request->user_id,
            'caption'=>$request->caption,
            'photo'=>$photoName,
        ]);

        return back();
    }
}
