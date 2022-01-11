<div class="container" wire:poll>
    <div class="pt-2 row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contacts</h3>
                </div>
                <div class="card-body">
                    <ul class="contacts-list">
                        @foreach ($conversations as $conversation)
                        <li class="{{ $conversation->id === $selectedConversation->id ? 'bg-warning' : '' }}">
                            <a href="#" wire:click.prevent="viewMessage( {{ $conversation->id }})">
                                <img class="contacts-list-img" src="{{ $conversation->sender_id === auth()->id() ? $conversation->receiver->avatar_url : $conversation->sender->avatar_url }}" alt="User Avatar">
                                <div class="contacts-list-info">
                                    <span class="contacts-list-name text-dark">
                                        @if ($conversation->sender_id === auth()->id())
                                            {{ $conversation->receiver->name }}
                                        @else
                                            {{ $conversation->sender->name }}
                                        @endif
                                        <small class="float-right contacts-list-date text-muted">{{ $conversation->messages->last()?->created_at->format('d/m/Y') }}</small>
                                    </span>
                                    <span class="contacts-list-msg text-secondary">{{ $conversation->messages->last()?->body }}</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        @endforeach
                        <!-- End Contact Item -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header">
                    <h3 class="card-title">Chat with
                        <span>
                            @if ($conversation->sender_id === auth()->id())
                                {{ $selectedConversation->receiver->name }}
                            @else
                                {{ $selectedConversation->sender->name }}
                            @endif
                        </span>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" id="conversation">
                        <!-- Message. Default to the left -->
                        @foreach ($selectedConversation->messages as $message)
                        <div class="direct-chat-msg {{ $message->user_id === auth()->id() ? 'right' : '' }}">
                            <div class="clearfix direct-chat-infos">
                                <span class="float-left direct-chat-name">{{ $message->user->id === auth()->id() ? 'You' : $message->user->name }}</span>
                                <span class="float-right direct-chat-timestamp">{{ $message->created_at->format('d M h:i a') }}</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="{{ $message->user->avatar_url }}" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                {{ $message->body }}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        @endforeach
                        <!-- /.direct-chat-msg -->
                    </div>
                    <!--/.direct-chat-messages-->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <form wire:submit.prevent="sendMessage" action="#">
                        <div class="input-group">
                            <input wire:model.defer="body" type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
    </div>
</div>
