<x-guest-layout>
    <div class="max-w-lg p-6 mx-auto mt-10 rounded shadow bg-base-200 card card-body">

        <h1 class="mb-4 text-xl font-bold">{{ __('Check Ticket Status') }}</h1>

        <form method="POST" action="{{ route('ticket.status.check') }}">
            @csrf

            <fieldset class="fieldset">
                <legend class="fieldset-legend">{{ __('Please Fill Your Ticket Code') }}</legend>
                <input required type="text" class="w-full validator input" name="code"
                    placeholder="{{ __('Example: TKT-ABC123') }}" />
                <p class="label">{{ __('Required') }}</p>
                @error('code')
                    <p class="text-sm text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <button type="submit" class="w-full mt-6 btn btn-primary">
                {{ __('Check Status') }}
            </button>
        </form>

    </div>
</x-guest-layout>
