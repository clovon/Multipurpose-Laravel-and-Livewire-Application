<div class="container">
    <div class="pt-2 row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contacts</h3>
                </div>
                <div class="card-body">
                    <ul class="contacts-list">
                        @foreach ($conversations as $conversation)
                        <li class="">
                            <a href="#">
                                <img class="contacts-list-img" src="{{ $conversation->receiver->avatar_url }}" alt="User Avatar">
                                <div class="contacts-list-info">
                                    <span class="contacts-list-name text-dark">
                                        {{ $conversation->receiver->name }}
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
                            Rossie Hoeger
                        </span>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" id="conversation">
                        <!-- Message. Default to the left -->
                        <div class="direct-chat-msg right">
                            <div class="clearfix direct-chat-infos">
                                <span class="float-left direct-chat-name">You</span>
                                <span class="float-right direct-chat-timestamp">16 Nov 11:52 pm</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="http://localhost:8000/storage/avatars/24HCF7MiZIgETjLJ1PUddPPseAWDSJEW9jVRRiy1.png" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                Hi
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                    </div>
                    <!--/.direct-chat-messages-->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <form action="#">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
    </div>
</div>
