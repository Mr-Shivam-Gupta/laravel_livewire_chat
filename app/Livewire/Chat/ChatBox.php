<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;
    public $paginate_var = 10;
    protected $listeners = ['loadMore' =>'loadMore'];

    public function loadMore() : void 
    {
         dd('hit the top');
    }
    public function loadMessages()
    {
        $count = Message::where('conversation_id',$this->selectedConversation->id)->count();
        $this->loadedMessages = Message::where('conversation_id',$this->selectedConversation->id)
        ->skip($count - $this->paginate_var)
        ->take($this->paginate_var)
        ->get();
        return $this->loadedMessages;
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
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();
        $this->dispatch('refresh');
        // $this->dispatch('livewire.chat.chat-list','refresh');
        // $this->dispatch('chat.chat-list','refresh');
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
