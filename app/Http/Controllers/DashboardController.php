<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'dashboard'
        ];
        return view('admin/dashboard', $data);
        // return view('layouts/admin');
    }
}
