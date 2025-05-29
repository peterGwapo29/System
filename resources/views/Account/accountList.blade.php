<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-4" style="margin-bottom: -24px;">
                <button
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out" id="addAccountButton">
                    + Add Account
                </button>
            </div>

                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="table-auto w-full border-collapse" id="accountTable"></table>

                </div>
            </div>
        </div>
    </div>

        <!-- Modal for Adding Account -->
        <div id="accountModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
            <div class="relative rounded-lg shadow-xl p-6 backgroundModalAccount">

                <button id="closeModalAccount" class="absolute top-0 right-0 m-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Create Account</h2>

                @if(Session::has('fail'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ Session::get('fail') }}</span>
                    </div>
                @endif

                <form action="insert" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Student ID</label>
                        <input type="number" name="student_id" id="student_id" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('student_id')}}" required>
                        <span style="color: red">
                            @error('student_id') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Username</label>
                        <input type="text" name="username" id="username" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('username')}}" required>
                        <span style="color: red">
                            @error('username') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('password')}}" required>
                        <span style="color: red">
                            @error('password') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('email')}}" required>
                        <span style="color: red">
                            @error('email') {{ $message }} @enderror
                        </span>
                    </div>

                    <div class="flex justify-end">
                        <button id="insertData" type="submit" class="bg-blue-600 hover:bg-blue-700 text-gray-700 font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- data password modal -->
        <div id="passwordModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
            <div class="overlayModalTable">
                <div class="bg-white w-[500px] h-[500px] rounded-lg shadow-xl relative flex flex-col justify-center items-center text-center p-6">
                
                    <p id="passwordContent" class="mb-6 font-mono text-gray-800 break-all text-lg"></p>

                    <button id="closeModalBtn" class="closePassModal">
                        Close
                    </button>
                </div>
            </div>
        </div>

        
        <!-- Edit Account Modal -->
        <div id="editAccountModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
                <h2 class="text-xl font-semibold mb-4">Update <span id="account_username"></span></h2>
                
                <form id="editAccountForm">
                <div class="mb-3">
                    <input type="hidden" id="editAccountId" name="account_id" class="w-full border rounded px-3 py-2" readonly />
                </div>

                <div class="mb-3">
                    <label for="editStudentId" class="block font-medium mb-1"></label> 
                    <input type="hidden" id="editStudentId" name="student_id" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="editUsername" class="block font-medium mb-1">Username</label>
                    <input type="text" id="editUsername" name="username" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="editPassword" class="block font-medium mb-1">Password</label>
                    <input type="password" id="editPassword" name="password" class="w-full border rounded px-3 py-2" required/>
                </div>

                <div class="mb-3">
                    <label for="editEmail" class="block font-medium mb-1">Email</label>
                    <input type="email" id="editEmail" name="email" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <select hidden id="editStatus" name="account_status" class="w-full border rounded px-3 py-2" required>
                    <option hidden value="Active">Active</option>
                    <option hidden value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="closeEditModalBtn">Cancel</button>
                    <button type="submit" id="updateAccountSubmit">Save</button>
                </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn background_delete">
                
                <!-- Centered Icon -->
                <div class="flex flex-col items-center mb-4">
                    <svg id="dlt_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-red-600 mb-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-red-600">Account Deletion Required</h2>
                </div>

                <!-- Message Section -->
                <p class="text-gray-800 mb-1">
                    You're about to inactive this account.
                </p>
                <span class="second_message block text-sm text-gray-800 mb-5">This action cannot be undone.</span>

                <!-- Action Buttons -->
                <div class="flex justify-center gap-4">
                    <button id="confirmDeleteBtn" class="bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition">Delete</button>
                    <button id="cancelDeleteBtn" class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400 transition">Cancel</button>
                </div>
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
                    <h2 class="modalTitle">The Student ID you entered is taken</h2>
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

        @if(session('success_add_student'))
            <div id="successAddStudent">
                <div id="successAddStudentOverlay">
                    <div class="successModalContent animate-scaleIn">
                        <svg id="success_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                        <h2 class="successModalTitle">Success!</h2>
                        <p class="successModalMessage">Account successfully added.</p>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    const modal = document.getElementById('successAddStudent');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                }, 3000);
            </script>
        @endif


</x-app-layout>
