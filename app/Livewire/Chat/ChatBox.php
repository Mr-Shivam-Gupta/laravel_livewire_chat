<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;

    public function loadMessages()
    {
        $this->loadedMessages = Message::where('conversation_id',$this->selectedConversation->id)->get();
    }

    public function sendMessage ()
    {
        $this->validate(['body'=>'required|string']);
        $createdMessage = Message::create([
            'conversation_id'=>$this->selectedConversation->id,
            'sender_id'=>auth()->id(),
            'receiver_id'=>$this->selectedConversation->getReceiver()->id,
            'body'=>$this->body
        ]);
        $this->reset('body');
        $this->dispatch('scroll-bottom');
        $this->loadedMessages->push($createdMessage);
    }

    public function mount()
    {
        $this->loadMessages();
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
