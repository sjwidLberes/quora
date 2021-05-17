<?php

namespace App\Http\Controllers;



class NotifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user = authuser();
        $user->notifications->markAsRead();
        return view('notify.index',compact('user'));
    }
}
