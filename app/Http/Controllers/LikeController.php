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

        if ($like) {
            $like = Like::find($like->id)->delete();
        } else {
            $like = Like::insert([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'created_at' => Carbon::now(),
            ]);
        }
        return response($like);
    }

    public function show(Request $request)
    {
        $likes = Like::join('users', 'likes.user_id', 'users.id')
            ->where('post_id', $request->post_id)->get();

        // $like=[];
        // foreach($likes as $lik){
        //     $like[]="
        //     <div class='col d-flex'>
        //     <div class='col d-flex p-2'>
        //         <div style='border-radius: 50%; border: 3px solid gray; width:60px;    height:60px;'
        //             class='overflow-hidden'>
        //             <img style='object-fit: cover;' class='w-100 h-100'
        //                 src='{{ asset('storage/profile_photos/$lik->profile_photo') }}' alt='Photo'>
        //         </div>
        //         <div class='px-2 py-1'>
        //             <span class='fw-bold'>$lik->name</span>
        //         </div>
        //     </div>
        //     <div class='col-4 text-end p-3'>
        //         <button type='button' class='btn btn-info followAddBtn btn-sm px-3'>Follow</button>
        //     </div>
        // </div>
        //     ";
        // }

        return response($likes);
    }
}
