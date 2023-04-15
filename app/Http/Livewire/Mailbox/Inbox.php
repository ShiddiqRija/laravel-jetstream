<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\PHPIMAP\ClientManager;

class Inbox extends Component
{

    public function getMail()
    {
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

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolder('INBOX');

        $messages = $folder->query()->since('15.04.2023')->get();

        foreach ($messages as $m) {
            $m->mailText = strip_tags($m->getHTMLBody(true));
            $m->mailText = preg_replace('/\..+?\{.+?\}|@media.+?\{.+?\}/s', '', $m->mailText);
        }

        return $messages;
    }

    public function render()
    {
        return view('livewire.mailbox.inbox', [
            'messages' => $this->getMail()
        ]);
    }
}
