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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//______________________________________________________________________________
Route::get('/home', [
    'uses' => 'PostController@getDashboard',
    'as' => 'home',
    'middleware' => 'auth'
]);

Route::get('/', [
    'uses' => 'PostController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth'
]);
Route::get('/account',[
    'uses'=>'UserController@getAccount',
    'as'=>'account'
]);

Route::post('/updateaccount',[
    'uses'=> 'UserController@postSaveAccount',
    'as'=>'account.save'
]);

Route::get('/userimage/{filename}',[
    'uses'=>'UserController@getUserImage',
    'as'=>'account.image'
]);

Route::post('/createpost',[
	'uses'=> 'PostController@postArticle',
	'as'=>'post.create'
	]);

//Route::post('/deletepost','PostController@postDelete');

Route::get('/d/{post_id}',[
	'uses'=> 'PostController@getDeletePost',
	'as'=>'post.delete'
	]);

Route::get('/Logout',[
	'uses'=> 'UserController@LogOut',
	'as'=>'Logout'
	]);

Route::post('/edit',[
    'uses'=> 'PostController@postEditPost',
    'as'=>'edit'
]);

Route::post('/tag/{post_id}',[
    'uses'=> 'PostController@tagFun',
    'as'=>'post.tag'
]);
Route::post('/Tag',[
    'uses'=> 'PostController@postTagsPost',
    'as'=>'Tag'
]);
Route::get('/hashtags',[
    'uses'=> 'PostController@getHashtags',
    'as'=>'hashtags'
]);

Route::get('/search','PostController@getSearch')->name('search');

 // Route::get('/search', function () {
 //     echo dd('rr');
 // })->name('search');