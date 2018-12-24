<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use App\Email;

class MailController extends Controller
{

    public function queryMail(Request $req){
    	$email_list = array();
    	$messages = LaravelGmail::message()->subject($req->input('q','Google'))->unread()->take(7)->preload()->all();
		foreach ( $messages as $message ) {
		    $body = $message->getHtmlBody();
		    $subject = $message->getSubject();
		    $email = new Email();
		    $email->username= $req->session()->get('user');
		    $email->htmlBody = $body;
		    $email->title = $subject;
		    $email->save();
		    array_push($email_list,['body'=>$body,'subject'=>$subject]);
		}
		header('Content-Type:application/json');
		echo json_encode($email_list);
    }

	public function queryMailDb(Request $req){
    	$email_list = array();
    	$messages = Email::all();
		foreach ( $messages as $message ) {
		    $body = $message->htmlBody;
		    $subject = $message->title;
		    array_push($email_list,['body'=>$body,'subject'=>$subject]);
		}
		header('Content-Type:application/json');
		echo json_encode($email_list);
    }

}
