<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Créer une colocation</h2>
                    <p class="text-gray-500 text-sm">Donnez un nom à votre colocation pour commencer.</p>
                </div>

                <form action="{{ route('Colocation.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom de la colocation</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               placeholder="Ex: Coloc République"
                               class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">
                            Annuler
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition transform active:scale-95">
                            Créer la colocation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>