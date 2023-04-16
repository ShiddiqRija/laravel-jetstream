<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\IMAP\Facades\Client;

class Draft extends Component
{
    public $pesan = "";
    
    public function render()
    {
        return view('livewire.mailbox.index', [
            'messages' => $this->getMail()
        ]);
    }

    public function getMail()
    {
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolderByName('Drafts');

        $messages = $folder->query()->since('02.02.2023')->get()->reverse()->paginate();

        foreach ($messages as $m) {
            $m->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $m->getHTMLBody(true));
            $m->mailText = strip_tags($m->mailText);

            $m->date = $m->getDate();
            $m->date = strtotime($m->date);
            $m->date = date('j M', $m->date);
        }

        return $messages;
    }

    public function openEmail($emailID)
    {
        $this->pesan = "Email Id : ". $emailID; 
    }
}
