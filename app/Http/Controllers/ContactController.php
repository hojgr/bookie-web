<?php namespace BookieGG\Http\Controllers;

use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ContactController extends Controller {
	public function show()
	{
		return view('contact/index');
	}

}
