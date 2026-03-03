<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Invitation extends model{
    protected $fillable = [
        'colocation_id',
        'email',
        'token',
        'type',
        'expires_at',
        'used_at'
    ];
}