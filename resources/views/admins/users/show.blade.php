<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Users Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 shadow bg-base-200 card card-body sm:p-8 sm:rounded-lg">
                <div class="flex flex-row items-center justify-between mb-4">
                    <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('User Detail') }}</h3>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">
                        Back
                    </a>
                </div>
                {{-- User Form --}}

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Name') }}</legend>
                    <input disabled type="text" class="w-full validator input" name="name"
                        placeholder="{{ __('Type here') }}" value="{{ $user->name }}" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Email') }}</legend>
                    <input disabled type="email" class="w-full validator input" name="email"
                        placeholder="{{ __('Type here') }}" value="{{ $user->email }}" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Role') }}</legend>
                    <select disabled class="w-full select validator" name="role">
                        <option disabled selected>Pick a role</option>
                        <option @selected($user->role == 'admin') value="admin">{{ __('Admin') }}</option>
                        <option @selected($user->role == 'agent') value="agent">{{ __('Agent') }}</option>
                    </select>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Categories of Agent') }}</legend>
                    <select multiple disabled class="w-full tom-select" name="categories[]"
                        placeholder="{{ __('Select categories') }}">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($user->categories->pluck('id')->contains($category->id))>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </fieldset>
                <div class="flex justify-end gap-4 mt-4">
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                        class="btn btn-warning">{{ __('Edit') }}</a>
                    {{-- trigger delete form with confirm --}}
                    <button class="btn btn-error"
                        onclick="if(confirm('{{ __('Are you sure you want to delete this user?') }}')) { return this.nextElementSibling.submit(); }">
                        {{ __('Delete') }}
                    </button>
                    {{-- form for delete but hide --}}
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Add-on Scripts --}}
</x-app-layout>
