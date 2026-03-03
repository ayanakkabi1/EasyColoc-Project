<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ma Colocation') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($myColoc)
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900"> {{ $myColoc->name }}</h3>
                        <span class="px-3 py-1 text-sm font-semibold text-indigo-700 bg-indigo-100 rounded-full">
                            {{ ucfirst($myColoc->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-3 border-bottom">Informations</h4>
                            <p class="text-gray-600"><strong>Créée le :</strong> {{ $myColoc->created_at->format('d/m/Y') }}</p>
                            <p class="text-gray-600"><strong>Administrateur :</strong>
                                <span class="text-indigo-600 font-medium">{{ $myColoc->owner->name ?? 'Non défini' }}</span>
                            </p>
                        </div>
                        @if($myColoc->users->isNotEmpty())
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-700 mb-3">👥 Membres du groupe</h4>
                            <ul class="divide-y divide-gray-200">
                                @foreach($myColoc->users as $member)
                                <li class="py-3 flex justify-between items-center">
                                    <span class="text-gray-800">{{ $member->name }}</span>
                                    <span class="text-xs px-2 py-1 bg-gray-200 text-gray-600 rounded uppercase tracking-wider">
                                        {{ $member->pivot->role ?? 'Membre' }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>Aucun membre dans cette colocation.</p>
                        @endif
                        </div>
                    </div>

                    
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                <div class="flex justify-center mb-4 text-gray-300">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Vous n'avez pas encore de colocation</h3>
                <p class="text-gray-500 mt-2">Créez votre groupe ou rejoignez vos amis pour commencer.</p>
                <div class="mt-6">
                    <a href="{{ route('colocation.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                        Créer une colocation
                    </a>
                </div>
            </div>

            @endif
        </div>
    </div>
    <form action="{{ route('invitation.send',$myColoc->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm border">
    @csrf
    <h3 class="text-lg font-bold mb-4">Inviter un colocataire</h3>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="flex space-x-3">
        <button type="submit" name="method" value="mail" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Envoyer par Mail
        </button>

        <button type="submit" name="method" value="token" class="flex-1 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Générer un Code
        </button>
    </div>
</form>
</x-app-layout>