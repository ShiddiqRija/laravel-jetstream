<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\IMAP\Facades\Client;

class Show extends Component
{
    private $subject = '';
    private $sender = '';
    private $mailBody = '';

    public function mount($id)
    {
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolder('INBOX');

        $messages = $folder->query()->getMessage($uid = $id);

        // foreach ($messages as $m) {
        //     $m->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $m->getHTMLBody(true));
        //     $m->mailText = strip_tags($m->mailText);

        //     $m->date = $m->getDate();
        //     $m->date = strtotime($m->date);
        //     $m->date = date('j M', $m->date);
        // }

        $this->subject = $messages->getSubject();
        $this->sender = $messages->getFrom();
        $this->mailBody = $messages->getHTMLBody();
    }

    public function render()
    {
        return view('livewire.mailbox.show', [
            'subject' => $this->subject,
            'sender' => $this->sender,
            'mailBody' => $this->mailBody,
        ]);
    }
}
