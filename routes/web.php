<?php

use App\Http\Livewire\Mailbox\Draft;
use App\Http\Livewire\Mailbox\Inbox;
use App\Http\Livewire\Mailbox\SendMail;
use App\Http\Livewire\Mailbox\Trash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/mailbox/inbox', Inbox::class)->name('mailbox.inbox');
    Route::get('/mailbox/draft', Draft::class)->name('mailbox.draft');
    Route::get('/mailbox/send-mail', SendMail::class)->name('mailbox.send-mail');
    Route::get('/mailbox/trash', Trash::class)->name('mailbox.trash');
});
