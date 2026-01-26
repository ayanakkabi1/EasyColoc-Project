<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmation d\'invitation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-8">
                    <div class="mb-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m5.506-1.141c2.726-1.889 4.501-4.754 4.501-8.43M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $colocation->name }}
                        </h3>
                        <p class="text-gray-600">Vous avez été invité à rejoindre cette colocation</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Informations sur la colocation</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Créée le</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $colocation->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Membres</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $colocation->users->count() }} personne{{ $colocation->users->count() > 1 ? 's' : '' }}
                                </p>
                            </div>
                        </div>

                        @if($colocation->users->isNotEmpty())
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Membres actuels</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($colocation->users as $member)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-700">
                                            {{ $member->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-800">
                                    <strong>Attention :</strong> Cette invitation est valide pour 48 heures.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <form action="{{ route('invitation.accept') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="token" value="{{ $invitation->token }}">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Accepter l'invitation
                            </button>
                        </form>

                        <a href="{{ route('invitation.decline', $invitation->token) }}" class="flex-1 bg-gray-300 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Refuser
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
