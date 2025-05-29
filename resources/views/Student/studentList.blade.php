<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-4 flex justify-between items-center mb-[-24px]">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out"
                    id="addStudentButton">
                    + Add Student
                </button>

            </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="table-auto w-full border-collapse" id="studentTable"></table>

                </div>
            </div>
        </div>
    </div>

     <!-- Modal for Adding Student -->
        <div id="studentModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
            <div class="relative rounded-lg shadow-xl p-6 backgroundModalStudent">

                <button id="closeModalStudent" class="absolute top-0 right-0 m-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Create Student</h2>

                <form action="insertStudent" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('first_name')}}" required>
                        <span style="color: red">
                            @error('first_name') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('last_name')}}" required>
                        <span style="color: red">
                            @error('last_name') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="middle_name" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('middle_name')}}" required>
                        <span style="color: red">
                            @error('middle_name') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="course" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Course</label>

                        <select id="course" name="course" class="w-full border rounded px-3 py-2 dark:bg-gray-800 text-gray-900 dark:text-gray-100 cursor-pointer" required>
                        <option hidden selected></option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSA">BSA</option>
                        <option value="BSBA">BSBA</option>
                        <option value="BTLED">BTLED</option>
                        </select>

                        <span style="color: red">
                            @error('course') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="year_level" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Year Level</label>

                        <select id="editYearLevel" name="year_level" class="cursor-pointer w-full border rounded px-3 py-2 dark:bg-gray-800 text-gray-900 dark:text-gray-100" required>
                        <option hidden selected></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
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

       <!-- Modal Background -->
        @if(session('student_exists'))
        <div id="studentExistsModal">
            <div id="studentExistModalOverlay">
                <div class="modalContent animate-scaleIn">
                    <svg id="dlt_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-red-600 mb-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                    </svg>
                    <h2 class="modalTitle">Student you entered is already exist</h2>
                    <p class="modalMessage">Please check again.</p>
                </div>
            </div>
        </div>

        <script>
            function closeModal() {
                const modal = document.getElementById('studentExistsModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }
            setTimeout(closeModal, 3000);
        </script>
        @endif

        <!-- Modal for Successful Insert -->
        @if(session('success'))
        <div id="studentSuccessModal">
            <div id="studentSuccessModalOverlay">
                <div class="modalContentSucess animate-scaleIn">
                    <svg id="success_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-green-600 mb-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <h2 class="modalTitleSucess">Student Added Successfully</h2>
                    <p class="modalMessageSucess">The new student has been saved.</p>
                </div>
            </div>
        </div>

        <script>
            function closeSuccessModal() {
                const modal = document.getElementById('studentSuccessModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }
            setTimeout(closeSuccessModal, 3000);
        </script>
        @endif

        <!-- Edit Student Modal -->
        <div id="editStudentModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
                <h2 class="text-xl font-semibold mb-4">Update <span id="student_fullname"></span></h2>

                <form id="editStudentForm">
                    @csrf

                    <!-- Student Record ID -->
                    <input type="hidden" id="editStudentID" name="student_id" class="w-full border rounded px-3 py-2" readonly />

                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="editFirstName" class="block font-medium mb-1">First Name</label>
                        <input type="text" id="editFirstName" name="first_name" class="w-full border rounded px-3 py-2" required />
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="editLastName" class="block font-medium mb-1">Last Name</label>
                        <input type="text" id="editLastName" name="last_name" class="w-full border rounded px-3 py-2" required />
                    </div>

                    <!-- Middle Name -->
                    <div class="mb-3">
                        <label for="editMiddleName" class="block font-medium mb-1">Middle Name</label>
                        <input type="text" id="editMiddleName" name="middle_name" class="w-full border rounded px-3 py-2" required />
                    </div>

                    <!-- Course -->
                    <div class="mb-3">
                        <label for="editCourse" class="block font-medium mb-1">Course</label>
                        <select id="editCourse" name="course" class="w-full border rounded px-3 py-2 cursor-pointer" required>
                            <option value="BSIT">BSIT</option>
                            <option value="BSA">BSA</option>
                            <option value="BSBA">BSBA</option>
                            <option value="BTLED">BTLED</option>
                        </select>
                    </div>

                    <!-- Year Level -->
                    <div class="mb-3">
                        <label for="editYearLevel" class="block font-medium mb-1">Year Level</label>
                        <select id="editYearLevel" name="year_level" class="w-full border rounded px-3 py-2 cursor-pointer" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3">
                        <button type="button" id="closeEditStudentModalBtn" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">Cancel</button>
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
                    You're about to inactive this account.
                </p>
                <span class="studentDLT-message block text-sm text-gray-800 mb-5">This action cannot be undone.</span>

                <div class="flex justify-center gap-4">
                    <button id="studentDLTConfirmBtn"
                        class="bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition">Delete</button>
                    <button id="studentDLTCancelBtn"
                        class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400 transition">Cancel</button>
                </div>
            </div>
        </div>

</x-app-layout>
