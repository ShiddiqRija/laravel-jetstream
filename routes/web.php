<?php

use App\Http\Livewire\Mailbox\Compose;
use App\Http\Livewire\Mailbox\Draft;
use App\Http\Livewire\Mailbox\Inbox;
use App\Http\Livewire\Mailbox\SentMail;
use App\Http\Livewire\Mailbox\Show;
use App\Http\Livewire\Mailbox\Trash;
use App\Models\Email;
use Illuminate\Support\Facades\Auth;
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

    Route::get('/testing', function () {
        $cm = new ClientManager($options = []);

        $client = $cm->make([
            'host'          => Auth()->user()->imap_host,
            'port'          => 993,
            'encryption'    => 'tls',
            'validate_cert' => true,
            'username'      => Auth()->user()->email,
            'password'      => Auth()->user()->imap_password,
            'protocol'      => 'imap'
        ]);

        $client->connect();

        $folder = $client->getFolder('Sent');

        $messages = $folder->query()->all()->get()->reverse()->paginate(1);

        dd($messages);
    });
});
