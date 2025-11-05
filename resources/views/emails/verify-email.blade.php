<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mail-Adresse bestätigen</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #1f2937 0%, #111827 50%, #1f2937 100%);
        }
        .email-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .header {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }
        .content {
            padding: 50px 40px;
        }
        .content h2 {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 0;
            font-size: 28px;
            font-weight: 800;
        }
        .button {
            display: inline-block;
            padding: 18px 50px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 16px;
            margin: 30px 0;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.4);
            transition: all 0.3s ease;
            font-size: 16px;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(79, 70, 229, 0.6);
        }
        .info-box {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
            border-left: 4px solid #4F46E5;
            padding: 20px;
            margin: 30px 0;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        .footer {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-size: 13px;
            background: linear-gradient(135deg, rgba(249, 250, 251, 0.8) 0%, rgba(243, 244, 246, 0.8) 100%);
            backdrop-filter: blur(10px);
        }
        .footer p {
            margin: 8px 0;
        }
        .link-text {
            color: #4F46E5;
            word-break: break-all;
            font-size: 13px;
            background: rgba(79, 70, 229, 0.05);
            padding: 15px;
            border-radius: 8px;
            display: block;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>✉️ E-Mail-Adresse bestätigen</h1>
        </div>
        
        <div class="content">
            <h2>Hallo {{ $user->name }}!</h2>
            
            <p>Vielen Dank für Ihre Registrierung bei <strong>Tix4me</strong>!</p>
            
            <p>Um Ihr Konto zu aktivieren und alle Funktionen nutzen zu können, bestätigen Sie bitte Ihre E-Mail-Adresse, indem Sie auf den Button unten klicken:</p>
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">
                    E-Mail-Adresse bestätigen
                </a>
            </div>
            
            <div class="info-box">
                <strong>⏰ Wichtig:</strong> Dieser Link ist aus Sicherheitsgründen nur <strong>60 Minuten</strong> gültig.
            </div>
            
            <p>Falls der Button nicht funktioniert, kopieren Sie bitte den folgenden Link und fügen Sie ihn in Ihren Browser ein:</p>
            
            <p class="link-text">{{ $verificationUrl }}</p>
            
            <hr style="border: none; border-top: 1px solid #E5E7EB; margin: 30px 0;">
            
            <p style="color: #666; font-size: 14px;">
                <strong>Sie haben sich nicht registriert?</strong><br>
                Falls Sie diese E-Mail irrtümlich erhalten haben, können Sie sie einfach ignorieren. Ihr Konto wird nicht aktiviert, wenn Sie nicht auf den Bestätigungslink klicken.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>Tix4me</strong> - Ihre Plattform für Tickets</p>
            <p>&copy; {{ date('Y') }} Tix4me. Alle Rechte vorbehalten.</p>
        </div>
    </div>
</body>
</html>

