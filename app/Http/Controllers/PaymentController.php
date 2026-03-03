<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $coloc = $user->activeColocation();

        Expense::create([
            'title' => 'Remboursement de dettes',
            'amount' => $request->amount,
            'spent_at' => now(),
            'category' => 'Remboursement',
            'user_id' => $user->id,
            'colocation_id' => $coloc->id,
            'description' => 'Paiement effectué pour équilibrer le solde.',
        ]);

       

        return back()->with('success', 'Paiement enregistré ! Votre solde a été mis à jour.');
    }
}
