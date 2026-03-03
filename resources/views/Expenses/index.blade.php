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
                        <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">Soldes</h3>
                        <div class="space-y-4">
                            @foreach($members as $member)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">{{ $member->name }}</span>
                                    <span class="px-2 py-1 rounded-full text-sm font-bold {{ $member->balance >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $member->balance >= 0 ? '+' : '' }}{{ number_format($member->balance, 2) }} €
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <h3 class="font-bold text-lg mt-8 mb-4 text-gray-700 border-b pb-2">Remboursements</h3>
                        <div class="space-y-2">
                            @forelse($settlements as $settlement)
                                <div class="p-3 bg-indigo-50 rounded-lg text-sm text-indigo-700 border border-indigo-100">
                                    <span class="font-bold">{{ $settlement['from'] }}</span> ➔ <span class="font-bold">{{ $settlement['to'] }}</span>
                                    <div class="text-lg font-black mt-1">{{ number_format($settlement['amount'], 2) }} €</div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">Tout est équilibré !</p>
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
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($expenses as $expense)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->spent_at->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 font-semibold">{{ $expense->title }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-7 w-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs mr-2 font-bold uppercase">
                                                        {{ substr($expense->user->name, 0, 2) }}
                                                    </div>
                                                    {{ $expense->user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-900">{{ number_format($expense->amount, 2) }} €</td>
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