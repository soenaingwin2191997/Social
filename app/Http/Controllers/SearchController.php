<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function index(){
        $users=User::all();
        return view('social.search',['users'=>$users]);
    }
}
