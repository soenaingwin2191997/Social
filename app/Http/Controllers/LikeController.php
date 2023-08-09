<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function create(Request $request)
    {
        $like = Like::where('post_id', $request->post_id)
            ->where('user_id', $request->user_id)->first();

        if($like){
            if($like->like==1){
                $like=Like::find($like->id);
                $like->like=0;
                $like->save();
            }else{
                $like=Like::find($like->id);
                $like->like=1;
                $like->save();
            }
        }else{
            $like=Like::insert([
                'user_id'=>$request->user_id,
                'post_id'=>$request->post_id,
                'created_at'=>Carbon::now(),
            ]);
        }
        return response($like);
    }
}
