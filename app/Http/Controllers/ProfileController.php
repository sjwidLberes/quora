<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function toQuestion($id){
        $user = $this->userRepository->byId($id);
        return view('profile.question',compact('user'));
    }
    public function toAnswer($id){
        $user = $this->userRepository->byId($id);
        return view('profile.answer',compact('user'));
    }
    public function toFollower($id){
        $user = $this->userRepository->byId($id);
        return view('profile.follower',compact('user'));
    }
    public function toFollowing($id){
        $user = $this->userRepository->byId($id);
        return view('profile.following',compact('user'));
    }
    public function toFollowQuestion($id){
        $user = $this->userRepository->byId($id);
        return view('profile.followquestion',compact('user'));
    }
    public function toLike($id){
        $user = $this->userRepository->byId($id);
        return view('profile.like',compact('user'));
    }
}
