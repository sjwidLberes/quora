<?php

namespace App\Http\Controllers;

use App\Http\Transformers\TaskTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\task;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller
{
    use Helpers;
    public function index(){
        $tasks = task::all();
        return $this->collection($tasks, new TaskTransformer());
    }
    public function store(Request $request){
        $task = task::create([
            'title' => $request->title,
            'completed' => 0,
        ]);
        return $this->item($task, new TaskTransformer());
    }
    public function update($id){
        $task = task::find($id);
        $task->completed = !$task->completed;
        $task->save();
        return response('update success');
    }
    public function delete($id){
        $task = task::find($id);
        $task->delete();
        return response('delete success');
    }
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}
