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
                    <table class="table-auto w-full border-collapse" id="accountTable">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-sm text-left">
                            <tr>
                                <th class="px-4 py-2">Account ID</th>
                                <th class="px-4 py-2">Student ID</th>
                                <th class="px-4 py-2">Username</th>
                                <th class="px-4 py-2">Password</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Created At</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr class="border-t border-gray-200 dark:border-gray-600 text-sm">
                                    <td class="px-4 py-2">{{ $account->account_id }}</td>
                                    <td class="px-4 py-2">{{ $account->student_id }}</td>
                                    <td class="px-4 py-2">{{ $account->username }}</td>
                                    <td class="px-4 py-2">
                                        {{ Str::limit($account->password, 15, '...') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $account->email }}</td>
                                    <td class="px-4 py-2">{{ $account->created_at }}</td>
                                    <td class="px-4 py-2">{{ $account->account_status }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('accounts.destroy', $account->account_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this account?')"
                                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded shadow-md transition duration-200 ease-in-out"
                                                id="deleteAccountButton">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <button type="button"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded shadow-md transition duration-200 ease-in-out mr-2"
                                                id="editAccountButton">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                        </form>
                                    </td>
                                    

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

                @if(Session::has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ Session::get('success') }}</span>
                    </div>
                @endif

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
                        <input type="text" name="student_id" id="student_id" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" value="{{old('student_id')}}" required>
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
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-gray-700 font-semibold py-2 px-4 rounded shadow-md transition duration-200 ease-in-out">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>


</x-app-layout>
