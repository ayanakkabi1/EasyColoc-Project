<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        
        $coloc = $user->activecolocation();

        
        if (!$coloc) {
            return view('dashboard', [
                'hasColoc' => false,
                'reputation' => $user->reputation ?? 0
            ]);
        }

        
        $recentExpenses = $coloc->expenses()
            ->with('user')
            ->latest('date')
            ->take(5)
            ->get();


        $totalMonth = $coloc->expenses()
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('montant_expense');
    
        
        $userPaid = $coloc->expenses()
            ->where('user_id', $user->id)
            ->sum('montant_expense');
            
        
        $totalAllTime = $coloc->expenses()->sum('montant_expense');
        $memberCount = $coloc->users()->count();
        $theoreticalShare = $memberCount > 0 ? ($totalAllTime / $memberCount) : 0;
        
        
        $balance = $userPaid - $theoreticalShare;

        return view('dashboard', [
            'hasColoc' => true,
            'coloc' => $coloc,
            'expenses' => $recentExpenses,
            'totalMonth' => $totalMonth,
            'balance' => $balance,
            'reputation' => $user->reputation ?? 0
        ]);
    }
}