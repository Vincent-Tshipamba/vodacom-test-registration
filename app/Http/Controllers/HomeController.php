<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $candidats = Candidat::latest()->get();
        return view('dashboard', compact('candidats'));
    }
}
