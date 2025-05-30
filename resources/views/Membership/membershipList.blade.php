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
                    <input type="text" name="type" id="membership_type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800" required>
                    <span style="color: red">
                        @error('type') {{ $message }} @enderror
                    </span>
                </div>

                <div class="mb-4">
                    <label for="membership_clubName" class="block text-sm font-medium text-gray-700 dark:text-gray-700">Club Name</label>
                    <select name="clubName" id="membership_clubName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-3 bg-white text-gray-900 dark:text-gray-800 cursor-pointer" required>
                        <option hidden selected></option>
                        <option style="color: black;" value="Science Club">Science Club</option>
                        <option style="color: black;" value="Math Society">Math Society</option>
                        <option style="color: black;" value="IT Guild">IT Guild</option>
                        <option style="color: black;" value="Debate Club">Debate Club</option>
                        <option style="color: black;" value="Cultural Dance Troupe">Cultural Dance Troupe</option>
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




</x-app-layout>
