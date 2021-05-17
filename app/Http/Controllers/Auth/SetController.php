<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SetController extends Controller
{
    public function index(){
        return view('auth.set');
    }

    public function setAvatar(Request $request){
        $file = $request->file('img');
        $file_name = md5(time().authuser()->id).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('avatars'),$file_name);

        authuser()->avatar = '/avatars/'.$file_name;
        authuser()->save();

        return ['url' => authuser()->avatar];
    }

    public function changePassword(ChangePasswordRequest $changePasswordRequest){

        if (Hash::check($changePasswordRequest->oldpassword,authuser('api')->password)){
            authuser('api')->password = bcrypt($changePasswordRequest->password);
            authuser('api')->save();
            return ['status' => 1];
        }
        return ['status' => 0];

    }
    public function editProfile(){
        authuser('api')->setting = request()->all();
        authuser('api')->save();
        return ['status' => 1];
    }
}
