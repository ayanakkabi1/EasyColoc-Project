<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id('id_expenses');
            $table->string('titre_expense');  
        $table->decimal('montant_expense', 10, 2); 
        $table->date('date'); 
        $table->string('category')->nullable(); 
        
        $table->foreignId('colocation_id')->constrained()->onDelete('cascade');
        

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->text('description')->nullable(); 
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
