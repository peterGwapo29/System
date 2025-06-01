<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex space-x-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Last updated: {{ now()->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section with Quick Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Welcome Message -->
                <div style="width: 590px; text-align: center; place-items: center;" class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Welcome back, {{ Auth::user()->name }}!</h1>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Here's what's happening in your clubs and events.</p>
                        </div>
                        <div class="hidden sm:block">
                            <div  class="p-3 bg-blue-50 dark:bg-blue-900/50 rounded-full">
                                <svg class="w-8 h-8 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div style="padding: 10px;" class="border-l-4 border-green-500 pl-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Next Event</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $stats['next_event_in'] }}</p>
                        </div>
                        <div class="border-l-4 border-purple-500 pl-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Students</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $stats['active_students'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div style="margin-left: 210px; width: 590px; text-align: center; place-items: center;" class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <br>    
                <h2 class="text-lg font-semibold mb-4 text-white" style="font-size: 24px; padding: 10px;">Quick Overview</h2>
                    <div class="space-y-3">
                        <div class="text-white flex items-center justify-between" style="margin-bottom: 10px;">
                            <span class="text-sm opacity-90">Active Accounts</span>
                            <span class="font-semibold">{{ $stats['active_accounts'] }}</span>
                        </div>

                        
                        <div class="h-px bg-white/20"></div>
                        <div style="margin-bottom: 10px; text-align: center; place-items: center;" class="text-white flex items-center justify-between">
                            <span class="text-white text-sm opacity-90">Total Events</span>
                            <span class="font-semibold text-white">{{ $stats['active_events'] + $stats['upcoming_events'] }}</span>
                        </div>
                        
                        <div class="h-px bg-white/20"></div>
                        <div class="text-white flex items-center justify-between">
                            <span class="text-sm opacity-90">Tota Registrations </span>
                            <span class="font-semibold">{{ $stats['event_registrations'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Clubs Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Clubs</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_clubs'] }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-sm text-{{ $stats['club_growth'] >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $stats['club_growth'] >= 0 ? 'green' : 'red' }}-400">
                                    @if($stats['club_growth'] >= 0)
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Events Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Events</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['active_events'] }}</p>
                            <div class="flex items-center mt-1">
                                <span style="color: green;" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ $stats['upcoming_events'] }} upcoming
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Members Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Members</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_members'] }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-sm text-{{ $stats['member_growth'] >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $stats['member_growth'] >= 0 ? 'green' : 'red' }}-400">
                                    @if($stats['member_growth'] >= 0)
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Registrations Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Event Registrations</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['event_registrations'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total registrations</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Stats Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Membership Types -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Membership Distribution</h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Total: {{ $stats['regular_members'] + $stats['premium_members'] + $stats['officer_members'] + $stats['guest_members'] }}</span>
                    </div>
                    <div class="space-y-4">
                        <!-- Regular Members -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100 ml-2">Regular Members</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $stats['regular_members'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($stats['regular_members'] / ($stats['regular_members'] + $stats['premium_members'] + $stats['officer_members'] + $stats['guest_members'])) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Premium Members -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100 ml-2">Premium Members</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $stats['premium_members'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ ($stats['premium_members'] / ($stats['regular_members'] + $stats['premium_members'] + $stats['officer_members'] + $stats['guest_members'])) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Officer Members -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100 ml-2">Officer Members</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $stats['officer_members'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($stats['officer_members'] / ($stats['regular_members'] + $stats['premium_members'] + $stats['officer_members'] + $stats['guest_members'])) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Guest Members -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100 ml-2">Guest Members</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $stats['guest_members'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ ($stats['guest_members'] / ($stats['regular_members'] + $stats['premium_members'] + $stats['officer_members'] + $stats['guest_members'])) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Upcoming Events</h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Next {{ count($upcoming_events) }} events</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($upcoming_events as $event)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex-shrink-0">
                            <div class="w-12 h-12 flex items-center justify-center bg-green-200 dark:bg-green-900 rounded-lg">
                                <svg class="w-6 h-6 text-green-200 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>

                            </div>
                            <div style="margin-left: 10px;" class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-white">{{ $event['title'] }}</h3>
                                    <span class="text-sm font-medium text-white">{{ $event['club_name'] }}</span>
                                </div>
                                <div class="mt-2 grid grid-cols-3 gap-4">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $event['start_time'] }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $event['location'] }}
                                    </div>
                                    <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ $event['attendees_count'] }} attendees
                                    </div>

                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No upcoming events scheduled</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Check back later for new events</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
