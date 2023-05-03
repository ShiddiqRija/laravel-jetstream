<?php

namespace App\Http\Livewire\Mailbox;

use App\Models\Email;
use Illuminate\Support\Facades\Config;
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
            $data = [
                'driver' => 'smtp',
                'host' => 'smtp.office365.com',
                'port' => 587,
                'encryption' => 'tls',
                'username' => Auth()->user()->email,
                'password' => Auth()->user()->imap_password,
            ];

            Config::set('mail', $data);

            $body = array('body' => $this->body);

            Mail::send(['html' => 'mail'], $body, function ($message) {
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
        try {
            Email::create([
                'id'            => $message->uid,
                'from_name'     => $message->getFrom()[0]->personal,
                'from_email'    => $message->getFrom()[0]->mail,
                'subject'       => $message->getSubject(),
                'body'          => $message->getHTMLBody(true),
                'type'          => 'sent-mail',
                'user_id'       => $user,
            ]);
            $url = route('mailbox.send-mail');
            return redirect()->to($url);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
