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
        
        
        if ($coloc->owner_id !== Auth::id()) {
            return back()->with('error', 'Seul l\'administrateur peut inviter des membres.');
        }
        
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
    public function showCodeForm()
    {
        return view('invitation.byCode');
    }

    public function validateCode(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:8',
        ], [
            'token.required' => 'Le code d\'invitation est obligatoire.',
            'token.size' => 'Le code doit contenir 8 caractères.',
        ]);

        $invitation = Invitation::where('token', strtoupper($request->token))
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$invitation) {
            return back()->with('error', 'Ce code est invalide, expiré ou a déjà été utilisé.');
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

        return redirect()->route('colocation.show')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }

    public function showInvitation($token)
    {
        if (!$token) {
            return redirect()->route('dashboard')->with('error', 'Lien d\'invitation invalide.');
        }

        $invitation = Invitation::where('token', strtoupper($token))
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Cette invitation est invalide, expirée ou déjà utilisée.');
        }

        $colocation = $invitation->colocation;

        // Si l'utilisateur n'est pas connecté, le rediriger vers l'inscription
        if (!Auth::check()) {
            return redirect()->route('register', ['invitation_token' => $token])
                ->with('info', 'Créez un compte pour rejoindre la colocation « ' . $colocation->name . ' »');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Vérifier si l'utilisateur est déjà dans une colocation
        if ($user->colocations()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Vous faites déjà partie d\'une colocation.');
        }

        return view('invitation.confirm', compact('invitation', 'colocation'));
    }

    public function acceptInvitation(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return redirect()->route('dashboard')->with('error', 'Lien d\'invitation invalide.');
        }

        $invitation = Invitation::where('token', strtoupper($token))
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->firstOrFail();

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

        return redirect()->route('colocation.show')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }

    public function declineInvitation($token)
    {
        $invitation = Invitation::where('token', strtoupper($token))
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->firstOrFail();

        $invitation->update(['used_at' => now()]);

        return redirect()->route('dashboard')->with('success', 'Vous avez refusé l\'invitation.');
    }
}