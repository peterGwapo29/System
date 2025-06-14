<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Club') }}
        </h2>
        <link rel="stylesheet" href="{{ asset('CSS/club.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-4" style="margin-bottom: -24px;">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out"
                    id="addClubButton">
                    + Add Club
                </button>

                <select name="filterStatusClub" id="filterStatusClub" class="cursor-pointer inline-block text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

            </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="table-auto w-full border-collapse" id="clubTable"></table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Club -->
    <div id="clubModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <div class="relative rounded-lg shadow-xl p-6 bg-white max-w-md w-full modalContentClub">
            <button id="closeModalClub" class="absolute top-0 right-0 m-4 text-gray-700 hover:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Create Club</h2>

            <div id="clubErrorBox" class="text-red-600 text-sm hidden mb-4 p-4 bg-red-100 rounded"></div>


            <form id="addClubForm">
                <div class="mb-4">
                    <label for="club_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Club Name</label>
                    <input type="text" name="club_name" id="club_name" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:text-gray-700" 
                        required>
                </div>

                <div class="mb-4">
                    <label for="club_description" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Description</label>
                    <textarea name="club_description" id="club_description" rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:text-gray-700" 
                        required></textarea>
                </div>

                <div class="mb-4">
                    <label for="adviser_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Adviser Name</label>
                    <input type="text" name="adviser_name" id="adviser_name" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:text-gray-700" 
                        required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="insertClub" 
                        class="bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                        Add Club
                    </button>
                </div>
            </form>
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

    <!-- Edit Club Modal -->
    <div id="editClubModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
            <h2 class="text-xl font-semibold mb-4">Update Club: <span id="club_name_display"></span></h2>

            <div id="noChangesAlert" class="hidden mb-4 p-4 rounded-md bg-yellow-50 border border-yellow-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            No changes detected. Please modify at least one field before saving.
                        </p>
                    </div>
                </div>
            </div>

            <form id="editClubForm">
                @csrf
                <input type="hidden" id="editClubID" name="club_id" class="w-full border rounded px-3 py-2" readonly />

                <div class="mb-3">
                    <label for="editClubName" class="block font-medium mb-1">Club Name</label>
                    <input type="text" id="editClubName" name="club_name" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="editClubDescription" class="block font-medium mb-1">Description</label>
                    <textarea id="editClubDescription" name="description" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="editClubAdviser" class="block font-medium mb-1">Adviser Name</label>
                    <input type="text" id="editClubAdviser" name="adviser_name" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="flex justify-end">
                    <button type="button" id="closeEditClubModalBtn" class="bg-white text-gray-800 font-semibold py-2 px-4 rounded">Cancel</button>
                    <button type="submit" id="updateClubSubmit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Saved</button>
                </div>
            </form>
        </div>
    </div>

    <!-- edit success closeModal -->
    <div id="clubUpdateModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_edit_club">

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

    <!-- Modal for Club Deletion Confirmation -->
    <div id="clubDLTConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn clubDLT-background">
            
            <div class="flex flex-col items-center mb-4">
                <svg id="clubDLT_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-[60px] w-[60px] text-red-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <h2 class="text-2xl font-bold text-red-600">Club Deletion Required</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to deactivate this club.
            </p>
            <span class="clubDLT-message block text-sm text-gray-800 mb-5">This action cannot be undone.</span>

            <div class="flex justify-center gap-4">
                <button id="clubDLTConfirmBtn"
                    class="bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition">Delete</button>
                <button id="clubDLTCancelBtn"
                    class="bg-white text-gray-800 px-4 py-2 transition">Cancel</button>
            </div>
        </div>
    </div>

     <!-- delete success closeModal -->
     <div id="deleteSuccessModalClub" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_delete_club">

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


            <h2 class="text-lg font-semibold">Club Deactivated Successfully</h2>
            <p>The club record has been updated!</p>
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

    <!-- restore success modal -->
    <div id="restoreSuccessModalClub" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_restore_club">
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

            <h2 class="text-lg font-semibold">Club Restored Successfully</h2>
            <p>The club has been reactivated!</p>
        </div>
    </div>

    <script src="{{ asset('js/club/viewClub.js') }}"></script>
    <script src="{{ asset('js/club/addClub.js') }}"></script>
    <script src="{{ asset('js/club/deleteClub.js') }}"></script>
    <script src="{{ asset('js/club/restoreClub.js') }}"></script>
    <script src="{{ asset('js/club/editClub.js') }}"></script>
    
</x-app-layout>
