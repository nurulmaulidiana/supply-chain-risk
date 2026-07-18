<?php

namespace App\Http\Controllers;

use App\Models\Port;

class UserPortController extends Controller
{
    public function index()
    {
        $ports = Port::all();

        return view('user.port', compact('ports'));
    }
}