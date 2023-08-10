<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ]);
        return response($comment);
    }

    public function show(Request $request)
    {
        $comments = Comment::select('*', 'comments.created_at as created_at')
            ->join('users', 'comments.user_id', 'users.id')
            ->where('post_id', $request->post_id)->get();

        return response($comments);
    }
}
