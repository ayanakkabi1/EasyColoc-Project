<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <x-flash-messages />
        <div class="flex h-screen bg-gray-100">
            @include('layouts.navigation')

            <div class="flex flex-col flex-1 overflow-hidden">
                
                <header class="flex items-center justify-between px-8 py-4 bg-white border-b">
                    <div class="flex items-center space-x-4">
                        <h2 class="text-xl font-bold text-gray-800 uppercase tracking-tighter italic">Tableau de bord</h2>
                        
                        <a href="{{ route('colocation.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition">
                            + Nouvelle colocation
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex flex-col text-right">
                            <span class="text-[10px] font-bold text-green-500 uppercase">Admin</span>
                            <span class="text-[10px] text-gray-400 uppercase">En ligne</span>
                        </div>
                        
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center justify-center w-10 h-10 bg-indigo-900 text-white rounded-xl font-bold uppercase transition hover:opacity-90">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>