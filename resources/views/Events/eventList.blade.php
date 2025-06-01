<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('CSS/event.css') }}">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out"
                                id="addEventButton">
                                + Add Event
                            </button>

                            <select id="filterStatus" class="rounded-md">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>

                        </div>
                    </div>

                    <table id="eventTable" class="w-full"></table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Event -->
    <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <div class="relative rounded-lg shadow-xl p-6 backgroundModalMembership w-full max-w-md">

            <div id="eventErrorBox" class="text-red-600 text-sm hidden mb-2"></div>

            <button id="closeEventModal" class="absolute top-0 right-0 m-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Add Event</h2>

            <form id="addEventForm">
                @csrf

                <div class="mb-4">
                    <label for="club_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Club ID</label>
                    <input type="number" name="club_id" id="club_id" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="event_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Event Name</label>
                    <input type="text" name="event_name" id="event_name" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Event Date</label>
                    <input type="date" name="event_date" id="event_date" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="venue" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Venue</label>
                    <input type="text" name="venue" id="venue" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="event_description" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Description</label>
                    <textarea name="event_description" id="event_description" rows="3" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="addEventSubmit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_add_event">
            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h2 class="text-lg font-semibold">Event Added Successfully</h2>
            <p>The event has been created!</p>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div id="editEventModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <div class="relative rounded-lg shadow-xl p-6 backgroundModalMembership w-full max-w-md">
            <div id="editEventErrorBox" class="text-red-600 text-sm hidden mb-2"></div>

            <button id="closeEditEventModal" class="absolute top-0 right-0 m-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Edit Event</h2>

            <form id="editEventForm">
                @csrf
                <input type="hidden" name="event_id" id="edit_event_id">

                <div class="mb-4">
                    <label for="edit_club_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Club ID</label>
                    <input type="number" name="club_id" id="edit_club_id" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="edit_event_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Event Name</label>
                    <input type="text" name="event_name" id="edit_event_name" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="edit_event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Event Date</label>
                    <input type="date" name="event_date" id="edit_event_date" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="edit_venue" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Venue</label>
                    <input type="text" name="venue" id="edit_venue" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="edit_event_description" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Description</label>
                    <textarea name="event_description" id="edit_event_description" rows="3" class="mt-1 block w-full rounded-md px-3 py-2 bg-white text-gray-900 dark:text-gray-800 border border-gray-300" required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="updateEventBtn bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Success Modal -->
    <div id="editSuccessModalEvent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_edit_event">
            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h2 class="text-lg font-semibold">Event Updated Successfully</h2>
            <p>The event has been updated!</p>
        </div>
    </div>

    <!-- Restore Event Modal -->
    <div id="restoreEventModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn background_restore_event">
            <div class="flex flex-col items-center mb-4">
                <svg id="restoreEventIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-green-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <h2 class="text-2xl font-bold text-green-600">Restore Event</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to restore this event.
            </p>
            <span class="eventRestore-message block text-sm text-gray-800 mb-5">This will make the event active again.</span>

            <div class="flex justify-center gap-4">
                <button id="confirmRestoreBtn"
                    class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 transition">Restore</button>
                <button id="closeRestoreEventModal"
                    class="bg-white text-gray-800 px-4 py-2 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Modal for Event Deletion Confirmation -->
    <div id="eventDLTConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn eventDLT-background">
            <div class="flex flex-col items-center mb-4">
                <svg id="eventDLT_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-[60px] w-[60px] text-red-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <h2 class="text-2xl font-bold text-red-600">Event Deletion Required</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to inactive this event.
            </p>
            <span class="eventDLT-message block text-sm text-gray-800 mb-5">This action cannot be undone.</span>

            <div class="flex justify-center gap-4">
                <button id="eventDLTConfirmBtn"
                    class="bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition">Delete</button>
                <button id="eventDLTCancelBtn"
                    class="bg-white text-gray-800 px-4 py-2 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Delete Success Modal -->
    <div id="deleteSuccessModalEvent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_delete_event">
            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h2 class="text-lg font-semibold">Event Deleted Successfully</h2>
            <p>The event has been deactivated!</p>
        </div>
    </div>

    <!-- Restore Success Modal -->
    <div id="restoreSuccessModalEvent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_restore_event">
            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h2 class="text-lg font-semibold">Event Restored Successfully</h2>
            <p>The event has been reactivated!</p>
        </div>
    </div>

    <!-- edit success Modal -->
    <div id="modalSuccessEventEdit" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_edit_event">

            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Club Updated Successfully</h2>
            <p>The club information has been updated!</p>
        </div>
    </div>


    <!-- add success closeModal -->
    <div id="modalSuccessEventAdd" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_add_event">

            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Club Updated Successfully</h2>
            <p>The club information has been updated!</p>
        </div>
    </div>


    <!-- delete success closeModal -->
    <div id="modalSuccessEventDelete" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_delete_event">

            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Club Updated Successfully</h2>
            <p>The club information has been updated!</p>
        </div>
    </div>


    <!-- restore success closeModal -->
    <div id="modalSuccessEventRestore" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_restore_event">

            <div class="sparkle sparkle000001"></div>
            <div class="sparkle sparkle000002"></div>
            <div class="sparkle sparkle000003"></div>
            <div class="sparkle sparkle000004"></div>
            <div class="sparkle sparkle000005"></div>
            <div class="sparkle sparkle000006"></div>
            <div class="sparkle sparkle000007"></div>
            <div class="sparkle sparkle000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Club Updated Successfully</h2>
            <p>The club information has been updated!</p>
        </div>
    </div>

</x-app-layout>
