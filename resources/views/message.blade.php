<link rel="stylesheet" href="{{ asset('css/message.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div class="message-box">
    <div class="message-header">
        <h3>{{ $user->email }}  </h3>
    </div>
    <div class="message-body">
        <div class="typing-message-box">
            <form action="/message/{{ $user->id }}" method="post">
                @csrf 
                <textarea name="message" class="message-input" placeholder="Type your message..."></textarea>
                <button class="send-button" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
