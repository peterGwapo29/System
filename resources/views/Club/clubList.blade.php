<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Club') }}
        </h2>
        <link rel="stylesheet" href="{{ asset('CSS/club.css') }}">
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-4" style="margin-bottom: -24px;">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out"
                    id="addClubutton">
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

    


    <!-- Scripts at the bottom -->
    <script src="{{ asset('js/club/deleteClub.js') }}"></script>
    <script src="{{ asset('js/club/restoreClub.js') }}"></script>
</x-app-layout>
