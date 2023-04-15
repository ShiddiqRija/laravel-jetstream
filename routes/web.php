<?php

use App\Http\Livewire\Mailbox\Draft;
use App\Http\Livewire\Mailbox\Inbox;
use App\Http\Livewire\Mailbox\SendMail;
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
    Route::get('/mailbox/draft', Draft::class)->name('mailbox.draft');
    Route::get('/mailbox/send-mail', SendMail::class)->name('mailbox.send-mail');
    Route::get('/mailbox/trash', Trash::class)->name('mailbox.trash');

    Route::get('/testing', function () {
        $cm = new ClientManager($options = []);

        /** @var \Webklex\PHPIMAP\Client $client */
        $client = $cm->account('default');

        // or create a new instance manually
        $client = $cm->make([
            'host'          => 'imap.gmail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => 'gabungyou@gmail.com',
            'password'      => 'cgprppwexhhspsbu',
            'protocol'      => 'imap'
        ]);

        //Connect to the IMAP Server
        $client->connect();

        // //Get all Mailboxes
        // /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folders = $client->getFolders();

        echo $folders;
        // $oFolder = $client->getFolder('INBOX');

        // $aMessage = $oFolder->query()->since('15.04.2023')->get();

        // foreach ($aMessage as $oMessage) {
        //     echo $oMessage->getFrom() . '<br />';
        //     echo $oMessage->getFrom()[0]->mail . '<br />';
        //     echo $oMessage->getSubject() . '<br />';
        //     echo strip_tags($oMessage->getHTMLBody(true)).'<br />';
        //     echo '<br />';
        //     $text = strip_tags($oMessage->getHTMLBody(true));
        //     $text = preg_replace('/\..+?\{.+?\}|@media.+?\{.+?\}/s', '', $text);
        //     echo $text . '<br />';
        //     echo '<br />';
        //     echo $oMessage->getHTMLBody(true);
        // }

        // //Loop through every Mailbox
        // /** @var \Webklex\PHPIMAP\Folder $folder */
        // foreach ($folders as $folder) {

        //     //Get all Messages of the current Mailbox $folder
        //     /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        //     // $messages = $folder->messages()->all()->get();
        //     $messages = $folder->query()->limit(5, 1)->get();

        //     /** @var \Webklex\PHPIMAP\Message $message */
        //     foreach ($messages as $message) {
        //         echo $message->getSubject() . '<br />';
        //         echo 'Attachments: ' . $message->getAttachments()->count() . '<br />';
        //         echo $message->getHTMLBody();

        //         //Move the current Message to 'INBOX.read'
        //         if ($message->move('INBOX.read') == true) {
        //             echo 'Message has ben moved';
        //         } else {
        //             echo 'Message could not be moved';
        //         }
        //     }
        // }
    });
});
