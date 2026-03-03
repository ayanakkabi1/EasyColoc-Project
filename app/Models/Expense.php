<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
   use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'spent_at',
        'category',
        'colocation_id',
        'user_id',
        'description',
    ];


    protected $casts = [
        'spent_at' => 'date',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
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
        $member->total_paid = $expenses->where('user_id', $member->id)->sum('amount');
        $member->balance = $member->total_paid - $share;
        return $member;
    });
}
}
