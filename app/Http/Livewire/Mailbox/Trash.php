<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

class Trash extends Component
{
    public function render()
    {
        return view('livewire.mailbox.index', [
            'messages' => $this->getMail(),
            'folder' =>  'trash'
        ]);
    }

    public function getMail()
    {
        $cm = new ClientManager($options = []);

        $client = $cm->make([
            'host'          => Auth()->user()->imap_host,
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => Auth()->user()->email,
            'password'      => Auth()->user()->imap_password,
            'protocol'      => 'imap'
        ]);

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolderByName('Deleted');

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
