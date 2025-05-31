<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Membership') }}
        </h2>
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
        
    <!-- Edit Membership Modal -->
    <div id="editMShipModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="modal-content bg-white rounded-lg shadow-lg w-96 p-6 relative animate-scaleIn">
            <h2 class="text-xl font-semibold mb-4">Update Membership <span id="mShip_membershipId"></span></h2>

            <form id="editMShipForm">
                <div class="mb-3">
                    <input type="hidden" id="mShip_membershipIdInput" name="membership_id" class="w-full border rounded px-3 py-2" readonly />
                </div>

                <div class="mb-3">
                    <label for="mShip_studentId" class="block font-medium mb-1">Student ID</label>
                    <input type="text" id="mShip_studentId" name="student_id" class="w-full border rounded px-3 py-2" required />
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

</x-app-layout>
