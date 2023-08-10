<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function create(Request $request)
    {
        $follow = Follower::create([
            'sender' => $request->sender_id,
            'receiver' => $request->receiver_id,
        ]);

        return response($follow);
    }

    public function delete(Request $request)
    {
        $follow = Follower::where('sender', $request->sender_id)
            ->where('receiver', $request->receiver_id)->delete();

        return response($follow);
    }
}
