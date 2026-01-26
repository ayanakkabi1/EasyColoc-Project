<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dépenses de la Coloc : ') }} {{ $coloc->name }}
            </h2>
            <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Ajouter une dépense
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-indigo-500">
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total des dépenses</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalAmount, 2) }} €</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-emerald-500">
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider">Part par membre</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($share, 2) }} €</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">💰 Détail par personne</h3>
                        <div class="space-y-4">
                            @foreach($members as $member)
                                <div class="bg-gray-50 p-4 rounded-lg border-l-4 {{ $member->balance >= 0 ? 'border-green-500' : 'border-red-500' }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-bold text-gray-800">{{ $member->name }}</span>
                                        <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">{{ number_format($member->balance, 2) }} €</span>
                                    </div>
                                    <div class="text-xs text-gray-600 space-y-1">
                                        <div class="flex justify-between">
                                            <span>Montant payé:</span>
                                            <span class="font-semibold text-indigo-600">{{ number_format($member->total_paid ?? 0, 2) }} €</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Part individuelle:</span>
                                            <span class="font-semibold">{{ number_format($share, 2) }} €</span>
                                        </div>
                                        <div class="flex justify-between pt-1 border-t border-gray-200">
                                            <span class="font-bold">Solde:</span>
                                            <span class="font-black {{ $member->balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $member->balance >= 0 ? '+' : '' }}{{ number_format($member->balance, 2) }} €
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <h3 class="font-bold text-lg mt-8 mb-4 text-gray-700 border-b pb-2">🔄 Qui doit à qui</h3>
                        <div class="space-y-3">
                            @forelse($settlements as $settlement)
                                <div class="p-4 bg-gradient-to-r from-orange-50 to-amber-50 rounded-lg border border-orange-200">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-200 text-orange-700 text-xs font-bold">
                                                {{ substr($settlement['from'], 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="text-sm font-bold text-gray-800">
                                                <span class="text-orange-700">{{ $settlement['from'] }}</span> doit payer à <span class="text-orange-700">{{ $settlement['to'] }}</span>
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="text-lg font-black text-orange-700">
                                                {{ number_format($settlement['amount'], 2) }} €
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 bg-green-50 rounded-lg border border-green-200 text-center">
                                    <p class="text-green-700 font-semibold">✓ Tout est équilibré !</p>
                                    <p class="text-xs text-green-600 mt-1">Aucun remboursement à effectuer</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 font-bold text-lg border-b border-gray-100">
                            Dernières dépenses
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                                    <tr>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4">Titre</th>
                                        <th class="px-6 py-4">Payeur</th>
                                        <th class="px-6 py-4 text-right">Montant</th>
                                        <th class="px-6 py-4 text-center">Statut</th>
                                        <th class="px-6 py-4 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($expenses as $expense)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->date->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 font-semibold">{{ $expense->titre_expense }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-7 w-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs mr-2 font-bold uppercase">
                                                        {{ substr($expense->user->name, 0, 2) }}
                                                    </div>
                                                    {{ $expense->user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-900">{{ number_format($expense->montant_expense, 2) }} €</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $expense->is_paid ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                    {{ $expense->is_paid ? '✓ Payée' : 'En attente' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('expenses.markAsPaid', $expense->id_expenses) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-700 transition-colors">
                                                        {{ $expense->is_paid ? '↶ Annuler' : '✓ Marquer payée' }}
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
        </div>
    </div>
</x-app-layout>