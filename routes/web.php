<?php

use App\Http\Livewire\Mailbox\Draft;
use App\Http\Livewire\Mailbox\Inbox;
use App\Http\Livewire\Mailbox\SendMail;
use App\Http\Livewire\Mailbox\Show;
use App\Http\Livewire\Mailbox\Trash;
use Illuminate\Support\Facades\Route;
use Webklex\IMAP\Facades\Client;
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

    Route::get('/mailbox/inbox', Inbox::class)->name('mailbox.inbox');
    Route::get('/mailbox/inbox/{id}', Show::class)->name('mailbox.inbox.show');
    Route::get('/mailbox/draft', Draft::class)->name('mailbox.draft');
    Route::get('/mailbox/send-mail', SendMail::class)->name('mailbox.send-mail');
    Route::get('/mailbox/trash', Trash::class)->name('mailbox.trash');

    Route::get('/testing', function () {
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolder('INBOX');

        $messages = $folder->query()->getMessage(6349);

        // dd($messages);
        echo $messages->getHTMLBody();
    });
});
