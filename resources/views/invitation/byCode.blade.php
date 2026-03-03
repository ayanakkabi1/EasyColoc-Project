<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rejoindre une colocation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-8">
                    <div class="mb-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">
                            Code d'invitation
                        </h3>
                        <p class="text-gray-600">Entrez le code reçu par email pour rejoindre une colocation</p>
                    </div>

                    <form action="{{ route('invitation.byCode') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="token" class="block text-sm font-medium text-gray-700 mb-2">
                                Votre code d'invitation
                            </label>
                            <input 
                                type="text" 
                                id="token" 
                                name="token" 
                                required 
                                placeholder="EXEMPLE" 
                                maxlength="8"
                                class="w-full px-4 py-3 text-center uppercase border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-lg font-bold letter-spacing tracking-widest"
                                style="letter-spacing: 0.2em;"
                            />
                            @error('token')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-blue-800">
                                        <strong>Comment trouver votre code ?</strong> Cherchez le code d'invitation dans l'email reçu de votre colocation.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button 
                                type="submit" 
                                class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Vérifier le code
                            </button>

                            <a 
                                href="{{ route('dashboard') }}" 
                                class="flex-1 bg-gray-300 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
