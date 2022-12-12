<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;

class Auth extends Controller
{
	public function index()
	{
		
		return view('auth');
	}
}
