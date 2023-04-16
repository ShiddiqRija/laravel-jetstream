<?php

namespace App\Http\Livewire\Mailbox;

use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Webklex\IMAP\Facades\Client;

class SentMail extends Component
{
    public function mount() {

    }

    public function render()
    {
        return view('livewire.mailbox.index', [
            'messages' => $this->getMail(),
            'folder' =>  'sent-mail'
        ]);
    }

    public function getMail()
    {
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolderByName('Sent Mail');

        $messages = $folder->query()->since('03.03.2023')->get()->reverse()->paginate();

        foreach ($messages as $m) {
            $m->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $m->getHTMLBody(true));
            $m->mailText = strip_tags($m->mailText);

            $m->date = $m->getDate();
            $m->date = strtotime($m->date);
            $m->date = date('j M', $m->date);
        }

        return $messages;
    }

    public function openEmail($folder, $id)
    {
        $url = route('mailbox.show', compact('folder', 'id'));
        return redirect()->to($url);
    }
}
