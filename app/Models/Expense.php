<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
   use HasFactory;
   protected $casts = [
        'date' => 'date',
        'paid_at' => 'datetime',
        'is_paid' => 'boolean',
    ];
    protected $primaryKey = 'id_expenses';
    protected $fillable = [
        'titre_expense',
        'montant_expense',
        'date',
        'category',
        'colocation_id',
        'user_id',
        'description',
        'is_paid',
        'paid_at',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
  


public function getIndividualShare()
{
    $count = $this->users()->count();
    return $count > 0 ? $this->getTotalExpenses() / $count : 0;
}

public function getMembersWithBalances($expenses, $share)
{
    return $this->users->map(function ($member) use ($expenses, $share) {
        $member->total_paid = $expenses->where('user_id', $member->id)->sum('montant_expense');
        $member->balance = $member->total_paid - $share;
        return $member;
    });
}
}
