<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Requests\ColocationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
   public function afficherColocation()
   {
      /** @var \App\Models\User $user */
    $user = Auth::user();
    $colocactuelle=$user->activecolocation();
    return view('Colocation.dashboard', ['myColoc' =>$colocactuelle]);
   }

   public function CreateColocation()
   {
      return view('Colocation.create');
   }

   public function StoreColocation(ColocationRequest $request)
   {
      $validated = $request->validated();
      /** @var \App\Models\User $user */
      $user = Auth::user();
      $currentColoc = $user->activeColocation();
      /** @var \App\Models\Colocation $currentColoc */
      if ($currentColoc) {
         return redirect()->back()->with('error', "Déjà membre de : " . $currentColoc->name);
      }
      $colocation = Colocation::create([
         'name' => $validated['name'],
         'status' => 'active',
         'owner_id' => $user->id,
      ]);
      $user->colocations()->attach($colocation->id, [
         'role' => 'owner'
      ]);
      return redirect()->route('dashboard')->with('success', 'Colocation créée avec succès !');
   }

   public function leave()
   {
      /** @var \App\Models\User $user */
      $user = Auth::user();
      $coloc = $user->activecolocation();

      if (!$coloc) {
         return redirect()->route('dashboard')->with('error', 'Aucune colocation active trouvée.');
      }

      if ((int) $coloc->owner_id === (int) $user->id) {
         return back()->with('error', 'En tant qu\'owner, vous devez désactiver la colocation.');
      }

      DB::transaction(function () use ($coloc, $user) {
         Expense::where('colocation_id', $coloc->id)
            ->where('user_id', $user->id)
            ->update(['user_id' => $coloc->owner_id]);

         $coloc->users()->detach($user->id);
      });

      return redirect()->route('dashboard')->with('success', 'Vous avez quitté la colocation. Les dépenses ont été transférées à l\'owner.');
   }

   public function deactivate(Colocation $colocation)
   {
      if ((int) $colocation->owner_id !== (int) Auth::id()) {
         return back()->with('error', 'Seul l\'owner peut désactiver la colocation.');
      }

      $colocation->update([
         'statut' => 'inactive',
      ]);

      return redirect()->route('dashboard')->with('success', 'Colocation désactivée.');
   }
}
