<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/email/verify/{token}','EmailController@active')->name('email.verify');

Route::resource('question','QuestionController');

Route::post('/question/{question_id}/store','AnswerController@store')->name('answer.store');

Route::get('/question/{question_id}/follow','QuestionController@follow')->name('question.follow');

Route::get('/notify','NotifyController@index')->name('notify.index');

Route::get('/inbox/{dialog_id}','MessageController@messageDialog')->name('message.dialog');

Route::post('/inbox/{dialog_id}/store','MessageController@storeDialog');

Route::get('/setting', 'Auth\SetController@index')->name('auth.set')->middleware('auth');
Route::post('/avatar/upload', 'Auth\SetController@setAvatar');

Route::get('/profile/{user_id}/answer', 'ProfileController@toAnswer')->name('profile.answer');
Route::get('/profile/{user_id}/question', 'ProfileController@toQuestion')->name('profile.question');
Route::get('/profile/{user_id}/follower', 'ProfileController@toFollower')->name('profile.follower');
Route::get('/profile/{user_id}/following', 'ProfileController@toFollowing')->name('profile.following');
Route::get('/profile/{user_id}/followquestion', 'ProfileController@toFollowQuestion')->name('profile.followquestion');
Route::get('/profile/{user_id}/like', 'ProfileController@toLike')->name('profile.like');

Route::get('/dashboard', 'AdminController@index');
Route::get('/admin/users', 'AdminController@user');

Route::get('/home', 'HomeController@index');

Route::get('/test',function (){
    return view('test');
});

