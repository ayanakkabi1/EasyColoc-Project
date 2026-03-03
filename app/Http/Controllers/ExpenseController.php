<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $coloc = $user->activecolocation(); 

        if (!$coloc) {
            return redirect()->route('dashboard')->with('error', 'Rejoignez une colocation.');
        }

        $expenses = $coloc->expenses()->with('user')->orderBy('date', 'desc')->get();
        $totalAmount = $coloc->getTotalExpenses(); 
        $share = $coloc->getIndividualShare();
        $members = $coloc->getMembersWithBalances();
        $settlements = $this->calculateSettlements($members);

        
        return view('expenses.index', compact('expenses', 'coloc', 'totalAmount', 'share', 'members', 'settlements'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function show(Expense $expense)
    {
        $expense->load('user'); 
        return view('expenses.show', compact('expense'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'spent_at' => 'required|date',
            'category' => 'nullable|string',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $coloc = $user->activecolocation();

        if (!$coloc) {
            return back()->with('error', 'Action impossible sans colocation active.');
        }
        
        Expense::create([
            'titre_expense' => $request->title,
            'montant_expense' => $request->amount,
            'date' => $request->spent_at,
            'category' => $request->category,
            'description' => $request->description,
            'user_id' => $user->id,
            'colocation_id' => $coloc->id,
        ]);
        
        return redirect()->route('expenses.index')->with('success', 'Dépense ajoutée !');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer cette dépense.');
        }

        $expense->delete();
        return back()->with('success', 'Dépense supprimée.');
    }

    public function markAsPaid(Expense $expense)
    {
        $expense->update([
            'is_paid' => !$expense->is_paid,
            'paid_at' => $expense->is_paid ? null : now(),
        ]);

        $status = $expense->is_paid ? 'non payée' : 'payée';
        return back()->with('success', "Dépense marquée comme {$status}.");
    }

    private function calculateSettlements($members)
    {
        $settlements = [];
        $debtors = $members->filter(fn($m) => $m->balance < -0.01)->sortBy('balance');
        $creditors = $members->filter(fn($m) => $m->balance > 0.01)->sortByDesc('balance');

        foreach ($debtors as $debtor) {
            $amountOwed = abs($debtor->balance);

            foreach ($creditors as $creditor) {
                if ($amountOwed <= 0) break;
                if ($creditor->balance <= 0) continue;

                $payment = min($amountOwed, $creditor->balance);
                
                $settlements[] = [
                    'from' => $debtor->name,
                    'to' => $creditor->name,
                    'amount' => $payment
                ];

                $amountOwed -= $payment;
                $creditor->balance -= $payment;
            }
        }
        return $settlements;
    }
}