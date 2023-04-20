<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;

class UpdateUserImap extends Component
{
    public $imap_host, $imap_password;

    public function render()
    {
        return view('livewire.profile.update-user-imap');
    }

    public function mount()
    {
        $this->imap_host = Auth()->user()->imap_host;
    }

    public function update(User $user)
    {
        $user->forceFill([
            'imap_host' => $this->imap_host,
            'imap_password' => $this->imap_password,
        ])->save();

        $this->emit('saved');
    }
}
