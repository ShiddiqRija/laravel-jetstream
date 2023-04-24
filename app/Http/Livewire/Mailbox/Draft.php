<?php

namespace App\Http\Livewire\Mailbox;

use App\Models\Email;
use Carbon\Carbon;
use Livewire\Component;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

class Draft extends Component
{
    public function render()
    {
        return view('livewire.mailbox.index', [
            'messages' => $this->getEmail(),
            'folder' =>  'drafts'
        ]);
    }

    public function getEmail()
    {
        $userEmail = Email::where('user_id', Auth()->user()->id)->where('type', 'drafts')->orderByDesc('id')->paginate(10);

        foreach ($userEmail as $email) {
            $email->mailText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '',  $email->body);
            $email->mailText = strip_tags($email->mailText);

            $email->date = $email->created_at;
            $email->date = Carbon::createFromFormat('Y-m-d H:i:s', $email->date)->format('d M');
        }

        return $userEmail;
    }

    public function openEmail($folder, $id)
    {
        $url = route('mailbox.show', compact('folder', 'id'));
        return redirect()->to($url);
    }
}
