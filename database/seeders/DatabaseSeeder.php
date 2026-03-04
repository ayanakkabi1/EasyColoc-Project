<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer 10 users avec leur propre colocation
        for ($i = 1; $i <= 10; $i++) {
            $user = User::factory()->create([
                'name' => "User $i",
                'email' => "user$i@example.com",
            ]);

            // Créer une colocation pour ce user
            $colocation = Colocation::create([
                'name' => "Colocation $i",
                'statut' => 'active',
                'owner_id' => $user->id,
            ]);

            // Attacher le user à sa colocation en tant qu'owner
            $user->colocations()->attach($colocation->id, [
                'role' => 'owner',
            ]);

            // Créer quelques dépenses pour cette colocation
            for ($j = 1; $j <= rand(3, 6); $j++) {
                Expense::create([
                    'titre_expense' => fake()->randomElement(['Courses', 'Loyer', 'Électricité', 'Internet', 'Eau']),
                    'montant_expense' => fake()->randomFloat(2, 10, 200),
                    'date' => fake()->dateTimeBetween('-1 month', 'now'),
                    'category' => fake()->randomElement(['Courses', 'Loyer', 'Hygiène', 'Autre']),
                    'description' => fake()->sentence(),
                    'user_id' => $user->id,
                    'colocation_id' => $colocation->id,
                    'is_paid' => fake()->boolean(70),
                    'paid_at' => fake()->boolean(70) ? now() : null,
                ]);
            }
        }
    }
}
