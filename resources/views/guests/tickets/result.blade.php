<x-guest-layout>
    <div class="max-w-3xl p-6 mx-auto mt-10 rounded shadow bg-base-200 card card-body">
        <h1 class="mb-4 text-xl font-bold">{{ __('Ticket Detail') }}: {{ $ticket->code }}</h1>

        <div class="space-y-3 text-sm text-base-content">
            <p><strong>{{ __('Title') }}:</strong> {{ $ticket->title }}</p>
            <p><strong>{{ __('Status') }}:</strong> {{ ucfirst($ticket->status) }}</p>
            <p><strong>{{ __('Category') }}:</strong> {{ $ticket->category->name }}</p>
            <p><strong>{{ __('Priority') }}:</strong> {{ ucfirst($ticket->priority) }}</p>
            <p><strong>{{ __('Sender') }}:</strong> {{ $ticket->sender_name }} ({{ $ticket->sender_email }})</p>
            <p><strong>{{ __('Description') }}:</strong><br>{!! $ticket->description !!}</p>

            @if ($ticket->attachments->count())
                <p><strong>{{ __('Attachments') }}:</strong><br>
                    @foreach ($ticket->attachments as $attach)
                        <a href="{{ asset('storage/' . $attach->file_path) }}" class="text-blue-600 underline"
                            target="_blank">{{ __('Download Attachment') }}</a>
                    @endforeach
                </p>
            @endif

            @if ($ticket->replies->count())
                <hr class="my-4">
                <h2 class="mb-2 text-lg font-semibold">{{ __('Reply from Agent') }}</h2>
                @foreach ($ticket->replies as $reply)
                    <div class="p-3 mb-2 bg-gray-100 rounded">
                        <p class="text-sm text-gray-600"><strong>{{ $reply->user->name }}</strong> -
                            {{ $reply->created_at->format('d M Y H:i') }}</p>
                        <p class="mt-1">{!! $reply->message !!}</p>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('ticket.status.form') }}" class="btn btn-neutral">←
                {{ __('Check other ticket.') }}</a>
        </div>
    </div>
</x-guest-layout>
