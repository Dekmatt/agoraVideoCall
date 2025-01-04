<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> <!-- Link to your sidebar CSS -->

    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar bg-gray-200 w-64 h-screen p-4">
            <h3 class="font-semibold text-lg">Menu</h3>
            <ul class="mt-4">
                <li><a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-300 rounded">Dashboard</a></li>
                <li><a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-300 rounded">Profile</a></li>
                <li><a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-300 rounded">Settings</a></li>
                <li><a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-300 rounded">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 p-6 ml-64">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
