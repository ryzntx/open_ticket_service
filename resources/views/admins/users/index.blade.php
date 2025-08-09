<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Users Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 shadow-sm card card-body bg-base-200 sm:p-8 sm:rounded-lg">
                <div class="flex flex-row items-center justify-between mb-4">
                    <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('Users List') }}</h3>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        {{ __('Add New User') }}
                    </a>
                </div>
                <div class="mb-4">
                    <div class="flex flex-row items-center justify-between">
                        {{-- Show Filter Modal Button --}}
                        <div class="block">
                            <button onclick="filter_modal.showModal()" class="btn btn-secondary">
                                {{ __('Filter Users') }}
                            </button>
                            {{-- Reset Filter when applied --}}
                            @if (request()->has('search') || request()->has('role') || request()->has('category_id') || request()->has('per_page'))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-error">
                                    {{ __('Reset Filters') }}
                                </a>
                            @endif
                        </div>
                        {{-- Search Input --}}
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="{{ __('Search by name or email') }}"
                                class="w-full max-w-xs input input-bordered" value="{{ request('search') }}">
                            <button type="submit" class="ml-2 btn btn-primary">{{ __('Search') }}</button>
                        </form>
                    </div>
                </div>
                {{-- Users Table --}}
                <div class="overflow-x-auto border rounded-box border-base-content/5 bg-base-100">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Agent') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->categories->pluck('name')->implode(', ') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="btn btn-primary">{{ __('Show') }}</a>
                                        {{-- trigger delete form with confirm --}}
                                        <button class="btn btn-error" form="delete_user_{{ $user->id }}"
                                            {{ $user->id == auth()->id() ? 'disabled' : '' }}
                                            title="{{ $user->id == auth()->id() ? __('You cannot delete your own account') : '' }}"
                                            onclick="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                                            {{ __('Delete') }}
                                        </button>
                                        {{-- form for delete but hide --}}
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            class="hidden" id="delete_user_{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error">{{ __('Delete') }}</button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No users found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    <dialog id="filter_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">
                {{ __('Filter Users') }}</h3>
            <form action="{{ route('admin.users.index') }}" method="GET" id="filter_form">
                {{-- @csrf --}}
                {{-- Show ... Item --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Show') }}</legend>
                    <select name="per_page" class="w-full input input-bordered">
                        <option value="5" {{ request('per_page') == 10 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </fieldset>
                {{-- Filter by role --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Filter by Role') }}</legend>
                    <select name="role" class="w-full input input-bordered">
                        <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>{{ __('All Roles') }}
                        </option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                            {{ __('Admin') }}</option>
                        <option value="agent" {{ request('role') == 'agent' ? 'selected' : '' }}>
                            {{ __('Agent') }}</option>
                    </select>
                </fieldset>
                {{-- Filter by Category agent --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Filter by Category') }}</legend>
                    <select name="category_id" class="w-full input input-bordered">
                        <option value="all" {{ request('category_id') == 'all' ? 'selected' : '' }}>
                            {{ __('All Categories') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </form>
            <div class="modal-action">
                <button form="filter_form" class="btn btn-primary">{{ __('Apply Filters') }}</button>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">{{ __('Close') }}</button>
                </form>
            </div>
        </div>
    </dialog>
</x-app-layout>
