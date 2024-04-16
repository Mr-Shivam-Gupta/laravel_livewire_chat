<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use App\Notifications\MessageSent;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;
    public $paginate_var = 10;
    protected $listeners = ['loadMore'];

    public function getListeners() {
        $auth_id = auth()->user()->id;
        return [
            'loadMore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" =>'broadcastedNotifications'
     ];
    }
    public function broadcastedNotifications($event)
    {
       if($event['type'] == MessageSent::class) {
        if($event['conversation_id']==$this->selectedConversation->id) {
            $this->dispatch('scroll-bottom');
            $newMessage = Message::find($event['message_id']);
            $this->loadedMessages->push($newMessage);
        }
       }
    }

    public function loadMore() : void 
    {
        $this->paginate_var += 10;
        $this->loadMessages();  
        $this->dispatch('update-chat-height');
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
        $this->validate(['body' => 'required|string']);
    
        // Assuming $this->selectedConversation->id represents the ID of the conversation
        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body
        ]);
    
        $this->reset('body');
        $this->dispatch('scroll-bottom');
        $this->loadedMessages->push($createdMessage);
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();
        $this->dispatch('refresh');
    
        // Notify the receiver about the sent message
        $this->selectedConversation->getReceiver()->notify(new MessageSent(auth()->user(), $createdMessage, $this->selectedConversation, $this->selectedConversation->getReceiver()->id));
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
