<?php

namespace App\Http\Livewire\Mailbox;

use Livewire\Component;
use Webklex\IMAP\Facades\Client;

class Show extends Component
{
    private $subject = '';
    private $sender = '';
    private $mailBody = '';
    private $htmlEmail = '';
    private $cssEmail = '';

    public function mount($id)
    {
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folder = $client->getFolder('INBOX');

        $messages = $folder->query()->getMessage($uid = $id);

        // Pencocokan pola untuk tag HTML dan tag style/CSS
        preg_match_all('/<html.*?>(.*?)<\/html>|<style.*?>(.*?)<\/style>/s', $messages->getHTMLBody(), $matches);

        // Variabel untuk menampung tag HTML dan tag style/CSS
        $htmlContent = $matches[1][0];
        $cssContent = $matches[2][0];

        $this->subject = $messages->getSubject();
        $this->sender = $messages->getFrom();
        $this->mailBody = $messages->getHTMLBody();
        $this->htmlEmail = $htmlContent;
        $this->cssEmail = $cssContent;
    }

    public function render()
    {
        return view('livewire.mailbox.show', [
            'subject' => $this->subject,
            'sender' => $this->sender,
            'mailBody' => $this->mailBody,
            'htmlEmail' => $this->htmlEmail,
            'cssEmail' => $this->cssEmail,
        ]);
    }
}
