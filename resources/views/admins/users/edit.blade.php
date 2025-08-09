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
                    <h3 class="mb-4 text-lg font-medium text-base-content">{{ __('Edit User') }}</h3>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">
                        {{ __('Back') }}
                    </a>
                </div>
                {{-- User Form --}}
                <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Name') }}</legend>
                        <input required type="text" class="w-full validator input" name="name"
                            placeholder="{{ __('Type here') }}" value="{{ old('name') ?? $user->name }}" />
                        <p class="label">{{ __('Required') }}</p>
                        @error('name')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Email') }}</legend>
                        <input required type="email" class="w-full validator input" name="email"
                            placeholder="{{ __('Type here') }}" value="{{ old('email') ?? $user->email }}" />
                        <p class="label">{{ __('Required') }}</p>
                        @error('email')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <div class="grid grid-cols-2 gap-4">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Password') }}</legend>
                            <input type="password" class="w-full validator input" name="password"
                                placeholder="{{ __('Type here') }}" />
                            <p class="label">Optional</p>
                            @error('password')
                                <p class="text-sm text-error">{{ $message }}</p>
                            @enderror
                        </fieldset>
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Password Confirmation') }}</legend>
                            <input type="password" class="w-full validator input" name="password_confirmation"
                                placeholder="{{ __('Type here') }}" />
                            <p class="label">Optional</p>

                        </fieldset>
                    </div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Role') }}</legend>
                        <select required class="w-full select validator" name="role"
                            placeholder="{{ __('Pick a role') }}">
                            <option disabled>{{ __('Pick a role') }}</option>
                            <option @selected($user->role == 'admin') value="admin">{{ __('Admin') }}</option>
                            <option @selected($user->role == 'agent') value="agent">{{ __('Agent') }}</option>
                        </select>
                        <span class="label">{{ __('Required') }}</span>
                        @error('role')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Categories of Agent') }}</legend>
                        <select multiple class="w-full tom-select" name="categories[]"
                            placeholder="{{ __('Select categories') }}">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($user->categories->pluck('id')->contains($category->id))>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="label">{{ __('Required if role selected is agent.') }}</span>
                        @error('categories')
                            <p class="text-sm text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add-on Scripts --}}
</x-app-layout>
