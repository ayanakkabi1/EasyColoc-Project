<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = ['name', 'statut', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function getExpensesByMonth($month, $year)
    {
        return $this->expenses()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('user')
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getTotalExpenses()
    {
        return $this->expenses()->sum('montant_expense');
    }
    public function getStatsByCategory($expenses)
    {
        return $expenses->groupBy('category')->map(function ($items) {
            return $items->sum('montant_expense');
        });
    }
    public function getIndividualShare()
    {
        $count = $this->users()->count();
        return $count > 0 ? $this->getTotalExpenses() / $count : 0;
    }
    public function getMembersWithBalances()
    {
        $share = $this->getIndividualShare();
        $allExpenses = $this->expenses; // Récupère toutes les dépenses du groupe

        return $this->users->map(function ($member) use ($allExpenses, $share) {
             
            $member->total_paid = $allExpenses->where('user_id', $member->id)->sum('montant_expense');
            
            
            $member->balance = $member->total_paid - $share;
            
            return $member;
        });
    }
}
