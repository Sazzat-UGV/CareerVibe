<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // This method will show home page
    public function index()
    {
        return view('frontend.home');
    }
}
