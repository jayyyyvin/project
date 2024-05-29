<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('/dashboard');
    }

    public function home()
    {
        return view('home');
    }

    public function createUser()
    {
        return view('create-user');
    }
    public function showUser()
    {
        return view('show.showuser');
    }


}
