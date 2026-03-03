<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détail de la dépense : ') }} {{ $expense->title }}
            </h2>
            <a href="{{ route('expenses.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                &larr; Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="border-b pb-6 mb-6 flex justify-between items-start">
                        <div>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase">
                                {{ $expense->category }}
                            </span>
                            <h1 class="text-3xl font-extrabold text-gray-900 mt-2">{{ number_format($expense->amount, 2) }} €</h1>
                            <p class="text-gray-500">Payé le {{ $expense->spent_at->format('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Acheteur</p>
                            <p class="font-bold text-gray-800">{{ $expense->user->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Description</h4>
                            <p class="mt-2 text-gray-700 leading-relaxed">
                                {{ $expense->description ?: 'Aucune description fournie pour cette dépense.' }}
                            </p>
                        </div>

                        @if(Auth::id() === $expense->user_id)
                        <div class="pt-6 border-t flex gap-4">
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Es-tu sûr de vouloir supprimer cette dépense ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-bold uppercase">
                                    Supprimer la dépense
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>