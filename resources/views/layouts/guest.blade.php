<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Tiket') }}</title>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan Font Opsional --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @turnstileScripts()

    <script src="https://cdn.tiny.cloud/1/mxcxsw1v49fhk1dmja3wumdzsf58cljq98k7g5u27avw8bee/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
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
        document.addEventListener('DOMContentLoaded', function() {
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
            categorySelect.addEventListener('change', function() {
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

    {{-- <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        tinymce.init({
            selector: 'textarea#description', // Replace this CSS selector to match the placeholder element for TinyMCE
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | image ',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',

            // Image upload configuration for TinyMCE v8
            images_upload_handler: function(blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    const formData = new FormData();

                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route('upload.image') }}');

                    // Add CSRF token to headers
                    xhr.setRequestHeader('X-CSRF-TOKEN', token);

                    xhr.upload.onprogress = (e) => {
                        progress(e.loaded / e.total * 100);
                    };

                    xhr.onload = function() {
                        if (xhr.status === 403) {
                            reject({
                                message: 'HTTP Error: ' + xhr.status,
                                remove: true
                            });
                            return;
                        }

                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }

                        const json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location !== 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        resolve(json.location);
                    };

                    xhr.onerror = function() {
                        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr
                            .status);
                    };

                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                });
            },

            // Additional image options
            image_advtab: true,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',

            // Updated file picker for TinyMCE v8
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        const formData = new FormData();
                        formData.append('file', file);

                        // Using XMLHttpRequest instead of fetch for better compatibility
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '{{ route('upload.image') }}');
                        xhr.setRequestHeader('X-CSRF-TOKEN', token);

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                const data = JSON.parse(xhr.responseText);
                                callback(data.location, {
                                    alt: file.name
                                });
                            } else {
                                alert('Upload failed');
                            }
                        };

                        xhr.onerror = function() {
                            alert('Upload failed');
                        };

                        xhr.send(formData);
                    });

                    input.click();
                }
            }
        });
    </script> --}}

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

        // initialize  froala editor
        new FroalaEditor('textarea#description', {
            pluginsEnabled: ['align'], // disable all plugins
            toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|',
                'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat',
                'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage',
                'insertVideo', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR',
                '|', 'clearFormatting', 'print', 'help', 'html', '|', 'undo', 'redo'
            ],
            heightMin: 200,
            heightMax: 400,
            imageUploadURL: '/froala/upload-image', // route untuk upload
            imageUploadMethod: 'POST',
            requestHeaders: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
            imageMaxSize: 5 * 1024 * 1024, // 5MB
            imageManagerDeleteURL: "/froala/delete-image", // route delete
            events: {
                'image.removed': function($img) {
                    fetch('/froala/delete-image', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            src: $img.attr('src')
                        })
                    });
                }
            }
        });
    </script>



</body>

</html>
