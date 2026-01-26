<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2 style="color: #4f46e5; margin: 0;">Vous avez été invité à rejoindre une colocation !</h2>
    </div>

    <div style="padding: 20px; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px;">
        <p style="color: #374151; font-size: 16px; line-height: 1.6;">
            Bonjour,
        </p>

        <p style="color: #374151; font-size: 16px; line-height: 1.6;">
            Vous avez reçu une invitation pour rejoindre la colocation <strong>{{ $colocname }}</strong>.
        </p>

        <p style="color: #374151; font-size: 16px; line-height: 1.6;">
            Pour accepter cette invitation, vous pouvez l'utiliser de l'une des deux façons suivantes :
        </p>

        @if($type === 'token')
            <div style="background-color: #eef2ff; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;">
                <p style="color: #4f46e5; font-size: 14px; margin-bottom: 15px;">
                    <strong>Votre code d'invitation :</strong>
                </p>
                <div style="background-color: #fff; padding: 15px; border: 2px solid #4f46e5; border-radius: 6px; font-size: 24px; font-weight: bold; color: #4f46e5; letter-spacing: 2px;">
                    {{ $token }}
                </div>
                <p style="color: #6b7280; font-size: 12px; margin-top: 15px;">
                    Utilisez ce code pour rejoindre la colocation sur la plateforme.
                </p>
            </div>
        @else
            <div style="background-color: #eef2ff; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;">
                <p style="color: #4f46e5; font-size: 14px; margin-bottom: 15px;">
                    <strong>Cliquez sur le bouton ci-dessous pour rejoindre la colocation :</strong>
                </p>
                <a href="{{ route('invitation.show', $token) }}" 
                   style="display: inline-block; background-color: #4f46e5; color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px;">
                    Rejoindre la colocation
                </a>
                <p style="color: #6b7280; font-size: 12px; margin-top: 15px;">
                    Ou copiez ce lien dans votre navigateur :<br>
                    <span style="color: #4f46e5; word-break: break-all;">{{ route('invitation.show', $token) }}</span>
                </p>
            </div>
        @endif

        <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin-top: 20px;">
            <strong>Attention :</strong> Cette invitation expire dans 48 heures. Assurez-vous de l'accepter avant son expiration.
        </p>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

        <p style="color: #9ca3af; font-size: 12px; line-height: 1.6;">
            Si vous n'avez pas demandé cette invitation, vous pouvez ignorer cet email. En cas de question ou de problème, n'hésitez pas à contacter l'administrateur de la colocation.
        </p>

        <p style="color: #9ca3af; font-size: 12px; line-height: 1.6; margin-top: 15px;">
            Cordialement,<br>
            <strong>L'équipe EasyColoc</strong>
        </p>
    </div>
</div>
