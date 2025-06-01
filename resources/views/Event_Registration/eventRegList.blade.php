<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Event Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                            <div class="p-4" style="margin-bottom: -24px;">
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out"
                                    id="addRegbutton">
                                    + Register Event
                                </button>

                                <select name="filterStatus" id="filterStatus" class="cursor-pointer inline-block text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                                    <option value="all" selected>All</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="completed">Completed</option>
                                </select>

                            </div>
                                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                                    <table class="table-auto w-full border-collapse" id="event_regTable"></table>
                                </div>
                            </div>
                        </div>
                
                </div>
            </div>
        </div>
    </div>

    <!-- Event Registration Modal -->
    <div id="registerEventModal" class="fixed inset-0 hidden z-50 overflow-y-auto">
        <!-- Overlay Background -->
        <div class="screenning fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-[500px] bg-white rounded-xl shadow-2xl transform transition-all">
                <!-- Modal Header -->
                <div class="bg-gray-50 p-4 rounded-t-xl border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900">Register Event</h3>
                        <button type="button" id="closeRegisterBtn" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 rounded-lg">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 bodyModalEventReg">
                    <div id="registerEventErrorBox" class="hidden w-full text-red-500 text-sm mb-6 bg-red-50 border border-red-200 px-4 py-3 rounded-md"></div>

                    <form id="registerEventForm" class="w-full">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="student_id">
                                Student Name
                            </label>
                            <div class="relative">
                                <select id="student_id" name="student_id" required
                                    class="cursor-pointer w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none bg-white">
                                    <option value="">Select a student</option>
                                </select>
                            </div>
                        </div>

                        <!-- Event Selection -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="event_id">
                                Event Name
                            </label>
                            <div class="relative">
                                <select id="event_id" name="event_id" required
                                    class="cursor-pointer w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none bg-white">
                                    <option value="">Select an event</option>
                                </select>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-3 mt-8">

                            <button id="registerEventBtn" type="submit"
                                class="px-4 py-2.5 bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium inline-flex items-center transition-colors duration-200" style="border-radius: 5px;">
                                
                                Register Event
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
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

            <h2 class="text-lg font-semibold">Success!</h2>
            <p>Event registration completed successfully!</p>
        </div>
    </div>

    <!-- add success modal -->
    <div id="addSuccessModalClub" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_add_club">

            <div class="sparkle sparkle00000001"></div>
            <div class="sparkle sparkle00000002"></div>
            <div class="sparkle sparkle00000003"></div>
            <div class="sparkle sparkle00000004"></div>
            <div class="sparkle sparkle00000005"></div>
            <div class="sparkle sparkle00000006"></div>
            <div class="sparkle sparkle00000007"></div>
            <div class="sparkle sparkle00000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Success</h2>
            <p>Student successfully added!</p>
        </div>
    </div>

    <!-- Restore Confirmation Modal Student-->
    <div id="restoreStudentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn background_restore_student">
            <div class="flex flex-col items-center mb-4">
                
                <svg id="restoreStudentIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-green-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <h2 class="text-2xl font-bold text-green-600">Restore Student</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to restore this student.
            </p>
            <span class="student_second_message block text-sm text-gray-800 mb-5">This action will reactivate the student.</span>

            <div class="flex justify-center gap-4 mt-4">
                <button id="confirmRestoreStudentBtn" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 transition">Restore</button>
                <button id="cancelRestoreStudentBtn" class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Status Change Confirmation Modal -->
    <div id="statusChangeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[500px] text-center animate-scaleIn">
            <div class="flex flex-col items-center mb-4">
                <svg id="statusIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-blue-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-blue-600">Change Status</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to change this event registration status.
            </p>
            <span id="statusMessage" class="block text-sm text-gray-800 mb-5">Are you sure you want to mark this as "<span id="newStatus"></span>"?</span>

            <div class="flex justify-center gap-4 mt-4">
                <button id="confirmStatusBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Confirm</button>
                <button id="cancelStatusBtn" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Status Change Success Modal -->
    <div id="statusSuccessModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
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

            <h2 class="text-lg font-semibold">Success!</h2>
            <p>Status updated successfully!</p>
        </div>
    </div>

    <style>
    @keyframes scaleIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .animate-scaleIn {
        animation: scaleIn 0.3s ease-out;
    }

    /* Success Modal Styles */
    .content_success_add_event {
        width: 350px;
        background-color: white;
        border-radius: 12px;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        animation: fadeInSuccess 0.3s ease-out;
        position: relative;
        overflow: hidden;
    }

    /* Sparkle particles */
    .sparkle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: gold;
        border-radius: 50%;
        opacity: 0.8;
        animation: sparkleAnimation 1.5s infinite ease-in-out;
        z-index: 1;
    }

    .sparkle000001 { top: 20px; left: 40px; animation-delay: 0s; }
    .sparkle000002 { top: 30px; right: 50px; animation-delay: 0.3s; }
    .sparkle000003 { bottom: 40px; left: 60px; animation-delay: 0.6s; }
    .sparkle000004 { bottom: 30px; right: 30px; animation-delay: 0.9s; }
    .sparkle000005 { top: 10px; right: 80px; animation-delay: 1.2s; }
    .sparkle000006 { bottom: 20px; left: 100px; animation-delay: 1.4s; }
    .sparkle000007 { bottom: 15px; left: 30px; animation-delay: 1.4s; }
    .sparkle000008 { bottom: 25px; left: 20px; animation-delay: 1.4s; }

    /* Success modal icon */
    .content_success_add_event svg {
        width: 70px;
        height: 70px;
        display: block;
        filter: drop-shadow(0 4px 6px rgba(12, 119, 35, 0.5));
        color: rgb(12, 119, 35);
        z-index: 2;
    }

    /* Animation keyframes */
    @keyframes fadeInSuccess {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes sparkleAnimation {
        0%, 100% {
            transform: scale(1) translateY(0);
            opacity: 0.8;
        }
        50% {
            transform: scale(1.5) translateY(-10px);
            opacity: 0.3;
        }
    }

    /* Success modal text styles */
    .content_success_add_event h2 {
        color: rgb(12, 119, 35);
        margin: 0;
    }

    .content_success_add_event p {
        color: #666;
        margin: 0;
    }
    </style>

</x-app-layout>