<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Colocation extends Model
{
    protected $fillable = ['name','statut','owner_id'];
    
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }
    public function users(){
        return $this->belongsToMany(User::class)
                ->withPivot('role')
                ->withTimestamps();
    }
}
?>