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

                <select name="filterStatus" id="filterStatus" class="cursor-pointer inline-block text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

            </div>

                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="table-auto w-full border-collapse" id="accountTable"></table>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Account Modal -->
    <div id="addAccountModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
            <h2 class="text-xl font-semibold mb-4">Add Account</h2>

            <div id="addAccountError" class="hidden text-red-600 text-sm mb-3"></div>

            <form id="addAccountForm">
                <div class="mb-3">
                    <label for="student_id" class="block font-medium mb-1">Student ID</label>
                    <input type="number" id="student_id" name="student_id" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="username" class="block font-medium mb-1">Username</label>
                    <input type="text" id="username" name="username" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="password" class="block font-medium mb-1">Password</label>
                    <input minlength="8" type="password" id="password" name="password" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="email" class="block font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" id="cancelAddBtn" class="addbtnCANCEL">Cancel</button>
                    <button type="submit" id="submitAddBtn" class="addbtnADD">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="passwordModal" class="fixed inset-0 z-50 hidden">
        <div class="overlayModalTable">
            <div class="relative bg-white/20 backdrop-blur-md w-[400px] shadow-2xl border border-white/30 p-8 flex flex-col items-center text-center">
                <button id="closeModalBtn" class="closePassModal absolute top-3 right-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <h2 class="text-xl font-semibold text-white mb-4 PI">Password Information</h2>
                <p id="passwordContent" class="bg-white text-gray-800 px-4 py-2 rounded-md text-base font-mono shadow-inner break-words max-w-full"></p>
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
                <p id="editUsernameError" class="text-red-600 text-sm mt-1 hidden">Username error here</p>
            </div>


            <div class="mb-3">
                <label for="editPassword" class="block font-medium mb-1">Password</label>
                <input type="password" id="editPassword" name="password" class="w-full border rounded px-3 py-2" minlength="8"/>
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
            <div class="flex flex-col items-center mb-4">
                <svg id="dlt_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-red-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <h2 class="text-2xl font-bold text-red-600">Account Deletion Required</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to inactive this account.
            </p>
            <span class="second_message block text-sm text-gray-800 mb-5">This action can be undone later by restoring the account.</span>

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

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_insert">

        <div class="sparkle sparkle1"></div>
        <div class="sparkle sparkle2"></div>
        <div class="sparkle sparkle3"></div>
        <div class="sparkle sparkle4"></div>
        <div class="sparkle sparkle5"></div>
        <div class="sparkle sparkle6"></div>
        <div class="sparkle sparkle7"></div>
        <div class="sparkle sparkle8"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h2 class="text-lg font-semibold">Success</h2>
            <p>Account successfully added!</p>
        </div>
    </div>

    <!-- Edit Success Modal -->
    <div id="editSuccessModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_edit">

            <div class="sparkle sparkle01"></div>
            <div class="sparkle sparkle02"></div>
            <div class="sparkle sparkle03"></div>
            <div class="sparkle sparkle04"></div>
            <div class="sparkle sparkle05"></div>
            <div class="sparkle sparkle06"></div>
            <div class="sparkle sparkle07"></div>
            <div class="sparkle sparkle08"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Success</h2>
            <p>Account successfully updated!</p>
        </div>
    </div>

    <!-- Restore Confirmation Modal Account-->
    <div id="restoreConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn background_restore">
            <div class="flex flex-col items-center mb-4">
                
                <svg id="restore_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-green-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <h2 class="text-2xl font-bold text-green-600">Restore Account</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to restore this account.
            </p>
            <span class="second_message block text-sm text-gray-800 mb-5">This action will reactivate the account.</span>

            <div class="flex justify-center gap-4 mt-4">
                <button id="confirmRestoreBtn" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 transition">Restore</button>
                <button id="cancelRestoreBtn" class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Store Success Modal -->
    <div id="restoreSuccessModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_restore">

            <div class="sparkle sparkle001"></div>
            <div class="sparkle sparkle002"></div>
            <div class="sparkle sparkle003"></div>
            <div class="sparkle sparkle004"></div>
            <div class="sparkle sparkle005"></div>
            <div class="sparkle sparkle006"></div>
            <div class="sparkle sparkle007"></div>
            <div class="sparkle sparkle008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>

            <h2 class="text-lg font-semibold">Restored</h2>
            <p>Account successfully restore!</p>
        </div>
    </div>

    <!-- Delete Success Modal -->
    <div id="deleteSuccessModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_delete">

            <div class="sparkle sparkle0001"></div>
            <div class="sparkle sparkle0002"></div>
            <div class="sparkle sparkle0003"></div>
            <div class="sparkle sparkle0004"></div>
            <div class="sparkle sparkle0005"></div>
            <div class="sparkle sparkle0006"></div>
            <div class="sparkle sparkle0007"></div>
            <div class="sparkle sparkle0008"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Deleted</h2>
            <p>Account successfully delete!</p>
        </div>
    </div>

</x-app-layout>
