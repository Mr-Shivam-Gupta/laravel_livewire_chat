<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class Index extends Component
{
    public $selectedConversation;
    public function render()
    {
        return view('livewire.chat.index')->layout('layouts.app');
    }
}
