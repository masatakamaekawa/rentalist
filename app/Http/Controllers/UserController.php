<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $rentals = Rental::whereHas('entries', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();
        return view('auth.user.dashboard', compact('rentals'));
    }
}