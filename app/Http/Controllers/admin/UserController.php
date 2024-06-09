<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){
        $users=User::orderBy('created_at','DESC')->paginate(10);
        return view('backend.users.list',compact('users'));
    }
}
