<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $topics = \App\Topic::select('id','title')->where('title','like','%'.$request->query('q').'%')->get();
    return $topics;
});

Route::middleware('auth:api')->get('/question/{question_id}/isfollow','FollowController@isFollowedQuestion');
Route::middleware('auth:api')->post('/question/{question_id}/follow','FollowController@followQuestion');

Route::middleware('auth:api')->get('/user/{user_id}/isfollow','FollowController@isFollowedUser');
Route::middleware('auth:api')->post('/user/{user_id}/follow','FollowController@followUser');

Route::middleware('api')->get('/answer/{answer_id}/isvote','VoteAnswerController@isVotedAnswer');
Route::middleware('auth:api')->post('/answer/{answer_id}/vote','VoteAnswerController@voteAnswer');

Route::middleware('auth:api')->post('/sendmessage/','MessageController@sendMessage');

Route::middleware('api')->get('/answer/{answer_id}/comments','CommentController@answerComments');
Route::middleware('api')->get('/question/{question_id}/comments','CommentController@questionComments');
Route::middleware('auth:api')->post('/comment/','CommentController@store');

Route::middleware('auth:api')->post('/changepassword/','Auth\SetController@changePassword');
Route::middleware('auth:api')->post('/editprofile/','Auth\SetController@editProfile');