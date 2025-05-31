<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-4" style="margin-bottom: -24px;">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out"
                    id="addStudentButton">
                    + Add Student
                </button>

                <select name="filterStatusStudent" id="filterStatusStudent" class="cursor-pointer inline-block text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

            </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="table-auto w-full border-collapse" id="studentTable"></table>

                </div>
            </div>
        </div>
    </div>

    <div id="successModal" class="fixed inset-0 bg-green-500 text-white flex items-center justify-center hidden z-50">
        <div class="bg-white text-green-700 p-4 rounded shadow-lg">Student successfully added!</div>
    </div>

    <!-- Modal for Adding Student -->
    <div id="studentModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <div class="relative rounded-lg shadow-xl p-6 backgroundModalStudent">

            <div id="studentErrorBox" class="text-red-600 text-sm hidden mb-2"></div>
            
            <button id="closeModalStudent" class="absolute top-0 right-0 m-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Create Student</h2>

            <form id="addStudentForm" action="insertStudent" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="mt-1 block w-full border border-gray-800 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800" value="{{old('first_name')}}" required>
                    <span style="color: red">
                        @error('first_name') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800" value="{{old('last_name')}}" required>
                    <span style="color: red">
                        @error('last_name') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-4">
                    <label for="middle_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800" value="{{old('middle_name')}}" required>
                    <span style="color: red">
                        @error('middle_name') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <label for="course" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Course</label>

                    <select id="course" name="course" class="w-full border rounded px-3 py-2 text-gray-900 dark:text-gray-800 cursor-pointer" required>
                    <option hidden selected></option>
                    <option style="color: black;" value="BSIT">BSIT</option>
                    <option style="color: black;" value="BSA">BSA</option>
                    <option style="color: black;" value="BSBA">BSBA</option>
                    <option style="color: black;" value="BTLED">BTLED</option>
                    </select>

                    <span style="color: red">
                        @error('course') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <label for="year_level" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Year Level</label>

                    <select id="editYearLevel" name="year_level" class="cursor-pointer w-full border rounded px-3 py-2 text-gray-900 dark:text-gray-800" required>
                    <option hidden selected></option>
                    <option style="color: black;" value="1">1</option>
                    <option style="color: black;" value="2">2</option>
                    <option style="color: black;" value="3">3</option>
                    <option style="color: black;" value="4">4</option>
                    </select>

                    <span style="color: red">
                        @error('year_level') {{ $message }} @enderror
                    </span>
                </div>

                <div class="flex justify-end">
                    <button id="insertData" type="submit" class="bg-blue-600 hover:bg-blue-700 text-gray-700 font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                        Add Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editStudentModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
            <h2 class="text-xl font-semibold mb-4">Update <span id="student_fullname"></span></h2>

            <form id="editStudentForm">
                @csrf

                <input type="hidden" id="editStudentID" name="student_id" class="w-full border rounded px-3 py-2" readonly />

                <div class="mb-3">
                    <label for="editFirstName" class="block font-medium mb-1">First Name</label>
                    <input type="text" id="editFirstName" name="first_name" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="editLastName" class="block font-medium mb-1">Last Name</label>
                    <input type="text" id="editLastName" name="last_name" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="editMiddleName" class="block font-medium mb-1">Middle Name</label>
                    <input type="text" id="editMiddleName" name="middle_name" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="editCourse" class="block font-medium mb-1">Course</label>
                    <select id="editCourse" name="course" class="w-full border rounded px-3 py-2 cursor-pointer" required>
                        <option value="BSIT">BSIT</option>
                        <option value="BSA">BSA</option>
                        <option value="BSBA">BSBA</option>
                        <option value="BTLED">BTLED</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="editYearLevel" class="block font-medium mb-1">Year Level</label>
                    <select id="editYearLevel" name="year_level" class="w-full border rounded px-3 py-2 cursor-pointer" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="closeEditStudentModalBtn" class="bg-white text-gray-800 font-semibold py-2 px-4 rounded">Cancel</button>
                    <button type="submit" id="updateStudentSubmit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Successful Update -->
    <div id="studentUpdateModal" class="hidden">
        <div id="studentUpdateModalOverlay">
            <div class="modalContentUpdate animate-scaleIn">
                <svg id="update_success_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <h2 class="modalTitleUpdate">Student Updated Successfully</h2>
                <p class="modalMessageUpdate">The student record has been updated.</p>
            </div>
        </div>
    </div>

    <!-- Modal for Student Deletion Confirmation -->
    <div id="studentDLTConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn studentDLT-background">
            
            <div class="flex flex-col items-center mb-4">
                <svg id="studentDLT_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-[60px] w-[60px] text-red-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <h2 class="text-2xl font-bold text-red-600">Student Deletion Required</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to inactive this student.
            </p>
            <span class="studentDLT-message block text-sm text-gray-800 mb-5">This action cannot be undone.</span>

            <div class="flex justify-center gap-4">
                <button id="studentDLTConfirmBtn"
                    class="bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition">Delete</button>
                <button id="studentDLTCancelBtn"
                    class="bg-white text-gray-800 px-4 py-2 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Modal for Successful Delete -->
    <div id="studentDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div id="deleteMod" class="bg-white shadow-lg p-6 text-center animate-scaleIn">
            <div class="modalContentDelete animate-scaleIn">
                <svg id="delete_success_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <h2 class="modalTitleDelete">Student Deactivated Successfully</h2>
                <p class="modalMessageDelete">The student record has been updated.</p>
            </div>
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

    <div id="storeSuccessModalStudent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_store_student">

            <div class="sparkle sparkle00001"></div>
            <div class="sparkle sparkle00002"></div>
            <div class="sparkle sparkle00003"></div>
            <div class="sparkle sparkle00004"></div>
            <div class="sparkle sparkle00005"></div>
            <div class="sparkle sparkle00006"></div>
            <div class="sparkle sparkle00007"></div>
            <div class="sparkle sparkle00008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>

            <h2 class="text-lg font-semibold">Restored</h2>
            <p>Student successfully restore!</p>
        </div>
    </div>

    <!-- edit success closeModal -->
     <div id="editSuccessModalStudent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_edit_student">

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


            <h2 class="text-lg font-semibold">Success</h2>
            <p>Student successfully updated!</p>
        </div>
    </div>

    <!-- delete success closeModal -->
     <div id="deleteSuccessModalStudent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_delete_student">

            <div class="sparkle sparkle0000001"></div>
            <div class="sparkle sparkle0000002"></div>
            <div class="sparkle sparkle0000003"></div>
            <div class="sparkle sparkle0000004"></div>
            <div class="sparkle sparkle0000005"></div>
            <div class="sparkle sparkle0000006"></div>
            <div class="sparkle sparkle0000007"></div>
            <div class="sparkle sparkle0000008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Delete</h2>
            <p>Student successfully delete!</p>
        </div>
    </div>

    <!-- add success modal -->
    <div id="addSuccessModalStudent" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_add_student">

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

</x-app-layout>
