<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationColocRequest;
use App\Mail\InvitationColocMail;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationColoc extends Controller
{
    public function envoyerinvitation(InvitationColocRequest $request,$colocId){
        $token = strtoupper(Str::random(8));
        $coloc = Colocation::findOrfail($colocId);
        $invitation =Invitation::updateOrCreate(
            [
                'email' => $request->email,
                'colocation_id' => $coloc->id,
                'used_at' => null, 
            ],
            [
                'token' => $token,
                'type' => $request->method,
                'expires_at' => now()->addHours(48),
            ]
        );
        
        Mail::to($request->email)->send(new InvitationColocMail(
            $coloc->name, 
            $token, 
            $request->method
        ));
        
       return redirect()->route('colocation.show')
                     ->with('success', 'L\'invitation a bien été envoyée à ' . $request->email);
    }
    public function accepterInvitation(Request $request, $token = null){
        $inputToken = $token ?? $request->input('token');
       if (!$inputToken) {
            return redirect()->route('dashboard')->with('error', 'Veuillez fournir un code d\'invitation.');
        }
       
        $invitation = Invitation::where('token', strtoupper($inputToken))
            ->where('expires_at', '>', now()) 
            ->whereNull('used_at')            
            ->first();
       
        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Ce code est invalide, expiré ou a déjà été utilisé.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->colocations()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Vous faites déjà partie d\'une colocation.');
        }

        
        $user->colocations()->attach($invitation->colocation_id, [
            'role' => 'membre',
            'created_at' => now()
        ]);

        
        $invitation->update(['used_at' => now()]);

        return redirect()->route('colocation.dashboard')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }
}