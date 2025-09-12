<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Quick Reply Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 shadow-sm card card-body bg-base-200 sm:p-8 sm:rounded-lg">
                <div class="flex flex-row items-center justify-between mb-4">
                    <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('Quick Reply List') }}</h3>
                    <button onclick="add_modal.showModal()" class="btn btn-primary">
                        {{ __('Add New Quick Reply') }}
                    </button>
                </div>
                {{-- Users Table --}}
                <div class="overflow-x-auto border rounded-box border-base-content/5 bg-base-100">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quick_replies as $replies)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $replies->title }}</td>
                                    <td class="max-w-xs break-words whitespace-normal">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($replies->message), 100, '...') }}
                                    </td>
                                    <td>
                                        <button onclick="edit_{{ $replies->id }}_modal.showModal()"
                                            class="btn btn-primary">{{ __('Edit') }}</button>
                                        <form action="{{ route('admin.quick-replies.destroy', $replies->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error"
                                                onclick="
                                            return confirm('{{ __('Are you sure you want to delete this category? This action cannot be undone.') }}');">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No quick replies found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $quick_replies->links() }}
                </div>
            </div>
        </div>
    </div>

    <dialog id="add_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ __('Create new quick reply') }}</h3>
            <form action="{{ route('admin.quick-replies.store') }}" method="post" id="add_quick_reply_form">
                @csrf
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Title') }}</legend>
                    <input required type="text" class="w-full validator input" name="title"
                        placeholder="{{ __('Type here') }}" value="{{ old('title') }}" />
                    <p class="label">{{ __('Required') }}</p>
                    @error('title')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Message') }}</legend>
                    <textarea required class="w-full validator input" id="message" name="message" placeholder="{{ __('Type here') }}"
                        row="3">{!! old('message') !!}</textarea>
                    <p class="label">{{ __('Required') }}</p>
                    @error('message')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
            </form>
            <div class="modal-action">
                <button form="add_quick_reply_form" class="btn btn-primary">{{ __('Create') }}</button>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">{{ __('Close') }}</button>
                </form>
            </div>
        </div>
    </dialog>

    @foreach ($quick_replies as $replies)
        <dialog id="edit_{{ $replies->id }}_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">{{ __('Edit quick reply') }}</h3>
                <form action="{{ route('admin.quick-replies.update', $replies->id) }}" method="post"
                    id="edit_quick_reply_form_{{ $replies->id }}">
                    @csrf
                    @method('PUT')
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Title') }}</legend>
                        <input required type="text" class="w-full validator input" name="title"
                            value="{{ $replies->title ?? old('title') }}" placeholder="{{ __('Type here') }}" />
                        <p class="label">{{ __('Required') }}</p>
                        @error('title')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Message') }}</legend>
                        <textarea required class="w-full validator input" id="message_edit" name="message" placeholder="{{ __('Type here') }}"
                            row="3">{!! $replies->message ?? old('message') !!}</textarea>
                        <p class="label">{{ __('Required') }}</p>
                        @error('message')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                </form>
                <div class="modal-action">
                    <button form="edit_quick_reply_form_{{ $replies->id }}"
                        class="btn btn-primary">{{ __('Update') }}</button>
                    <form method="dialog">
                        <!-- if there is a button in form, it will close the modal -->
                        <button class="btn">{{ __('Close') }}</button>
                    </form>
                </div>
            </div>
        </dialog>
    @endforeach
</x-app-layout>
