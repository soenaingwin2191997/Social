<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function create(Request $request){
        $comment=Comment::create([
            'user_id'=>$request->user_id,
            'post_id'=>$request->post_id,
            'comment'=>$request->comment,
        ]);
        return response($comment);
    }
}
