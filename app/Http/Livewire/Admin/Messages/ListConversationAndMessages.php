<?php

namespace App\Http\Livewire\Admin\Messages;

use App\Models\Conversation;
use Livewire\Component;

class ListConversationAndMessages extends Component
{
    public $selectedConversation;

    public function mount()
    {
        $this->selectedConversation = Conversation::query()
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->first();
    }

    public function viewMessage($conversationId)
    {
        $this->selectedConversation = Conversation::findOrFail($conversationId);
    }

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
