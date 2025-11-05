<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Willkommen bei Tix4me</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Willkommen bei Tix4me!</h1>
    </div>
    <div class="content">
        <h2>Hallo {{ $name }}!</h2>
        <p>Vielen Dank für Ihre Registrierung bei Tix4me.</p>
        <p>Wir freuen uns, Sie in unserer Community begrüßen zu dürfen!</p>
        <p>Mit Tix4me können Sie ganz einfach Tickets für Ihre Lieblingsveranstaltungen kaufen.</p>
        <a href="{{ $url }}" class="button">Jetzt loslegen</a>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Tix4me. Alle Rechte vorbehalten.</p>
    </div>
</body>
</html>

