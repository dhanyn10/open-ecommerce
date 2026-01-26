<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DasborController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', [
            'pengguna' => $users
        ]);
    }
}
