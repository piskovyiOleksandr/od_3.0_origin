<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
	public function index()
	{
		
		return view('index');
	}
}
