<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8">
                
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Ajouter une dépense</h2>
                    <p class="text-gray-500 text-sm">Remplissez les détails pour partager les frais avec la colocation.</p>
                </div>

                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="titre_expense" class="block text-sm font-semibold text-gray-700 mb-2">Objet de la dépense</label>
                            <input type="text" name="titre_expense" id="titre_expense" 
                                   placeholder="Ex: Courses hebdomadaires, Facture EDF..."
                                   class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                            @error('titre_expense') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="montant_expense" class="block text-sm font-semibold text-gray-700 mb-2">Montant (€)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="montant_expense" id="montant_expense" 
                                       class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pl-8" 
                                       placeholder="0.00" required>
                                <span class="absolute left-3 top-2.5 text-gray-400">€</span>
                            </div>
                            @error('montant_expense') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Date d'achat</label>
                            <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}"
                                   class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                            <select name="category" id="category" 
                                    class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="Courses">🛒 Courses</option>
                                <option value="Loyer">🏠 Loyer & Charges</option>
                                <option value="Énergie">⚡ Énergie</option>
                                <option value="Internet">🌐 Internet</option>
                                <option value="Divers">✨ Divers</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description (Optionnel)</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                      placeholder="Précisez ce qui a été acheté..."></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition transform active:scale-95">
                            Enregistrer la dépense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>