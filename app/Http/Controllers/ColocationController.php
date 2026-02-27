<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Http\Requests\ColocationRequest;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
   public function afficherColocation(){
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
   public function UpdateColocation() {}
}
