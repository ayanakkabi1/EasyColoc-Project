<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-white border-r">
    <div class="flex items-center px-2">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <svg class="w-8 h-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span class="mx-2 text-2xl font-bold text-indigo-900">EasyColoc</span>
        </a>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full flex items-center px-4 py-3 rounded-lg border-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                <span class="mx-4 font-medium">Dashboard</span>
            </x-nav-link>

            <x-nav-link :href="route('colocation.show')" :active="request()->routeIs('coloc.show')" class="w-full flex items-center px-4 py-3 mt-2 rounded-lg border-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
                <span class="mx-4 font-medium">Colocations</span>
            </x-nav-link>

            <div class="px-4 mt-6">
                <span class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Admin</span>
            </div>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="w-full flex items-center px-4 py-3 mt-2 rounded-lg border-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="mx-4 font-medium">Profile</span>
            </x-nav-link>
        </nav>

        <div class="mt-auto px-2">
            <div class="p-4 bg-gray-900 rounded-2xl">
                <h2 class="text-[10px] font-semibold text-gray-400 uppercase">Votre Réputation</h2>
                <p class="mt-1 text-xl font-bold text-white">+0 points</p>
                <div class="w-full h-1.5 mt-3 bg-gray-700 rounded-full">
                    <div class="w-1/3 h-full bg-green-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</aside>