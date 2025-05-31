<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Membership') }}
        </h2>
        <link rel="stylesheet" href="{{ asset('CSS/membership.css') }}">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-4" style="margin-bottom: -24px;">
                <button
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out" id="addMembershipButton">
                    + Add Membership
                </button>

                <select name="filterStatusMembership" id="filterStatusMembership" class="cursor-pointer inline-block text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

            </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="table-auto w-full border-collapse" id="membershipTable"></table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Membership -->
    <div id="membershipModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <div class="relative rounded-lg shadow-xl p-6 backgroundModalMembership">

            <div id="membershipErrorBox" class="text-red-600 text-sm hidden mb-2"></div>

            <button id="closeModalMembership" class="absolute top-0 right-0 m-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-700">Create Membership</h2>

            <form id="addMembershipForm" action="insertMembership" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="membership_student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Student ID</label>
                    <input type="number" name="student_id" id="membership_student_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800" required>
                    <span style="color: red">
                        @error('student_id') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-4">
                    <label for="membership_type" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Membership Type</label>
                    <select name="membership_type" id="membership_type"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800 cursor-pointer"
                        required
                        size="1" onfocus="this.size=5" onblur="this.size=1" onchange="this.size=1">
                        <option hidden selected></option>
                        @foreach ($membershipTypes as $type)
                            <option style="color: black;" value="{{ $type->type_name }}">{{ $type->type_name }}</option>
                        @endforeach
                    </select>
                    <span style="color: red">
                        @error('membership_type') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-4">
                    <label for="membership_clubName" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Club Name</label>
                    <select name="club_name" id="membership_clubName"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800 cursor-pointer"
                        required
                        size="1" onfocus="this.size=5" onblur="this.size=1" onchange="this.size=1">
                        <option hidden selected></option>
                        @foreach ($clubName as $cname)
                            <option style="color: black;" value="{{ $cname->club_name }}">{{ $cname->club_name }}</option>
                        @endforeach
                    </select>

                    <span style="color: red">
                        @error('clubName') {{ $message }} @enderror
                    </span>
                </div>


                <div class="flex justify-end">
                    <button id="submitMembershipBtn" type="submit" class="bg-blue-600 hover:bg-blue-700 text-gray-700 font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                        Add Membership
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Membership Modal -->
    <div id="editMShipModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
            <h2 class="text-xl font-semibold mb-4">Update Membership <span id="mShip_membershipId"></span></h2>

            <div id="mShip_errorBox" class="hidden mb-4 p-3 bg-red-100 text-red-700 border border-red-400 rounded"></div>
            <form id="editMShipForm">
                <div class="mb-3">
                    <input type="hidden" id="mShip_membershipIdInput" name="membership_id" class="w-full border rounded px-3 py-2" readonly />
                </div>

                <div class="mb-3">
                    <label for="mShip_studentId" class="block font-medium mb-1">Student ID</label>
                    <input type="number" id="mShip_studentId" name="student_id" class="w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-3">
                    <label for="mShip_membershipType" class="block font-medium mb-1">Membership Type</label>
                    <select id="mShip_membershipType" name="membership_type" class="w-full border rounded px-3 py-2 cursor-pointer" required
                        size="1" onfocus="this.size=5" onblur="this.size=1" onchange="this.size=1">
                        <option hidden selected></option>
                        @foreach ($membershipTypes as $type)
                            <option value="{{ $type->type_name }}">{{ $type->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mShip_clubName" class="block font-medium mb-1">Club Name</label>
                    <select id="mShip_clubName" name="club_name" class="w-full border rounded px-3 py-2 cursor-pointer" required
                        size="1" onfocus="this.size=5" onblur="this.size=1" onchange="this.size=1">
                        <option hidden selected></option>
                        @foreach ($clubName as $cname)
                            <option value="{{ $cname->club_name }}">{{ $cname->club_name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="flex justify-end gap-3">
                    <button type="button" id="mShip_closeModalBtn">Cancel</button>
                    <button type="submit" id="mShip_updateSubmit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Membership success closeModal -->
    <div id="addSuccessModalMship" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_add_mship">

            <div class="sparkle m1"></div>
            <div class="sparkle m2"></div>
            <div class="sparkle m3"></div>
            <div class="sparkle m4"></div>
            <div class="sparkle m5"></div>
            <div class="sparkle m6"></div>
            <div class="sparkle m7"></div>
            <div class="sparkle m8"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Success</h2>
            <p>Student successfully added!</p>
        </div>
    </div>

    <!-- Edit Membership success closeModal -->
    <div id="editSuccessModalMship" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_edit_mship">

            <div class="sparkle m01"></div>
            <div class="sparkle m02"></div>
            <div class="sparkle m03"></div>
            <div class="sparkle m04"></div>
            <div class="sparkle m05"></div>
            <div class="sparkle m06"></div>
            <div class="sparkle m07"></div>
            <div class="sparkle m08"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>


            <h2 class="text-lg font-semibold">Success</h2>
            <p>Student successfully added!</p>
        </div>
    </div>

    <!-- Modal for Membership Deletion Confirmation -->
    <div id="membershipDLTConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn membershipDLT-background">
            
            <div class="flex flex-col items-center mb-4">
                <svg id="membershipDLT_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-[60px] w-[60px] text-red-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <h2 class="text-2xl font-bold text-red-600">Membership Deletion Required</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to deactivate this membership.
            </p>
            <span class="membershipDLT-message block text-sm text-gray-800 mb-5">This action can be undone later by restoring the membership.</span>

            <div class="flex justify-center gap-4">
                <button id="membershipDLTConfirmBtn"
                    class="bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition">Delete</button>
                <button id="membershipDLTCancelBtn"
                    class="bg-white text-gray-800 px-4 py-2 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Modal for Successful Delete -->
    <div id="membershipDeleteModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="content_success_delete">
            <div class="sparkle m1"></div>
            <div class="sparkle m2"></div>
            <div class="sparkle m3"></div>
            <div class="sparkle m4"></div>
            <div class="sparkle m5"></div>
            <div class="sparkle m6"></div>
            <div class="sparkle m7"></div>
            <div class="sparkle m8"></div>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <h2 class="text-lg font-semibold">Deactivated</h2>
            <p>Membership successfully deactivated!</p>
        </div>
    </div>

    <!-- Restore Confirmation Modal -->
    <div id="restoreConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-[700px] text-center animate-scaleIn background_restore">
            <div class="flex flex-col items-center mb-4">
                
                <svg id="restore_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[60px] w-[60px] text-green-600 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <h2 class="text-2xl font-bold text-green-600">Restore Membership</h2>
            </div>

            <p class="text-gray-800 mb-1">
                You're about to restore this membership.
            </p>
            <span class="second_message block text-sm text-gray-800 mb-5">This action will reactivate the membership.</span>

            <div class="flex justify-center gap-4 mt-4">
                <button id="confirmRestoreBtn" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 transition">Restore</button>
                <button id="cancelRestoreBtn" class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400 transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Restore Success Modal -->
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
            <p>Membership successfully restored!</p>
        </div>
    </div>

</x-app-layout>

<script src="{{asset('JS/membership/deleteMship.js')}}"></script>
<script src="{{asset('JS/membership/restoreMship.js')}}"></script>
