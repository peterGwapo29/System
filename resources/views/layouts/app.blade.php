<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css" rel="stylesheet" />
        <link href="{{asset('css/accountStyle.css')}}" rel="stylesheet" />
        <link href="{{asset('css/edit.css')}}" rel="stylesheet" />
        <link href="{{asset('css/student.css')}}" rel="stylesheet" />
        <link href="{{asset('css/mship.css')}}" rel="stylesheet" />
        <link href="{{asset('css/reg.css')}}" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="{{asset('JS/account/addAccount.js')}}"></script>
        <script src="{{asset('JS/account/deleteAccount.js')}}"></script>
        <script src="{{asset('JS/account/restoreAccount.js')}}"></script>
        
        <script src="{{asset('JS/student/restoreStudent.js')}}"></script>
        <script src="{{asset('JS/student/addStudent.js')}}"></script>
        <script src="{{asset('JS/student/deleteStudent.js')}}"></script>
        
        <script src="{{asset('JS/membership/addMship.js')}}"></script>
        <script src="{{asset('JS/membership/editMship.js')}}"></script>
        
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
        <script src="{{asset('JS/account/custom.js')}}"></script>
        <script src="{{asset('JS/student/student.js')}}"></script>
        <script src="{{asset('JS/membership/mship.js')}}"></script>
        <script src="{{asset('JS/club/viewClub.js')}}"></script>
        <script src="{{ asset('js/club/editClub.js') }}"></script>

        <script src="{{ asset('js/event/eventView.js') }}"></script>
        <script src="{{ asset('JS/event/eventEdit.js') }}"></script>
        <script src="{{ asset('JS/event/restoreEvent.js') }}"></script>
        <script src="{{ asset('JS/event/eventAdd.js') }}"></script>
        <script src="{{ asset('JS/event/deleteEvent.js') }}"></script>

        <script src="{{ asset('JS/event_reg/eventRegistration.js') }}"></script>


        @push('scripts')
    <script src="{{ asset('JS/event/eventView.js') }}"></script>
    <script src="{{ asset('JS/event/restoreEvent.js') }}"></script>
    @endpush
    </body>
</html>
