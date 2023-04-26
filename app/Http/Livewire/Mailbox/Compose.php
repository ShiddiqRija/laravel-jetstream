<?php

namespace App\Http\Livewire\Mailbox;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Message;

class Compose extends Component
{
    public $email, $subject, $body;

    public function render()
    {
        return view('livewire.mailbox.compose', [
            'email' => $this->email
        ]);
    }

    public function send()
    {
        try {
            $body = array('body' => $this->body);

            Mail::send(['text' => 'mail'], $body, function ($message) {
                $message->to($this->email)->subject($this->subject);
                $message->from(Auth()->user()->email, Auth()->user()->name);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

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

        $client->connect();
        $folder = $client->getFolder('Sent');
        $messages = $folder->query()->all()->get()->reverse()->paginate(1);
        $msgId = 0;

        foreach ($messages as $message) {
            $msgId = ($msgId < $message->uid) ? $message->uid : $msgId;

            $message = $folder->query()->getMessage($msgId);
            
            $this->store($message, Auth()->user()->id);
        }

        $client->disconnect();
    }

    public function store(Message $message, $user)
    {
        # code...
    }
}
