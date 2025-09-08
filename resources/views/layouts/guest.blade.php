<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistem Tiket') }}</title>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan Font Opsional --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @turnstileScripts()
</head>

<body class="min-h-screen font-sans antialiased bg-base-100">

    {{-- Header --}}
    {{--    <header class="p-4 shadow bg-base-100"> --}}
    {{--        <div class="max-w-6xl mx-auto"> --}}
    {{--            <h1 class="text-xl font-semibold">Sistem Tiket Bantuan</h1> --}}
    {{--        </div> --}}
    {{--    </header> --}}

    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="shadow bg-base-200">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- Konten --}}
    <main class="max-w-4xl px-4 py-6 mx-auto">
        @yield('content')
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="my-10 text-sm text-center text-gray-500">
        &copy; {{ date('Y') }} {{ __('Open Support Ticket Service') }}. {{ __('All rights reserved.') }}
        <br>
        <p>
            {{ __('Created with ❤️ by ') }}
            {{-- Puskom --}}
            {{-- Puskom Instagram --}}
            <a href="https://www.instagram.com/puskom.unsub" target="_blank" class="text-blue-500 hover:underline">
                {{ __('Puskom Team') }}
            </a>
            &
            {{-- thanbl_ instagram --}}
            <a href="https://www.instagram.com/thanbl_" target="_blank" class="text-blue-500 hover:underline">
                {{ __('thanbl_') }}
            </a>
        </p>

    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch placeholder for title and description based on category selection on page load
            const categorySelect = document.getElementById('category_id');
            if (categorySelect) {
                const selectedCategoryId = categorySelect.value;
                if (selectedCategoryId) {
                    // fetch category placeholder
                    fetch(`/api/categories/${selectedCategoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update the title field with the category placeholder
                            const titleField = document.getElementById('title');
                            titleField.placeholder = data.data.title_placeholder || '';
                            // Update the description field with the category placeholder
                            const descriptionField = document.getElementById('description');
                            descriptionField.placeholder = data.data.desc_placeholder || '';
                        })
                        .catch(error => {
                            console.error('Error fetching category placeholder:', error);
                            // Reset the title and description fields if there's an error
                            const titleField = document.getElementById('title');
                            titleField.placeholder = '';
                            const descriptionField = document.getElementById('description');
                            descriptionField.placeholder = '';
                        });
                } else {
                    // Reset the title field if no category is selected
                    const titleField = document.getElementById('title');
                    titleField.placeholder = '';
                    // Reset the description field if no category is selected
                    const descriptionField = document.getElementById('description');
                    descriptionField.placeholder = '';
                }
            }

            // Listener for category selection change
            categorySelect.addEventListener('change', function () {
                const selectedCategoryId = this.value;
                if (selectedCategoryId) {
                    // fetch category placeholder
                    fetch(`/api/categories/${selectedCategoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update the title field with the category placeholder
                            const titleField = document.getElementById('title');
                            titleField.placeholder = data.data.title_placeholder || '';
                            // Update the description field with the category placeholder
                            const descriptionField = document.getElementById('description');
                            descriptionField.placeholder = data.data.desc_placeholder || '';
                        })
                        .catch(error => {
                            console.error('Error fetching category placeholder:', error);
                            // Reset the title and description fields if there's an error
                            const titleField = document.getElementById('title');
                            titleField.placeholder = '';
                            const descriptionField = document.getElementById('description');
                            descriptionField.placeholder = '';
                        });
                } else {
                    // Reset the title field if no category is selected
                    const titleField = document.getElementById('title');
                    titleField.placeholder = '';
                    // Reset the description field if no category is selected
                    const descriptionField = document.getElementById('description');
                    descriptionField.placeholder = '';
                }
            });
        });
    </script>

    <script type="module">
        // Initialize FilePond on the file input element
        const inputElement = document.querySelector('.filepond');
        FilePond.create(inputElement);
        FilePond.setOptions({
            server: {
                url: '/filepond/api',
                process: {
                    url: "/process",
                    headers: (file) => {
                        // Send the original file name which will be used for chunked uploads
                        return {
                            "Upload-Name": file.name,
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        }
                    },
                },
                revert: '/process',
                patch: "?patch=",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            acceptedFileTypes: ['image/*'],
            allowMultiple: true,
            maxFiles: 2,
            inputName: '{{ config('filepond.input_name', 'attachment') }}',
            // label
            labelIdle: '{{ __('Drag & Drop your files or') }} <span class="filepond--label-action">{{ __('Browse') }}</span>',
            labelInvalidField: '{{ __('Invalid file') }}',
            labelFileWaitingForSize: '{{ __('Waiting for size') }}',
            labelFileSizeNotAvailable: '{{ __('Size not available') }}',
            labelFileLoading: '{{ __('Loading') }}',
            labelFileLoadError: '{{ __('Error loading file') }}',
            labelFileProcessing: '{{ __('Processing') }}',
            labelFileProcessingComplete: '{{ __('Processing complete') }}',
            labelFileProcessingAborted: '{{ __('Processing aborted') }}',
            labelFileProcessingError: '{{ __('Error during processing') }}',
            labelFileRemoveError: '{{ __('Error removing file') }}',
            labelTapToCancel: '{{ __('Tap to cancel') }}',
            labelTapToRetry: '{{ __('Tap to retry') }}',
            labelTapToUndo: '{{ __('Tap to undo') }}',
            labelButtonRemoveItem: '{{ __('Remove') }}',
            labelButtonAbortItemLoad: '{{ __('Abort') }}',
            labelButtonRetryItemLoad: '{{ __('Retry') }}',
            labelButtonAbortItemProcessing: '{{ __('Cancel') }}',
            labelButtonUndoItemProcessing: '{{ __('Undo') }}',
            labelButtonRetryItemProcessing: '{{ __('Retry') }}',
            labelButtonProcessItem: '{{ __('Upload') }}',
        });
    </script>

</body>

</html>
