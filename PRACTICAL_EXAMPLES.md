# 📧 Praktische Beispiele - Laravel E-Mail-Versand

## 🎯 Beispiel 1: E-Mails in Logs ansehen (LOG)

### Konfiguration
```env
MAIL_MAILER=log
```

### Terminal-Befehle

**Windows PowerShell:**
```powershell
# Echtzeit-Anzeige der letzten 50 Zeilen
Get-Content storage/logs/laravel.log -Tail 50 -Wait

# Oder: Nur die letzten 20 Zeilen
Get-Content storage/logs/laravel.log -Tail 20
```

**macOS/Linux:**
```bash
# Echtzeit-Anzeige
tail -f storage/logs/laravel.log

# Oder: Nur die letzten 20 Zeilen
tail -20 storage/logs/laravel.log
```

### Beispiel-Output
```
[2025-10-23 20:15:30] local.DEBUG: Message sent to [user@example.com]
[2025-10-23 20:15:30] local.DEBUG: 
To: user@example.com
From: hello@example.com
Subject: Reset Password Notification

Click here to reset your password:
http://localhost:8000/reset-password/abc123def456xyz789...

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.
```

---

## 🎯 Beispiel 2: Mit Mailtrap testen

### Schritt 1: Registrierung
```
1. Gehe zu https://mailtrap.io
2. Klicke "Sign Up"
3. Gib E-Mail und Passwort ein
4. Bestätige E-Mail
```

### Schritt 2: Projekt erstellen
```
1. Klicke "Create Project"
2. Gib Namen ein: "Tix4me"
3. Klicke "Create"
```

### Schritt 3: SMTP-Einstellungen kopieren
```
1. Öffne dein Projekt
2. Klicke "Integrations"
3. Wähle "Laravel"
4. Kopiere die Einstellungen
```

### Konfiguration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=abc123def456
MAIL_PASSWORD=xyz789abc123
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### E-Mails ansehen
```
1. Öffne https://mailtrap.io
2. Klicke auf dein Projekt
3. E-Mails werden in der Liste angezeigt
4. Klicke auf E-Mail um sie zu öffnen
5. Du siehst den Reset-Link
```

---

## 🎯 Beispiel 3: Mit Gmail versenden

### Schritt 1: 2-Faktor-Authentifizierung aktivieren
```
1. Gehe zu https://myaccount.google.com/security
2. Klicke "2-Faktor-Authentifizierung"
3. Folge den Anweisungen
```

### Schritt 2: App-Passwort erstellen
```
1. Gehe zu https://myaccount.google.com/apppasswords
2. Wähle "Mail" und "Windows Computer"
3. Klicke "Generate"
4. Kopiere das generierte Passwort
```

### Konfiguration
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

### E-Mails ansehen
```
1. Öffne https://mail.google.com
2. Melde dich an
3. E-Mails werden in deinem Postfach angezeigt
```

---

## 🎯 Beispiel 4: Mit MailHog lokal testen

### Installation

**Windows (mit Chocolatey):**
```powershell
choco install mailhog
```

**macOS:**
```bash
brew install mailhog
```

**Linux:**
```bash
# Lade von https://github.com/mailhog/MailHog/releases herunter
# Oder mit apt (Ubuntu/Debian):
sudo apt-get install mailhog
```

### Starten
```bash
mailhog
# Output:
# MailHog v1.0.1
# 
# Web UI:     http://127.0.0.1:1025
# SMTP:       127.0.0.1:1025
```

### Konfiguration
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### E-Mails ansehen
```
1. Öffne http://localhost:1025 im Browser
2. E-Mails werden dort angezeigt
3. Klicke auf E-Mail um sie zu öffnen
4. Du siehst den Reset-Link
```

---

## 🎯 Beispiel 5: Schnelle Umschaltung zwischen Konfigurationen

### Von LOG zu Mailtrap
```bash
# 1. Bearbeite .env
# Ändere MAIL_MAILER=log zu MAIL_MAILER=smtp
# Füge Mailtrap-Einstellungen hinzu

# 2. Starte Server neu
Ctrl+C  # Stoppe Laravel
php artisan serve  # Starte neu

# 3. Teste
# Öffne http://localhost:8000
# Gehe zu "Passwort vergessen?"
# Gib E-Mail ein
# Klicke "Reset-Link senden"
# Öffne https://mailtrap.io
# E-Mail sollte dort angezeigt werden
```

### Von Mailtrap zu Gmail
```bash
# 1. Bearbeite .env
# Ändere Mailtrap-Einstellungen zu Gmail-Einstellungen

# 2. Starte Server neu
Ctrl+C  # Stoppe Laravel
php artisan serve  # Starte neu

# 3. Teste
# Öffne http://localhost:8000
# Gehe zu "Passwort vergessen?"
# Gib E-Mail ein
# Klicke "Reset-Link senden"
# Öffne https://mail.google.com
# E-Mail sollte dort angezeigt werden
```

---

## 🎯 Beispiel 6: Debugging - E-Mail wird nicht versendet

### Schritt 1: Überprüfe `.env`
```bash
# Öffne .env und überprüfe:
MAIL_MAILER=log  # oder smtp
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"

# Wenn MAIL_MAILER=smtp:
MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=...
```

### Schritt 2: Starte Server neu
```bash
# Stoppe alle Server
Ctrl+C

# Starte neu
php artisan serve
npm run dev
```

### Schritt 3: Überprüfe Logs
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 50 -Wait

# macOS/Linux
tail -f storage/logs/laravel.log
```

### Schritt 4: Teste Password Reset
```
1. Öffne http://localhost:8000
2. Gehe zur Login-Seite
3. Klicke "Passwort vergessen?"
4. Gib E-Mail ein
5. Klicke "Reset-Link senden"
6. Überprüfe Logs/Mailtrap/Gmail
```

---

## 📊 Vergleich der Beispiele

| Beispiel | Konfiguration | Ansicht | Ideal für |
|----------|---------------|--------|-----------|
| 1 | LOG | Terminal | Schnelle Entwicklung |
| 2 | Mailtrap | Web-Interface | Realistisches Testing |
| 3 | Gmail | Gmail-Postfach | Produktion |
| 4 | MailHog | Web-Interface | Lokale Entwicklung |

---

## ✅ Checkliste für jedes Beispiel

- [ ] `.env` ist korrekt konfiguriert
- [ ] Server sind neu gestartet
- [ ] Öffne http://localhost:8000
- [ ] Gehe zur Login-Seite
- [ ] Klicke "Passwort vergessen?"
- [ ] Gib registrierte E-Mail ein
- [ ] Klicke "Reset-Link senden"
- [ ] Überprüfe E-Mail in Logs/Mailtrap/Gmail/MailHog
- [ ] Kopiere Reset-Link
- [ ] Öffne Reset-Link im Browser
- [ ] Gib neues Passwort ein
- [ ] Klicke "Passwort zurücksetzen"
- [ ] Werde zum Login weitergeleitet
- [ ] Melde dich mit neuem Passwort an

---

## 🎓 Zusammenfassung

**Für schnelle Entwicklung:** Verwende LOG (Beispiel 1)
**Für realistisches Testing:** Verwende Mailtrap (Beispiel 2)
**Für Produktion:** Verwende Gmail (Beispiel 3)
**Für lokale Entwicklung ohne externe Services:** Verwende MailHog (Beispiel 4)

