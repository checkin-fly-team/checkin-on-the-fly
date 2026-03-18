<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
})->name('home.public');

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

/* Participant */
Route::get('/view/{event}/{eventName?}', null)->name('event.landing'); // event landing page
Route::post('/register/{event}', null)->name('event.register'); // register for event (name, email, phone)

/* Organizer */
Route::get('/events', null)->name('events.index'); // list of events
Route::post('/events', null)->name('events.store'); // create event (name, team members)
Route::put('/events/{event}', null)->name('events.update'); // update event (name, team members)
Route::delete('/events/{event}', null)->name('events.destroy'); // delete event

Route::get('/events/{event}/information', null)->name('events.information.index');
Route::get('/events/{event}/questionnaire', null)->name('events.questionnaire.index');
Route::get('/events/{event}/checkin-review', null)->name('events.checkin_review.index');
Route::get('/events/{event}/participants', null)->name('events.participants.index');
Route::get('/events/{event}/marketing', null)->name('events.marketing.index');
Route::get('/events/{event}/checkin-logs', null)->name('events.checkin_logs.index');
Route::get('/events/{event}/team', null)->name('events.team.index');

/* Admin */
Route::get('/users', null)->name('admin.users.index'); // list of users
Route::post('/users', null)->name('admin.users.store'); // create user (name, email, password
Route::put('/users/{user}', null)->name('admin.users.update'); // update user (name, email, password)
Route::delete('/users/{user}', null)->name('admin.users.destroy'); // delete user