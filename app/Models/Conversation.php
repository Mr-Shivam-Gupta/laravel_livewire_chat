<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id'
    ];
    public function messages(){
        $this->hasMany(Message::class);
    }
    public function getReceiver()
    {
        if($this->sender_id === auth()->id()) {
            return User::firstWhere('id',$this->receiver_id);
        } else {
            return User::firstWhere('id',$this->sender_id);
        }
    }
}
