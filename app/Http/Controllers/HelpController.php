<?php namespace BookieGG\Http\Controllers;

use BookieGG\Http\Requests;

use Illuminate\Http\Request;

class HelpController extends Controller {
	public function show()
	{
		return view('help/index');
	}

}
