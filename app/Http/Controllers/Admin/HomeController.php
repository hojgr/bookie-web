<?php


namespace BookieGG\Http\Controllers\Admin;


use BookieGG\Http\Controllers\Controller;

class HomeController extends Controller {
    public function index() {
        return view('admin/home/index');
    }
}