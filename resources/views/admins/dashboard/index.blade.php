<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-base-content">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">

        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">

            <h3 class="text-lg font-semibold">{{ __('By Statuses') }}</h3>
            <div class="w-full shadow stats">
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="inline-block w-8 h-8 stroke-current lucide lucide-ticket-icon lucide-ticket">
                            <path
                                d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                            <path d="M13 5v2" />
                            <path d="M13 17v2" />
                            <path d="M13 11v2" />
                        </svg>
                    </div>
                    <div class="stat-title">{{ __('Open') }}</div>
                    <div class="stat-value">{{ count($tickets->where('status', 'open')) }}</div>
                    <div class="stat-desc"></div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="inline-block w-8 h-8 stroke-current lucide lucide-pickaxe-icon lucide-pickaxe">
                            <path d="m14 13-8.381 8.38a1 1 0 0 1-3.001-3L11 9.999" />
                            <path
                                d="M15.973 4.027A13 13 0 0 0 5.902 2.373c-1.398.342-1.092 2.158.277 2.601a19.9 19.9 0 0 1 5.822 3.024" />
                            <path
                                d="M16.001 11.999a19.9 19.9 0 0 1 3.024 5.824c.444 1.369 2.26 1.676 2.603.278A13 13 0 0 0 20 8.069" />
                            <path
                                d="M18.352 3.352a1.205 1.205 0 0 0-1.704 0l-5.296 5.296a1.205 1.205 0 0 0 0 1.704l2.296 2.296a1.205 1.205 0 0 0 1.704 0l5.296-5.296a1.205 1.205 0 0 0 0-1.704z" />
                        </svg>
                    </div>
                    <div class="stat-title">{{ __('In Progress') }}</div>
                    <div class="stat-value">{{ count($tickets->where('status', 'in_progress')) }}</div>
                    <div class="stat-desc"></div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="inline-block w-8 h-8 stroke-current lucide lucide-ticket-x-icon lucide-ticket-x">
                            <path
                                d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                            <path d="m9.5 14.5 5-5" />
                            <path d="m9.5 9.5 5 5" />
                        </svg>
                    </div>
                    <div class="stat-title">{{ __('Close') }}</div>
                    <div class="stat-value">{{ count($tickets->where('status', 'closed')) }}</div>
                    <div class="stat-desc"></div>
                </div>
            </div>
            <h3 class="text-lg font-semibold">{{ __('By Priority') }}</h3>
            <div class="w-full shadow stats">
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="inline-block w-8 h-8 stroke-current lucide lucide-signal-low-icon lucide-signal-low">
                            <path d="M2 20h.01" />
                            <path d="M7 20v-4" />
                        </svg>
                    </div>
                    <div class="stat-title">{{ __('Low Priority') }}</div>
                    <div class="stat-value">{{ count($tickets->where('priority', 'low')) }}</div>
                    <div class="stat-desc"></div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="inline-block w-8 h-8 stroke-current lucide lucide-signal-medium-icon lucide-signal-medium">
                            <path d="M2 20h.01" />
                            <path d="M7 20v-4" />
                            <path d="M12 20v-8" />
                        </svg>
                    </div>
                    <div class="stat-title">{{ __('Medium Priority') }}</div>
                    <div class="stat-value">{{ count($tickets->where('priority', 'medium')) }}</div>
                    <div class="stat-desc"></div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="inline-block w-8 h-8 stroke-current lucide lucide-signal-high-icon lucide-signal-high">
                            <path d="M2 20h.01" />
                            <path d="M7 20v-4" />
                            <path d="M12 20v-8" />
                            <path d="M17 20V8" />
                        </svg>
                    </div>
                    <div class="stat-title">{{ __('High Priority') }}</div>
                    <div class="stat-value">{{ count($tickets->where('priority', 'high')) }}</div>
                    <div class="stat-desc"></div>
                </div>
            </div>
            <h3 class="text-lg font-semibold">{{ __('By Categories') }}</h3>
            <div class="w-full overflow-x-auto shadow stats">
                <div class="flex space-x-4 min-w-max">
                    @foreach ($categories as $category)
                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="inline-block w-8 h-8 stroke-current lucide lucide-tags-icon lucide-tags">
                                    <path
                                        d="M13.172 2a2 2 0 0 1 1.414.586l6.71 6.71a2.4 2.4 0 0 1 0 3.408l-4.592 4.592a2.4 2.4 0 0 1-3.408 0l-6.71-6.71A2 2 0 0 1 6 9.172V3a1 1 0 0 1 1-1z" />
                                    <path d="M2 7v6.172a2 2 0 0 0 .586 1.414l6.71 6.71a2.4 2.4 0 0 0 3.191.193" />
                                    <circle cx="10.5" cy="6.5" r=".5" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="stat-title">{{ $category->name }}</div>
                            <div class="stat-value">{{ count($category->tickets) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
