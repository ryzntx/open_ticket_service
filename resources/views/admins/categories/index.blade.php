<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Categories Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 shadow-sm card card-body bg-base-200 sm:p-8 sm:rounded-lg">
                <div class="flex flex-row items-center justify-between mb-4">
                    <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('Categories List') }}</h3>
                    <button onclick="add_modal.showModal()" class="btn btn-primary">
                        {{ __('Add New Category') }}
                    </button>
                </div>
                {{-- Users Table --}}
                <div class="overflow-x-auto border rounded-box border-base-content/5 bg-base-100">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button onclick="edit_{{ $category->id }}_modal.showModal()"
                                            class="btn btn-primary">{{ __('Edit') }}</button>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error"
                                                onclick="
                                            return confirm('{{ __('Are you sure you want to delete this category? This action cannot be undone.') }}');"
                                                {{ $category->tickets->count() > 0 ? 'disabled' : '' }}
                                                title="{{ $category->tickets->count() > 0 ? __('Cannot delete category with existing tickets') : '' }}" ">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No categories found.') }}</td>
                                </tr>
 @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    <dialog id="add_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ __('Create new Category') }}</h3>
            <form action="{{ route('admin.categories.store') }}" method="post" id="add_category_form">
                @csrf
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Name') }}</legend>
                    <input required type="text" class="w-full validator input" name="name"
                        placeholder="{{ __('Type here') }}" value="{{ old('name') }}" />
                    <p class="label">{{ __('Required') }}</p>
                    @error('name')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
            </form>
            <div class="modal-action">
                <button form="add_category_form" class="btn btn-primary">{{ __('Create') }}</button>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">{{ __('Close') }}</button>
                </form>
            </div>
        </div>
    </dialog>

    @foreach ($categories as $category)
        <dialog id="edit_{{ $category->id }}_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">{{ __('Edit Category') }}</h3>
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post"
                    id="edit_category_form_{{ $category->id }}">
                    @csrf
                    @method('PUT')
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Name') }}</legend>
                        <input required type="text" class="w-full validator input" name="name"
                            value="{{ $category->name }}" placeholder="{{ __('Type here') }}" />
                        <p class="label">{{ __('Required') }}</p>
                        @error('name')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                </form>
                <div class="modal-action">
                    <button form="edit_category_form_{{ $category->id }}"
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
