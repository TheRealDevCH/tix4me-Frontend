# Password Reset E-Mails testen - Praktische Anleitung

## 🎯 Schnellstart (mit LOG - Aktuell)

### Schritt 1: Stelle sicher, dass deine `.env` korrekt ist
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### Schritt 2: Starte die Server
```bash
# Terminal 1: Vite Dev Server
npm run dev

# Terminal 2: Laravel Server
php artisan serve

# Terminal 3: Tail the log (Windows PowerShell)
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

### Schritt 3: Teste Password Reset
1. Öffne http://localhost:8000
2. Gehe zur Login-Seite
3. Klicke "Passwort vergessen?"
4. Gib eine registrierte E-Mail-Adresse ein
5. Klicke "Reset-Link senden"
6. **Schaue in Terminal 3** - Die E-Mail wird dort angezeigt!

### Schritt 4: Extrahiere den Reset-Link
In Terminal 3 siehst du etwas wie:
```
[2025-10-23 20:15:30] local.DEBUG: Message sent to [user@example.com]
[2025-10-23 20:15:30] local.DEBUG: 
To: user@example.com
From: hello@example.com
Subject: Reset Password Notification

Click here to reset your password:
http://localhost:8000/reset-password/abc123def456...
```

Kopiere den Link und öffne ihn im Browser.

---

## 🔧 Upgrade zu Mailtrap (Empfohlen für besseres Testing)

### Schritt 1: Registriere dich bei Mailtrap
1. Gehe zu https://mailtrap.io
2. Klicke "Sign Up"
3. Registriere dich kostenlos
4. Bestätige deine E-Mail

### Schritt 2: Erstelle ein neues Projekt
1. Klicke "Create Project"
2. Gib einen Namen ein (z.B. "Tix4me")
3. Klicke "Create"

### Schritt 3: Kopiere die SMTP-Einstellungen
1. Öffne dein Projekt
2. Klicke auf "Integrations"
3. Wähle "Laravel"
4. Kopiere die `.env` Einstellungen

### Schritt 4: Aktualisiere deine `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username-from-mailtrap
MAIL_PASSWORD=your-password-from-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### Schritt 5: Starte die Server neu
```bash
# Stoppe alle Server (Ctrl+C)
# Starte sie neu
php artisan serve
npm run dev
```

### Schritt 6: Teste Password Reset
1. Öffne http://localhost:8000
2. Gehe zur Login-Seite
3. Klicke "Passwort vergessen?"
4. Gib eine registrierte E-Mail-Adresse ein
5. Klicke "Reset-Link senden"
6. **Öffne https://mailtrap.io** - Die E-Mail wird dort angezeigt!

### Schritt 7: Ansicht der E-Mail
1. Öffne https://mailtrap.io
2. Klicke auf dein Projekt
3. Du siehst die E-Mail in der Liste
4. Klicke auf die E-Mail um sie zu öffnen
5. Du siehst den Reset-Link

---

## 🚀 Upgrade zu Gmail (Für Produktion)

### Schritt 1: Aktiviere 2-Faktor-Authentifizierung
1. Gehe zu https://myaccount.google.com/security
2. Klicke "2-Faktor-Authentifizierung"
3. Folge den Anweisungen

### Schritt 2: Erstelle ein App-Passwort
1. Gehe zu https://myaccount.google.com/apppasswords
2. Wähle "Mail" und "Windows Computer"
3. Klicke "Generate"
4. Kopiere das generierte Passwort

### Schritt 3: Aktualisiere deine `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=deine-email@gmail.com
MAIL_PASSWORD=dein-app-passwort-von-google
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="deine-email@gmail.com"
MAIL_FROM_NAME="Tix4me"
```

### Schritt 4: Starte die Server neu
```bash
# Stoppe alle Server (Ctrl+C)
# Starte sie neu
php artisan serve
npm run dev
```

### Schritt 5: Teste Password Reset
1. Öffne http://localhost:8000
2. Gehe zur Login-Seite
3. Klicke "Passwort vergessen?"
4. Gib eine registrierte E-Mail-Adresse ein
5. Klicke "Reset-Link senden"
6. **Öffne dein Gmail-Postfach** - Die E-Mail wird dort angezeigt!

---

## 🐛 Troubleshooting

### Problem: E-Mail wird nicht versendet
**Lösung:**
1. Überprüfe die `.env` Datei
2. Stelle sicher, dass `MAIL_MAILER` korrekt ist
3. Starte die Server neu
4. Überprüfe die Logs: `storage/logs/laravel.log`

### Problem: "Connection refused" Fehler
**Lösung:**
1. Überprüfe `MAIL_HOST` und `MAIL_PORT`
2. Stelle sicher, dass der SMTP-Server erreichbar ist
3. Überprüfe Firewall-Einstellungen

### Problem: "Authentication failed" Fehler
**Lösung:**
1. Überprüfe `MAIL_USERNAME` und `MAIL_PASSWORD`
2. Stelle sicher, dass die Anmeldedaten korrekt sind
3. Bei Gmail: Verwende App-Passwort, nicht dein normales Passwort

### Problem: E-Mail wird als Spam markiert
**Lösung:**
1. Verwende einen professionellen E-Mail-Service (Mailgun, SendGrid)
2. Konfiguriere SPF, DKIM und DMARC Records
3. Verwende eine Domain-E-Mail-Adresse statt Gmail

---

## 📊 Empfohlene Konfiguration nach Phase

### Phase 1: Lokale Entwicklung (JETZT)
```env
MAIL_MAILER=log
```
- ✅ Keine Konfiguration
- ✅ E-Mails in Logs sichtbar
- ✅ Perfekt für Entwicklung

### Phase 2: Testing (Optional)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
```
- ✅ Realistisches Testing
- ✅ Web-Interface
- ✅ Kostenlos

### Phase 3: Produktion (Später)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=deine-email@gmail.com
MAIL_PASSWORD=app-passwort
MAIL_ENCRYPTION=tls
```
- ✅ Echte E-Mails
- ✅ Kostenlos
- ✅ Zuverlässig

---

## ✅ Checkliste

- [ ] `.env` ist korrekt konfiguriert
- [ ] Server laufen (Vite, Laravel)
- [ ] Benutzer ist registriert
- [ ] "Passwort vergessen?" Link funktioniert
- [ ] E-Mail wird versendet (in Logs oder Mailtrap)
- [ ] Reset-Link ist in der E-Mail
- [ ] Reset-Link funktioniert
- [ ] Neues Passwort kann gesetzt werden
- [ ] Login mit neuem Passwort funktioniert

---

## 🎓 Zusammenfassung

**Aktuelle Situation:**
- ✅ Password Reset ist implementiert
- ✅ E-Mail-Versand ist konfiguriert (LOG)
- ✅ E-Mails werden in Logs geschrieben

**Nächste Schritte:**
1. Teste mit LOG (aktuell)
2. Optional: Upgrade zu Mailtrap für besseres Testing
3. Später: Upgrade zu Gmail oder Mailgun für Produktion

**Wichtig:**
- Du brauchst KEINEN externen Service für Entwicklung
- LOG ist perfekt für lokale Entwicklung
- Für Produktion: Gmail (kostenlos) oder Mailgun/SendGrid (professionell)

