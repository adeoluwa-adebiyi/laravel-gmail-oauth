<?php
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;

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

Route::get('/',function(){
	return "Hello World";
});


Route::get('/oauth/gmail', function (){
	try{
    return LaravelGmail::redirect();
}catch(Exception $e){
	echo $e->getMessage();
}
});

Route::get('/oauth/gmail/callback', function (){
    LaravelGmail::makeToken();
    session(['user'=>(LaravelGmail::getProfile())->getEmailAddress()]);
    return redirect()->to('/');
});

Route::get('/oauth/gmail/logout', function (){
    LaravelGmail::logout(); //It returns exception if fails
    return redirect()->to('/');
});

Route::get('/mail','MailController@queryMail');
Route::get('/dbmail','MailController@queryMailDb');