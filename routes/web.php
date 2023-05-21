<?php

use App\Http\Livewire\Mailbox\Compose;
use App\Http\Livewire\Mailbox\Draft;
use App\Http\Livewire\Mailbox\Inbox;
use App\Http\Livewire\Mailbox\Reply;
use App\Http\Livewire\Mailbox\SentMail;
use App\Http\Livewire\Mailbox\Show;
use App\Http\Livewire\Mailbox\Trash;
use App\Models\Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Webklex\PHPIMAP\ClientManager;

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

    Route::get('/mailbox/compose', Compose::class)->name('mailbox.compose');
    Route::get('/mailbox/inbox', Inbox::class)->name('mailbox.inbox');
    Route::get('/mailbox/drafts', Draft::class)->name('mailbox.drafts');
    Route::get('/mailbox/send-mail', SentMail::class)->name('mailbox.send-mail');
    Route::get('/mailbox/trash', Trash::class)->name('mailbox.trash');
    Route::get('/mailbox/{folder}/{id}', Show::class)->name('mailbox.show');
    Route::get('/mailbox/{folder}/{id}/reply', Reply::class)->name('mailbox.reply');

    Route::get('/testing', function () {
        $data = [
            'driver' => 'smtp',
            'host' => 'smtp.office365.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => Auth()->user()->email,
            'password' => Auth()->user()->imap_password,
        ];

        Config::set('mail', $data);

        $body = array('body' => 'cek lagi');

        Mail::send(['html' => 'mail'], $body, function ($message) {
            $message->to('shiddiq100@gmail.com')->subject('Re: baru');
            $message->from(Auth()->user()->email, Auth()->user()->name);
        });
    });
});
