<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth', // Aplica a todos os métodos
            // ou com opções: new Middleware('auth', only: ['index']),
        ];
    }

    public function index()
    {
        return view('dashboard.events');
    }


//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

//     public function index()
//     {
//         return view('home');
//     }
}
