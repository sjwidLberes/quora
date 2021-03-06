<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    public function user(){
        $users = User::all();
        return view('admin.user',compact('users'));
    }
}
