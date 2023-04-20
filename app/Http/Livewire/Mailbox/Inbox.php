<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

class Inbox extends Component
{
    public function render()
    {
        return view('livewire.mailbox.index', [
            'messages' => $this->getMail(),
            'folder' => 'inbox'
        ]);
    }

    public function getMail()
    {
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

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolderByName('Inbox');

        $messages = $folder->query()->all()->get()->reverse()->paginate();

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
