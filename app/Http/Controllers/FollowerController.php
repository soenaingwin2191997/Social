<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function index()
    {
        $users = User::inRandomOrder()->limit(100)->get();
        return view('social.follow', [
            'users' => $users,
            'action' => 'all',
        ]);
    }

    public function show($action,$id)
    {
        if ($action == 'followers') {
            $users = Follower::select('*','users.id as id')
            ->join('users','followers.receiver','users.id')
            ->where('sender',$id)->get();
            return view('social.follow', [
                'users' => $users,
                'action' => $action,
            ]);
        }
        if ($action == 'following') {
            $users = Follower::select('*','users.id as id')
            ->join('users','followers.sender','users.id')
            ->where('receiver',$id)->get();
            return view('social.follow', [
                'users' => $users,
                'action' => $action,
            ]);
        }
    }

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
