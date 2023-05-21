<?php

namespace App\Http\Livewire\Mailbox;

use App\Models\Email;
use Livewire\Component;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

class Show extends Component
{
    private $mailId = 0;
    private $folder = '';
    private $subject = '';
    private $sender = '';
    private $htmlEmail = '';
    private $cssEmail = '';

    public function mount($folder, $id)
    {
        $userEmail = Email::where('id', $id)->where('user_id', Auth()->user()->id)->where('type', $folder)->first();

        // Pencocokan pola untuk tag HTML dan tag style/CSS
        preg_match_all('/<html.*?>(.*?)<\/html>|<style.*?>(.*?)<\/style>/s', $userEmail->body, $matches); 

        // Variabel untuk menampung tag HTML dan tag style/CSS
        $htmlContent = $matches[1] != null ? $matches[1][0] : $userEmail->body;
        $cssContent = $matches[2] != null ? $matches[1][0] : '';

        $this->mailId = $userEmail->id;
        $this->folder = $folder;
        $this->subject = $userEmail->subject;
        $this->sender = $userEmail->from_name . '< ' . $userEmail->from_email . ' >';
        $this->htmlEmail = $htmlContent;
        $this->cssEmail = $cssContent;
    }

    // public function mount($folder, $id)
    // {
    //     $cm = new ClientManager($options = []);

    //     $client = $cm->make([
    //         'host'          => Auth()->user()->imap_host,
    //         'port'          => 993,
    //         'encryption'    => 'tls',
    //         'validate_cert' => true,
    //         'username'      => Auth()->user()->email,
    //         'password'      => Auth()->user()->imap_password,
    //         'protocol'      => 'imap'
    //     ]);

    //     //Connect to the IMAP Server
    //     $client->connect();

    //     if ($folder == 'inbox') $folder = 'Inbox';
    //     if ($folder == 'drafts') $folder = 'Drafts';
    //     if ($folder == 'sent-mail') $folder = 'Sent';
    //     if ($folder == 'trash') $folder = 'Deleted';

    //     //Get all Mailboxes
    //     /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
    //     $folder = $client->getFolderByName($folder);

    //     $messages = $folder->query()->getMessage($id);

    //     // Pencocokan pola untuk tag HTML dan tag style/CSS
    /*     preg_match_all('/<html.*?>(.*?)<\/html>|<style.*?>(.*?)<\/style>/s', $messages->getHTMLBody(), $matches); */

    //     // Variabel untuk menampung tag HTML dan tag style/CSS
    //     $htmlContent = $matches[1] != null ? $matches[1][0] : $messages->getHTMLBody(true);
    //     $cssContent = $matches[2] != null ? $matches[1][0] : '';

    //     $this->subject = $messages->getSubject();
    //     $this->sender = $messages->getFrom();
    //     $this->htmlEmail = $htmlContent;
    //     $this->cssEmail = $cssContent;
    // }

    public function render()
    {
        return view('livewire.mailbox.show', [
            'id' => $this->mailId,
            'folder' => $this->folder,
            'subject' => $this->subject,
            'sender' => $this->sender,
            'htmlEmail' => $this->htmlEmail,
            'cssEmail' => $this->cssEmail,
        ]);
    }
}
