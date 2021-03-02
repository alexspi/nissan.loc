<?php

namespace App\Http\Controllers;

class UserController extends Controller
{

    public function getHome()
    {

        return view('/home');

    }

    public function getProtected()
    {

        return view('/home');

    }

}