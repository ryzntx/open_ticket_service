<x-guest-layout>
    <div class="max-w-xl p-6 mx-auto mt-10 shadow bg-base-200 card card-body rounded-xl">

        <h1 class="mb-4 text-xl font-bold text-base-content">{{ __('Open Ticket Form') }}</h1>

        @if (session('success'))
            <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('ticket.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Nama Pengirim --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Sender Name') }}</legend>
                <input required type="text" class="w-full validator input" name="sender_name"
                    placeholder="{{ __('Type here') }}" value="{{ old('sender_name') }}"/>
                <p class="label">{{ __('Required') }}</p>
                @error('sender_name')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Sender Email') }}</legend>
                <input required type="email" class="w-full validator input" name="sender_email"
                    placeholder="{{ __('Type here') }}" value="{{old('sender_email')}}" />
                <p class="label">{{ __('Required') }}</p>
                @error('sender_email')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Pilih Kategori --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Category') }}</legend>
                <select id="category_id" name="category_id" class="w-full select validator">
                    <option value="">{{ __('Select category') }}</option>
                    @foreach ($categories as $cat)
                        <option @selected(request()->get('category') == $cat->slug) value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <p class="label">{{ __('Required') }}</p>
                @error('category_id')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Priority') }}</legend>
                <select id="priority" name="priority" class="w-full select validator">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>{{ __('Rendah') }}
                    </option>
                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                        {{ __('Sedang') }}
                    </option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>{{ __('Tinggi') }}
                    </option>
                </select>
                <p class="label">{{ __('Required') }}</p>
                @error('priority')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Ticket Title') }}</legend>
                <input required type="text" class="w-full validator input" name="title" id="title"
                    placeholder="{{ __('Example: Failed login to SIAKAD') }}" value="{{old('title') ?? request()->get('title')}}" />
                <p class="label">{{ __('Required') }}</p>
                @error('title')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Problem Description') }}</legend>
                <textarea required name="description" id="description" class="w-full h-24 textarea validator"
                    placeholder="{{ __("Example: Hello, I'am Rina Maharani - A1A250001, cannot log in to SIAKAD since yesterday. Error message: 'User not found'. Please help.") }}">{{old('description') ?? request()->get('desc')}}</textarea>
                <p class="label">{{ __('Required') }}</p>
                @error('description')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Attachment') }}</legend>
                <input type="file" class="filepond" name="attachment" accept="image/*" />
                <p class="label">{{ __('Optional') }}</p>
                @error('attachment')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Turnstile Captcha --}}
            {{-- This component will handle the Turnstile captcha --}}
            {{-- show turnstile captcha when env is production --}}
            @if (config('app.env') === 'production')
                <div class="flex flex-col items-center justify-center mt-4">
                    <x-turnstile />
                    @error('cf-turnstile-response')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Tombol Submit --}}
            <button type="submit" class="w-full mt-6 btn btn-primary">
                {{ __('Send Ticket') }}
            </button>
        </form>
    </div>
</x-guest-layout>
