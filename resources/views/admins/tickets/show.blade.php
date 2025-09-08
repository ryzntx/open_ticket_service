<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Tickets Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 shadow-sm card card-body bg-base-200 sm:p-8 sm:rounded-lg">
                <div class="flex flex-row items-center justify-between mb-4">
                    <div class="flex flex-col">
                        <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('Ticket Detail') }}</h3>
                        <h5 class="mb-4 font-medium text-md text-base-content">{{ $ticket->code }}</h5>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-neutral">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="block">
                        <div class="grid grid-cols-2 gap-4">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">{{ __('Sender Name') }}</legend>
                                <input readonly type="text" class="w-full validator input" name="sender_name"
                                    placeholder="{{ __('Type here') }}" value="{{ $ticket->sender_name }}" />
                            </fieldset>

                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">{{ __('Sender Email') }}</legend>
                                <input readonly type="email" class="w-full validator input" name="sender_email"
                                    placeholder="{{ __('Type here') }}" value="{{ $ticket->sender_email }}" />
                            </fieldset>
                        </div>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Category') }}</legend>
                            <input readonly type="text" class="w-full validator input" name="category"
                                placeholder="{{ __('Type here') }}" value="{{ $ticket->category->name }}" />
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Status') }}</legend>
                            <input readonly type="text" class="w-full validator input" name="status"
                                placeholder="{{ __('Type here') }}" value="{{ ucfirst($ticket->status) }}" />
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Priority') }}</legend>
                            <input readonly type="text" class="w-full validator input" name="priority"
                                placeholder="{{ __('Type here') }}" value="{{ ucfirst($ticket->priority) }}" />
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Ticket Title') }}</legend>
                            <input readonly type="text" class="w-full validator input" name="title"
                                placeholder="{{ __('Example: Failed login to SIAKAD') }}"
                                value="{{ $ticket->title }}" />
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Problem Description') }}</legend>
                            <textarea readonly name="description" id="description" class="w-full h-24 textarea"
                                placeholder="{{ __("Example: Hello, I'am Rina Maharani - A1A250001, cannot log in to SIAKAD since yesterday. Error message: 'User not found'. Please help.") }}">{!! $ticket->description !!}</textarea>
                        </fieldset>
                    </div>
                    <div class="flex flex-col gap-6">
                        <h3 class="text-lg font-semibold">{{ __('Attachments') }}</h3>
                        {{-- Daftar Lampiran --}}
                        @if (count($ticket->attachments) > 0)
                            <div class="grid grid-cols-2 gap-5 mb-6 md:grid-cols-4 lg:grid-cols-6"
                                x-data="{
                                    images: [
                                        @foreach ($ticket->attachments as $attachment)
                                    {
                                        url: '{{ asset('storage/' . $attachment->file_path) }}',
                                        thumb: '{{ asset('storage/' . $attachment->file_path) }}'
                                    }@if (!$loop->last),@endif @endforeach
                                    ],
                                }">
                                <template x-for="image in images">
                                    <a href="#"
                                        class="flex overflow-hidden transition-opacity rounded-md aspect-square hover:opacity-80"
                                        x-lightbox="image.url" x-lightbox:group="multiple">
                                        <img class="flex-1 object-cover object-center" :src="image.thumb"
                                            alt="">
                                    </a>
                                </template>
                            </div>
                        @else
                            <p class="w-auto h-auto text-sm text-base-400">{{ __('No attachments found.') }}</p>
                        @endif
                        <h3 class="text-lg font-semibold">{{ __('Replies') }}</h3>
                        {{-- Daftar Tanggapan --}}
                        <div class="flex flex-col gap-4 overflow-y-auto min-h-96 max-h-96">
                            @if ($ticket->replies->count() > 0)
                                @foreach ($ticket->replies->sortDesc() as $feedback)
                                    <div class="chat chat-end">
                                        <div class="chat-header">
                                            {{ $feedback->user->name }}
                                            <time
                                                class="text-xs opacity-50">{{ $feedback->created_at->diffForHumans() }}</time>
                                        </div>
                                        <div class="chat-bubble">{!! $feedback->message !!}</div>
                                        {{-- <div class="opacity-50 chat-footer"></div> --}}
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500">{{ __('No replies yet.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($ticket->status != 'closed')
                    <button class="btn btn-info" onclick="feedback_modal.showModal()">{{ __('Give a Reply') }}</button>
                @endif
                @if ($ticket->status == 'open')
                    <button class="btn btn-warning"
                        onclick="change_status_modal.showModal()">{{ __('Change Status') }}</button>
                @elseif ($ticket->status == 'in_progress')
                    <button class="btn btn-error"
                        onclick="change_status_modal.showModal()">{{ __('Close Ticket') }}</button>
                @endif
            </div>
        </div>
    </div>

    <dialog id="feedback_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ __('Give a Reply') }}</h3>
            <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="post" id="reply_form">
                @csrf
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Message') }}</legend>
                    <textarea required name="message" id="message" class="w-full h-24 textarea validator"
                        placeholder="{{ __('Example: Hello, thank you for contacting us...') }}"></textarea>
                </fieldset>
            </form>
            <div class="modal-action">
                <button form="reply_form" class="btn btn-primary">{{ __('Send Reply') }}</button>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">{{ __('Close') }}</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="change_status_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ __('Are you sure to change status from this ticket?') }}</h3>
            <p class="py-4">{{ __('This action cannot reverse.') }}</p>
            <div class="modal-action">
                <form action="{{ route('admin.tickets.changeStatus', $ticket->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">{{ __('Yes, Change status') }}</button>
                </form>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">{{ __('Close') }}</button>
                </form>
            </div>
        </div>
    </dialog>
</x-app-layout>
