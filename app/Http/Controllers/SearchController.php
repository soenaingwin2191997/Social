<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function index(){
        $users=User::inRandomOrder()->limit(100)->get();
        return view('social.search',['users'=>$users]);
    }
}
