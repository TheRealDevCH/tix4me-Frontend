# Vordefinierte Mail-Konfigurationen - Copy & Paste

Kopiere einfach die gewünschte Konfiguration in deine `.env` Datei und starte die Server neu.

---

## 🔧 Konfiguration 1: LOG (Aktuell - Entwicklung)

**Beschreibung:** E-Mails werden in Logs geschrieben. Perfekt für lokale Entwicklung.

**Kopiere in `.env`:**
```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

**E-Mails ansehen:**
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 50 -Wait

# macOS/Linux
tail -f storage/logs/laravel.log
```

---

## 🔧 Konfiguration 2: MAILTRAP (Testing)

**Beschreibung:** Kostenloser E-Mail-Testing-Service mit Web-Interface.

**Vorbereitung:**
1. Gehe zu https://mailtrap.io
2. Registriere dich kostenlos
3. Erstelle ein Projekt
4. Kopiere die SMTP-Einstellungen

**Kopiere in `.env`:**
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

**E-Mails ansehen:**
- Öffne https://mailtrap.io
- Klicke auf dein Projekt
- E-Mails werden dort angezeigt

---

## 🔧 Konfiguration 3: MAILHOG (Lokal)

**Beschreibung:** Lokaler E-Mail-Server. Keine externe Abhängigkeit.

**Installation:**
```bash
# Windows (mit Chocolatey)
choco install mailhog

# macOS
brew install mailhog

# Linux: Lade von https://github.com/mailhog/MailHog/releases herunter
```

**Starten:**
```bash
mailhog
# Öffne http://localhost:1025 im Browser
```

**Kopiere in `.env`:**
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

**E-Mails ansehen:**
- Öffne http://localhost:1025 im Browser
- E-Mails werden dort angezeigt

---

## 🔧 Konfiguration 4: GMAIL (Produktion - Kostenlos)

**Beschreibung:** Echte E-Mails über Gmail. Kostenlos und zuverlässig.

**Vorbereitung:**
1. Gehe zu https://myaccount.google.com/security
2. Aktiviere "2-Faktor-Authentifizierung"
3. Gehe zu https://myaccount.google.com/apppasswords
4. Wähle "Mail" und "Windows Computer"
5. Klicke "Generate"
6. Kopiere das generierte Passwort

**Kopiere in `.env`:**
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

**E-Mails ansehen:**
- Öffne dein Gmail-Postfach
- E-Mails werden dort angezeigt

---

## 🔧 Konfiguration 5: MAILGUN (Produktion - Professionell)

**Beschreibung:** Professioneller E-Mail-Service. Kostenlos bis 100 E-Mails/Tag.

**Vorbereitung:**
1. Gehe zu https://www.mailgun.com
2. Registriere dich kostenlos
3. Erstelle eine Domain
4. Kopiere die API-Einstellungen

**Kopiere in `.env`:**
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-secret-key
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

**E-Mails ansehen:**
- Öffne https://app.mailgun.com
- Klicke auf "Logs"
- E-Mails werden dort angezeigt

---

## 🔧 Konfiguration 6: SENDGRID (Produktion - Professionell)

**Beschreibung:** Professioneller E-Mail-Service. Kostenlos bis 100 E-Mails/Tag.

**Vorbereitung:**
1. Gehe zu https://sendgrid.com
2. Registriere dich kostenlos
3. Erstelle einen API-Key
4. Kopiere den API-Key

**Kopiere in `.env`:**
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-api-key
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

**E-Mails ansehen:**
- Öffne https://app.sendgrid.com
- Klicke auf "Mail Activity"
- E-Mails werden dort angezeigt

---

## 🔧 Konfiguration 7: AMAZON SES (Produktion - Professionell)

**Beschreibung:** Professioneller E-Mail-Service von Amazon. Günstig bei hohem Volumen.

**Vorbereitung:**
1. Gehe zu https://aws.amazon.com
2. Registriere dich
3. Erstelle einen IAM-User mit SES-Berechtigung
4. Kopiere die Access-Keys

**Kopiere in `.env`:**
```env
MAIL_MAILER=ses
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

**E-Mails ansehen:**
- Öffne https://console.aws.amazon.com
- Gehe zu SES
- Klicke auf "Sending Statistics"
- E-Mails werden dort angezeigt

---

## 📋 Schnelle Umschaltung

### Von LOG zu Mailtrap:
```bash
# 1. Kopiere Mailtrap-Konfiguration in .env
# 2. Starte Server neu
php artisan serve
npm run dev
# 3. Teste Password Reset
```

### Von Mailtrap zu Gmail:
```bash
# 1. Kopiere Gmail-Konfiguration in .env
# 2. Starte Server neu
php artisan serve
npm run dev
# 3. Teste Password Reset
```

---

## ✅ Checkliste nach Konfigurationsänderung

- [ ] `.env` Datei aktualisiert
- [ ] Server neu gestartet (`Ctrl+C` und neu starten)
- [ ] Vite Dev Server läuft
- [ ] Laravel Server läuft
- [ ] Öffne http://localhost:8000
- [ ] Gehe zur Login-Seite
- [ ] Klicke "Passwort vergessen?"
- [ ] Gib E-Mail-Adresse ein
- [ ] Klicke "Reset-Link senden"
- [ ] Überprüfe, ob E-Mail versendet wurde
- [ ] Überprüfe E-Mail in Logs/Mailtrap/Gmail/etc.

---

## 🎓 Empfehlungen

| Phase | Konfiguration | Grund |
|-------|---------------|-------|
| Jetzt (Entwicklung) | LOG | Keine Konfiguration, E-Mails in Logs |
| Später (Testing) | Mailtrap | Realistisches Testing, Web-Interface |
| Produktion | Gmail | Kostenlos, einfach, zuverlässig |
| Produktion (Professionell) | Mailgun/SendGrid | Professionell, gutes Tracking |

---

## 🆘 Hilfe

**Problem: E-Mail wird nicht versendet**
- Überprüfe `.env` Datei
- Starte Server neu
- Überprüfe Logs: `storage/logs/laravel.log`

**Problem: "Connection refused"**
- Überprüfe `MAIL_HOST` und `MAIL_PORT`
- Stelle sicher, dass der SMTP-Server erreichbar ist

**Problem: "Authentication failed"**
- Überprüfe `MAIL_USERNAME` und `MAIL_PASSWORD`
- Bei Gmail: Verwende App-Passwort, nicht normales Passwort

**Problem: E-Mail wird als Spam markiert**
- Verwende professionellen E-Mail-Service (Mailgun, SendGrid)
- Konfiguriere SPF, DKIM und DMARC Records

