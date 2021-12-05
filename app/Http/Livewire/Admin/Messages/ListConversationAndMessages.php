<?php

namespace App\Http\Livewire\Admin\Messages;

use App\Models\Conversation;
use Livewire\Component;

class ListConversationAndMessages extends Component
{
    public function render()
    {
        $conversations = Conversation::query()
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        return view('livewire.admin.messages.list-conversation-and-messages', [
            'conversations' => $conversations
        ]);
    }
}
