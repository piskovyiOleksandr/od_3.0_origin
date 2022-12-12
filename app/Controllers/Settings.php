<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;

class Settings extends Controller
{
	public function index()
	{
		
		return view('settings');
	}
}
