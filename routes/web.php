<?php

use App\Http\Livewire\Mailbox\Draft;
use App\Http\Livewire\Mailbox\Inbox;
use App\Http\Livewire\Mailbox\SentMail;
use App\Http\Livewire\Mailbox\Show;
use App\Http\Livewire\Mailbox\Trash;
use App\Models\Email;
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
    Route::get('/mailbox/drafts', Draft::class)->name('mailbox.drafts');
    Route::get('/mailbox/send-mail', SentMail::class)->name('mailbox.send-mail');
    Route::get('/mailbox/trash', Trash::class)->name('mailbox.trash');
    Route::get('/mailbox/{folder}/{id}', Show::class)->name('mailbox.show');

    Route::get('/testing', function () {    
        $userEmail = Email::where('user_id', Auth()->user()->id)->where('type', 'inbox')->get()->count();

        // foreach ($userEmail as $email) {
        //     $email->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $email->body);
        //     $email->mailText = strip_tags($email->mailText);

        //     $email->date = $email->created_at;
        //     $email->date = Carbon::createFromFormat('Y-m-d H:i:s', $email->date)->format('d M');
        // }

        
        dd($userEmail);
    });
});
