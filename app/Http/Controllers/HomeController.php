<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller {

	public function index()
	{
		return view('desktop');
	}

	public function sobre()
	{
		return view('layouts.sobre');
	}

}
