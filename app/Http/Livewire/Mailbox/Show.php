<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\IMAP\Facades\Client;

class Show extends Component
{
    private $subject = '';
    private $sender = '';
    private $htmlEmail = '';
    private $cssEmail = '';

    public function mount($folder, $id)
    {
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        if ($folder == 'inbox') $folder = 'INBOX';
        if ($folder == 'drafts') $folder = 'Drafts';
        if ($folder == 'sent-mail') $folder = 'Sent Mail';
        if ($folder == 'trash') $folder = 'Trash';

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolderByName($folder);

        $messages = $folder->query()->getMessage($id);

        // Pencocokan pola untuk tag HTML dan tag style/CSS
        preg_match_all('/<html.*?>(.*?)<\/html>|<style.*?>(.*?)<\/style>/s', $messages->getHTMLBody(), $matches);

        // Variabel untuk menampung tag HTML dan tag style/CSS
        $htmlContent = $matches[1] != null ? $matches[1][0] : $messages->getHTMLBody(true);
        $cssContent = $matches[2] != null ? $matches[1][0] : '';

        $this->subject = $messages->getSubject();
        $this->sender = $messages->getFrom();
        $this->htmlEmail = $htmlContent;
        $this->cssEmail = $cssContent;
    }

    public function render()
    {
        return view('livewire.mailbox.show', [
            'subject' => $this->subject,
            'sender' => $this->sender,
            'htmlEmail' => $this->htmlEmail,
            'cssEmail' => $this->cssEmail,
        ]);
    }
}
