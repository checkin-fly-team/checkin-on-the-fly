<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;


class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth', // Aplica a todos os métodos
        ];
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Sort by Event date
        $query = Event::withMin('intervals', 'date')
            ->orderBy('intervals_min_date', 'asc');

        $myEvents = (clone $query)->where('organizer_id', $user->id)->get();
        $sharedEvents = (clone $query)
            ->whereHas('teamUsers', fn($q) => $q->where('user_id', $user->id))
            ->where('organizer_id', '!=', $user->id)
            ->get();

        return view('dashboard.events', compact('myEvents', 'sharedEvents'));
    }
}