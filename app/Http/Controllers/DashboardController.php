<?php

namespace App\Http\Controllers;

use App\Prodi;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'p' => Prodi::with('jenjang')->whereNotIn('id', [0])->orderBy('name')->get(),
        ]);
    }
}
