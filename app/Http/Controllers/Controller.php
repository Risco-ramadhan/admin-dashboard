<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {

        $user = Auth::user();

        // Dapatkan jam saat ini
        $hour = now()->format('H');
        $greeting = '';

        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 16) {
            $greeting = 'Good afternoon';
        } elseif ($hour < 19) {
            $greeting = 'Good evening';
        } else {
            $greeting = 'Good night';
        }

        return Inertia::render('Home', [
            'user' => [
                'name' => strtoupper($user->name),
                'email' => $user->email,
            ],
            'greeting' => $greeting,
        ]);
    }
}
