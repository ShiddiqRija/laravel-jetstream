<?php

namespace App\Http\Livewire\Mailbox;

use App\Models\Email;
use Carbon\Carbon;
use Livewire\Component;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

class Inbox extends Component
{

    protected $message;

    public function render()
    {
        return view('livewire.mailbox.index', [
            'messages' => $this->message,
            'folder' => 'inbox'
        ]);
    }

    public function boot()
    {
        $this->getEmail();
    }

    public function getEmail()
    {
        $userEmail = Email::where('user_id', Auth()->user()->id)->where('type', 'inbox')->orderByDesc('id')->paginate(10);

        foreach ($userEmail as $email) {
            $email->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $email->body);
            $email->mailText = strip_tags($email->mailText);

            $email->date = $email->created_at;
            $email->date = Carbon::createFromFormat('Y-m-d H:i:s', $email->date)->format('d M');
        }

        $this->message = $userEmail;
    }

    // public function getMail()
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

    //     //Get all Mailboxes
    //     /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
    //     $folder = $client->getFolderByName('Inbox');

    //     $messages = $folder->query()->all()->get()->reverse()->paginate();

    //     foreach ($messages as $m) {
    //         $m->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $m->getHTMLBody(true));
    //         $m->mailText = strip_tags($m->mailText);

    //         $m->date = $m->getDate();
    //         $m->date = strtotime($m->date);
    //         $m->date = date('j M', $m->date);
    //     }

    //     return $messages;
    // }

    public function openEmail($folder, $id)
    {
        $url = route('mailbox.show', compact('folder', 'id'));
        return redirect()->to($url);
    }
}
