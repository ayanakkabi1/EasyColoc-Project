<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la dépense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('expenses.update', $expense) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="title" :value="__('Titre / Objet')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $expense->titre_expense)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="amount" :value="__('Montant (€)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount', $expense->montant_expense)" required />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="spent_at" :value="__('Date')" />
                                <x-text-input id="spent_at" class="block mt-1 w-full" type="date" name="spent_at" :value="old('spent_at', optional($expense->date)->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('spent_at')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Catégorie')" />
                            <select name="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="Courses" @selected(old('category', $expense->category) === 'Courses')>Courses alimentaire</option>
                                <option value="Loyer" @selected(old('category', $expense->category) === 'Loyer')>Loyer & Charges</option>
                                <option value="Hygiène" @selected(old('category', $expense->category) === 'Hygiène')>Hygiène & Entretien</option>
                                <option value="Autre" @selected(old('category', $expense->category) === 'Autre')>Autre</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description (optionnel)')" />
                            <textarea name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('description', $expense->description) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('expenses.index') }}">
                                {{ __('Annuler') }}
                            </a>

                            <x-primary-button class="ml-4">
                                {{ __('Mettre à jour') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
