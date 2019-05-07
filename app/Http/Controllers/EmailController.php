<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Mail\KirimEmail;
use Mail;

class EmailController extends Controller
{
	public function index(){
		Mail::to("testing@malasngoding.com")->send(new KirimEmail());
		return "Email telah dikirim";
	}

}
