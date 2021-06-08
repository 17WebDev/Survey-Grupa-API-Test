<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class LandingController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('landing');
    }
}
