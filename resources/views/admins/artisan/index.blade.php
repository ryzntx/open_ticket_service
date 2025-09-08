<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Artisan Command Runner') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:px-20">
        <div class="flex flex-col h-auto max-w-3xl p-6 rounded shadow bg-base-200">
            {{-- Title --}}
            <h1 class="mb-4 text-2xl font-bold">
                {{ __('Run Artisan Commands') }}
            </h1>

            <form method="POST" action="{{ route('artisan.run') }}" class="mb-4">
                @csrf
                <input type="text" name="command" id="command"
                    placeholder="{{ __('Artisan command (e.g., migrate, cache:clear)') }}"
                    class="w-full p-2 border rounded" required>
                @error('command')
                    <div class="mt-2 text-red-600">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <button type="submit" class="mt-4 btn btn-primary">{{ __('Run Command') }}</button>
            </form>

            @if ($errors->any())
                <div class="p-4 mb-4 text-red-600 bg-red-100 rounded">
                    <strong>{{ __('Error') }}:</strong> {{ $errors->first() }}
                </div>
            @endif

            {{-- Command session --}}
            @if (session('command'))
                <div class="mt-4">
                    <h2 class="font-semibold">{{ __('Command') }}:</h2>
                    <pre class="p-4 overflow-auto text-blue-400 bg-gray-800 rounded">{{ session('command') }}</pre>
                </div>
            @endif

            {{-- Status --}}
            @if (session('status'))
                <div class="mt-4">
                    <h2 class="font-semibold">{{ __('Status') }}:</h2>
                    <pre class="p-4 overflow-auto text-yellow-400 bg-gray-800 rounded">{{ session('status') }}</pre>
                </div>
            @endif

            @if (session('output'))
                <div class="mt-4">
                    <h2 class="font-semibold">{{ _('Output') }}:</h2>
                    @php
                        // Remove ANSI color codes for clean output
                        $output = preg_replace('/\e\[[\d;]*m/', '', session('output'));
                    @endphp
                    <pre class="p-4 overflow-auto text-green-400 bg-black rounded">{{ $output }}</pre>
                </div>
            @endif
        </div>
        <div class="max-w-3xl p-6 rounded shadow bg-base-200">
            <h1 class="mb-4 text-2xl font-bold">{{ __('Artisan Command List') }}</h1>

            <ul class="space-y-2">
                @foreach ($commands as $command => $description)
                    <div class="border collapse bg-base-100 border-base-300">
                        <input type="checkbox" />
                        <div class="font-semibold collapse-title">{{ $command }}</div>
                        <div class="text-sm collapse-content">
                            {{-- List of descriptions --}}
                            @foreach ($description as $desc => $val)
                                <div class="mt-2 border collapse bg-base-100 border-base-300">
                                    <input type="checkbox" />
                                    <div class="flex justify-between font-semibold collapse-title">{{ $val['name'] }}
                                    </div>
                                    <div class="text-sm collapse-content">
                                        <p class="mb-2">{{ $val['description'] }}</p>
                                        <p class="mb-2">{{ $val['synopsis'] }}</p>
                                        {{-- Arguments --}}
                                        @if (isset($val['arguments']) && count($val['arguments']) > 0)
                                            <h3 class="font-semibold">{{ __('Arguments') }}:</h3>
                                            <ul class="pl-5 list-disc">
                                                @foreach ($val['arguments'] as $arg)
                                                    <li>
                                                        <span class="font-semibold">{{ $arg['title'] }}</span>
                                                        <span class="ml-2 text-gray-600">({{ $arg['name'] }})</span>
                                                        @if ($arg['required'])
                                                            <span
                                                                class="ml-2 text-red-500">[{{ __('required') }}]</span>
                                                        @endif
                                                        @if ($arg['array'])
                                                            <span
                                                                class="ml-2 text-blue-500">[{{ __('array') }}]</span>
                                                        @endif
                                                        @if (!empty($arg['description']))
                                                            <div class="text-xs text-gray-500">
                                                                {{ $arg['description'] }}</div>
                                                        @endif
                                                        @if (!is_null($arg['default']))
                                                            <div class="text-xs text-gray-400">{{ __('Default') }}:
                                                                <code>{{ is_array($arg['default']) ? json_encode($arg['default']) : $arg['default'] }}</code>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        {{-- Options --}}
                                        @if (isset($val['options']) && count($val['options']) > 0)
                                            <h3 class="font-semibold">{{ __('Options') }}:</h3>
                                            <ul class="pl-5 list-disc">
                                                @foreach ($val['options'] as $opt)
                                                    <li>
                                                        <span class="font-semibold">{{ $opt['title'] }}</span>
                                                        <span class="ml-2 text-gray-600">({{ $opt['name'] }})</span>
                                                        @if ($opt['shortcut'])
                                                            <span
                                                                class="ml-2 text-blue-500">-{{ $opt['shortcut'] }}</span>
                                                        @endif
                                                        @if ($opt['required'])
                                                            <span
                                                                class="ml-2 text-red-500">[{{ __('required') }}]</span>
                                                        @endif
                                                        @if ($opt['array'])
                                                            <span
                                                                class="ml-2 text-blue-500">[{{ __('array') }}]</span>
                                                        @endif
                                                        @if ($opt['accept_value'])
                                                            <span
                                                                class="ml-2 text-green-500">[{{ __('accepts value') }}]</span>
                                                        @endif
                                                        @if (!empty($opt['description']))
                                                            <div class="text-xs text-gray-500">
                                                                {{ $opt['description'] }}
                                                            </div>
                                                        @endif
                                                        @if (!is_null($opt['default']))
                                                            <div class="text-xs text-gray-400">
                                                                Default:
                                                                <code>{{ is_array($opt['default']) ? json_encode($opt['default']) : $opt['default'] }}</code>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        {{-- Run button --}}
                                        <form action="{{ route('artisan.run') }}" id="formRun" method="POST"
                                            class="mt-4">
                                            @csrf
                                            <input type="hidden" name="command" value="{{ $val['name'] }}">
                                            <button type="submit"
                                                class="w-full btn btn-sm btn-primary">{{ __('Run') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
