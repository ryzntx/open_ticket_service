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
                    <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('Ticket List') }}</h3>
                </div>

                <div class="mb-4">
                    <div class="flex flex-row items-center justify-between">
                        {{-- Show Filter Modal Button --}}
                        <div class="block">
                            <button onclick="filter_modal.showModal()" class="btn btn-secondary">
                                {{ __('Filter Tickets') }}
                            </button>
                            {{-- Reset Filter when applied --}}
                            @if (request()->has('search') ||
                                    request()->has('status') ||
                                    request()->has('category_id') ||
                                    request()->has('start_date') ||
                                    request()->has('end_date'))
                                <a href="{{ route('admin.tickets.index') }}" class="btn btn-error">
                                    {{ __('Reset Filters') }}
                                </a>
                            @endif
                        </div>
                        {{-- Search Input --}}
                        <form action="{{ route('admin.tickets.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="{{ __('Search by code or title') }}"
                                class="w-full max-w-xs input input-bordered" value="{{ request('search') }}">
                            <button type="submit" class="ml-2 btn btn-primary">{{ __('Search') }}</button>
                        </form>
                    </div>
                </div>
                {{-- Tickets Table --}}
                <div class="overflow-x-auto border rounded-box border-base-content/5 bg-base-100">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $ticket->code }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        @if ($ticket->status == 'open')
                                            <div class="badge badge-soft badge-info">{{ __('Open') }}</div>
                                        @elseif ($ticket->status == 'in_progress')
                                            <div class="badge badge-soft badge-success">{{ __('In Progress') }}</div>
                                        @elseif ($ticket->status == 'closed')
                                            <div class="badge badge-soft badge-error">{{ __('Closed') }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->category->name }}</td>
                                    <td>{{ $ticket->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($ticket->status == 'open')
                                            <button class="btn btn-warning"
                                                onclick="id_{{ $ticket->id }}_change_status_modal.showModal()">{{ __('Change Status') }}</button>
                                        @elseif ($ticket->status == 'in_progress')
                                            <button class="btn btn-error"
                                                onclick="id_{{ $ticket->id }}_change_status_modal.showModal()">{{ __('Close Ticket') }}</button>
                                        @endif
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                            class="btn btn-primary">{{ __('Show') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No tickets found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
    @foreach ($tickets as $ticket)
        <dialog id="id_{{ $ticket->id }}_change_status_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">
                    {{ __('Are you sure to change status from this ticket?') }}</h3>
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
    @endforeach
    <dialog id="filter_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">
                {{ __('Filter Tickets') }}</h3>
            <form action="{{ route('admin.tickets.index') }}" method="GET" id="filter_form">
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
                {{-- Filter by Status --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Filter by Status') }}</legend>
                    <select name="status" class="w-full input input-bordered">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>{{ __('All') }}
                        </option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('Open') }}
                        </option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                            {{ __('In Progress') }}</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
                            {{ __('Closed') }}</option>
                    </select>
                </fieldset>
                {{-- Filter by Category --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Filter by Category') }}</legend>
                    <select name="category_id" class="w-full input input-bordered">
                        <option value="all" {{ request('category_id') == 'all' ? 'selected' : '' }}>
                            {{ __('All Categories') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </fieldset>
                {{-- Filter by Date --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">{{ __('Filter by Date') }}</legend>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <input type="date" name="start_date" class="w-full input input-bordered"
                            value="{{ request('start_date') }}" placeholder="{{ __('Start Date') }}">
                        <input type="date" name="end_date" class="w-full input input-bordered"
                            value="{{ request('end_date') }}" placeholder="{{ __('End Date') }}">
                    </div>
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
