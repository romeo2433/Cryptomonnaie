<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        return view('admin.stats'); // la vue qu’on crée après
    }
}
