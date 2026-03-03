<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(!$hasColoc)
                <div class="bg-white p-12 text-center rounded-2xl shadow-sm">
                    <h2 class="text-2xl font-bold mb-4">Bienvenue, {{ auth()->user()->name }} !</h2>
                    <p class="text-gray-500 mb-8">Vous ne faites partie d'aucune colocation pour le moment.</p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('colocation.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold">Créer une coloc</a>
                        <a href="{{ route('invitation.codeForm') }}" class="border border-gray-300 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition">Rejoindre via un code</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <a href="{{ route('expenses.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border-b-4 {{ $balance >= 0 ? 'border-green-500' : 'border-red-500' }} hover:shadow-md transition cursor-pointer">
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Mon Solde</p>
                        <h3 class="text-3xl font-black mt-2 {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($balance, 2) }} €
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $balance >= 0 ? 'On vous doit de l\'argent' : 'Vous devez rembourser' }}</p>
                        <p class="text-xs text-indigo-600 font-bold mt-3">Voir les détails →</p>
                    </a>

                    <a href="{{ route('expenses.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-indigo-500 hover:shadow-md transition cursor-pointer">
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Total {{ now()->translatedFormat('F') }}</p>
                        <h3 class="text-3xl font-black mt-2 text-gray-800">{{ number_format($totalMonth, 2) }} €</h3>
                        <p class="text-xs text-gray-400 mt-1">Dépensés par toute la coloc</p>
                        <p class="text-xs text-indigo-600 font-bold mt-3">Voir toutes les dépenses →</p>
                    </a>

                    <a href="{{ route('colocation.show') }}" class="bg-gray-900 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden hover:shadow-xl transition cursor-pointer">
                        <p class="text-sm text-gray-400 uppercase font-bold tracking-wider">Ma Réputation</p>
                        <div class="flex items-center gap-4 mt-2">
                            <h3 class="text-4xl font-black text-yellow-400">{{ $reputation }}</h3>
                            <div class="text-xs text-gray-400">Score de confiance<br>entre colocataires</div>
                        </div>
                        <p class="text-xs text-yellow-400 font-bold mt-3">Voir mon profil →</p>
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                    </a>

                </div>

                <div class="mt-8 bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg">Dernières dépenses</h3>
                        <a href="{{ route('expenses.index') }}" class="text-indigo-600 text-sm font-bold">Voir tout →</a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($expenses as $expense)
                            <div class="flex justify-between items-center p-4 hover:bg-gray-50 rounded-xl transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold">
                                        {{ substr($expense->category, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $expense->title }}</p>
                                        <p class="text-xs text-gray-500">Payé par {{ $expense->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">{{ number_format($expense->amount, 2) }} €</p>
                                    <p class="text-xs text-gray-400">{{ $expense->date?->diffForHumans() ?? 'Date non renseignée' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>