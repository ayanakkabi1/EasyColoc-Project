<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-purple-600">
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-purple-800"> Créer une nouvelle colocation</h2>
                        <p class="text-gray-600">Remplissez les informations pour trouver vos futurs colocataires.</p>
                    </div>

                    <form action="{{ route('Colocation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('nom de Colocation')" class="text-purple-700 font-semibold" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-purple-200 focus:ring-purple-500 focus:border-purple-500" placeholder="Ex: Bel appartement centre-ville" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                            <x-primary-button class="bg-purple-600 hover:bg-purple-700 px-6 py-3 text-lg">
                                {{ __('Publier Colocation') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            if (fileName) {
                document.getElementById('file-name').textContent = "Fichier choisi : " + fileName;
            }
        }
    </script>
</x-app-layout>