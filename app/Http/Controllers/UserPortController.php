<?php

namespace App\Http\Controllers;

use App\Models\Port;

class UserPortController extends Controller
{
    public function index()
    {
        $ports = Port::orderBy('country')
                     ->orderBy('name')
                     ->get();

        return view('user.port', compact('ports'));
    }
}