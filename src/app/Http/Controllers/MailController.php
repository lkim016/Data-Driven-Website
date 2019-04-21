<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function basic_email()
    {
        $data=array('name'=>"Joseph Moon");

        Mail::send(['text'=>'mail'], $data, function($message) 
        {
            $message->to('thisisforadss@gmail.com', 'CIS 197 Project')->subject('Laravel Basic Testing Mail');
            $message->from('cis197group1@gmail.com', 'Joseph Moon');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
    public function html_email()
    {
        $data=array('name'=>'Joseph Moon');
        Mail::send('mail', $data, function($message) {
            $message->to('thisisforadss@gmail.com', 'CIS 197 Project')->subject('Laravel HTML Testing Mail');
            $message->from('cis197group1@gmail.com', 'Joseph Moon');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
    public function attachment_email()
    {
        $data=array('name'=>"Joseph Moon");
        Mail::send('mail',$data, function($message) {
            $message->to('thisisforadss@gmail.com', 'CIS 197 Project')->subject('Laravel Testing Mail with Attachment');
            $message->attach('/home/joseph/Downloads/assign3.pdf');
            $message->attach('/home/joseph/Downloads/assign2.pdf');
            $message->from('cis197group1@gmail.com', 'Joseph Moon');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
