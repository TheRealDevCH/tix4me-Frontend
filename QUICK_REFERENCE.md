# 📧 Laravel E-Mail - Schnelle Referenzkarte

## ❓ Häufig gestellte Fragen

### F: Kann Laravel eigenständig E-Mails versenden?
**A:** ✅ **JA!** Laravel kann E-Mails ohne externe Services versenden.

### F: Brauche ich Twilio SendGrid, Mailgun oder ähnliche Dienste?
**A:** ❌ **NEIN!** Diese sind optional. Du kannst Gmail oder einen anderen SMTP-Server verwenden.

### F: Was bedeutet `MAIL_MAILER=log`?
**A:** E-Mails werden in die Log-Datei geschrieben, nicht versendet. Perfekt für Entwicklung.

### F: Wo finde ich die E-Mails, wenn `MAIL_MAILER=log` verwendet wird?
**A:** In der Datei `storage/logs/laravel.log` oder mit `tail -f storage/logs/laravel.log`

### F: Kann ich Gmail kostenlos verwenden?
**A:** ✅ **JA!** Gmail ist kostenlos und zuverlässig. Begrenzt auf ~500 E-Mails/Tag.

### F: Welche Option ist am einfachsten für Produktion?
**A:** **Gmail** - Kostenlos, einfach zu konfigurieren, zuverlässig.

---

## 🚀 Schnellstart

### Schritt 1: Überprüfe deine `.env`
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### Schritt 2: Starte die Server
```bash
# Terminal 1
npm run dev

# Terminal 2
php artisan serve

# Terminal 3 (Windows PowerShell)
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

### Schritt 3: Teste Password Reset
1. Öffne http://localhost:8000
2. Gehe zur Login-Seite
3. Klicke "Passwort vergessen?"
4. Gib E-Mail ein
5. Klicke "Reset-Link senden"
6. **Schaue in Terminal 3** - E-Mail wird dort angezeigt!

---

## 📊 Vergleichstabelle

| Option | Kosten | Einfachheit | Zuverlässigkeit | Ideal für |
|--------|--------|-------------|-----------------|-----------|
| **LOG** | Kostenlos | ⭐⭐⭐⭐⭐ | N/A | Entwicklung |
| **Mailtrap** | Kostenlos | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | Testing |
| **MailHog** | Kostenlos | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | Lokale Entwicklung |
| **Gmail** | Kostenlos | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | Kleine Projekte |
| **Mailgun** | $0-35/mo | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Professionell |
| **SendGrid** | $0-120/mo | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Professionell |

---

## 🔧 Konfigurationen (Copy & Paste)

### LOG (Aktuell)
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### GMAIL (Produktion)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=deine-email@gmail.com
MAIL_PASSWORD=dein-app-passwort
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="deine-email@gmail.com"
MAIL_FROM_NAME="Tix4me"
```

### MAILTRAP (Testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

### MAILHOG (Lokal)
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Tix4me"
```

---

## 📋 Checkliste

- [ ] `.env` ist korrekt konfiguriert
- [ ] Server laufen (Vite, Laravel)
- [ ] Benutzer ist registriert
- [ ] "Passwort vergessen?" Link funktioniert
- [ ] E-Mail wird versendet
- [ ] Reset-Link ist in der E-Mail
- [ ] Reset-Link funktioniert
- [ ] Neues Passwort kann gesetzt werden
- [ ] Login mit neuem Passwort funktioniert

---

## 🆘 Troubleshooting

| Problem | Lösung |
|---------|--------|
| E-Mail wird nicht versendet | Überprüfe `.env`, starte Server neu, überprüfe Logs |
| "Connection refused" | Überprüfe `MAIL_HOST` und `MAIL_PORT` |
| "Authentication failed" | Überprüfe `MAIL_USERNAME` und `MAIL_PASSWORD` |
| E-Mail wird als Spam markiert | Verwende professionellen Service (Mailgun, SendGrid) |
| E-Mail wird nicht in Logs angezeigt | Überprüfe `MAIL_MAILER=log` in `.env` |

---

## 📚 Weitere Ressourcen

- **MAIL_CONFIGURATION_GUIDE.md** - Vollständiger Guide
- **TESTING_PASSWORD_RESET_EMAILS.md** - Praktische Anleitung zum Testen
- **MAIL_CONFIGS.md** - Vordefinierte Konfigurationen

---

## 🎓 Zusammenfassung

✅ **Laravel kann eigenständig E-Mails versenden**
✅ **Keine externen Services erforderlich**
✅ **Deine aktuelle Konfiguration (LOG) ist perfekt für Entwicklung**
✅ **Für Produktion: Gmail (kostenlos) oder Mailgun/SendGrid (professionell)**

**Nächste Schritte:**
1. Teste mit LOG (aktuell)
2. Optional: Upgrade zu Mailtrap für besseres Testing
3. Später: Upgrade zu Gmail oder Mailgun für Produktion

