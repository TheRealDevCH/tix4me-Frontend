# 📧 MailHog - Kostenlose lokale E-Mail-Lösung für Entwicklung

## 🎯 Was ist MailHog?

MailHog ist ein lokaler E-Mail-Server für Entwicklung:
- ✅ **100% kostenlos** - Keine Kosten
- ✅ **Lokal** - Läuft auf deinem Computer
- ✅ **Unbegrenzte E-Mails** - Keine Limits
- ✅ **Web-Interface** - Sieh E-Mails im Browser
- ✅ **Keine externe Abhängigkeit** - Nur lokal
- ✅ **Perfekt für Entwicklung** - Nicht für Produktion

---

## 🚀 Installation

### Windows (mit Chocolatey)

**Schritt 1: Installiere Chocolatey (falls nicht vorhanden)**
```powershell
# Öffne PowerShell als Administrator
# Kopiere und führe aus:
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
iwr -useb community.chocolatey.org/install.ps1 | iex
```

**Schritt 2: Installiere MailHog**
```powershell
choco install mailhog
```

### macOS (mit Homebrew)

**Schritt 1: Installiere Homebrew (falls nicht vorhanden)**
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

**Schritt 2: Installiere MailHog**
```bash
brew install mailhog
```

### Linux (Ubuntu/Debian)

**Option 1: Mit apt**
```bash
sudo apt-get update
sudo apt-get install mailhog
```

**Option 2: Manuell herunterladen**
```bash
# Gehe zu https://github.com/mailhog/MailHog/releases
# Lade die neueste Version herunter
# Extrahiere und führe aus
```

---

## ▶️ MailHog starten

### Windows PowerShell
```powershell
mailhog
```

### macOS/Linux
```bash
mailhog
```

### Output
```
MailHog v1.0.1

Web UI:     http://127.0.0.1:1025
SMTP:       127.0.0.1:1025
```

---

## ⚙️ Laravel konfigurieren

### Aktualisiere deine `.env` Datei

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

### Wichtige Hinweise
- **MAIL_HOST:** 127.0.0.1 (lokal)
- **MAIL_PORT:** 1025 (MailHog Standard)
- **MAIL_USERNAME:** null (nicht erforderlich)
- **MAIL_PASSWORD:** null (nicht erforderlich)
- **MAIL_ENCRYPTION:** null (nicht erforderlich)

---

## 🧪 Teste die Konfiguration

### Schritt 1: Starte MailHog
```bash
mailhog
# Output: Web UI: http://127.0.0.1:1025
```

### Schritt 2: Starte Laravel Server
```bash
php artisan serve
```

### Schritt 3: Starte Vite Dev Server
```bash
npm run dev
```

### Schritt 4: Teste Password Reset
1. Öffne http://localhost:8000
2. Gehe zur Login-Seite
3. Klicke "Passwort vergessen?"
4. Gib deine E-Mail-Adresse ein
5. Klicke "Reset-Link senden"

### Schritt 5: Überprüfe E-Mail in MailHog
1. Öffne http://127.0.0.1:1025 im Browser
2. Du siehst die E-Mail in der Liste
3. Klicke auf die E-Mail um sie zu öffnen
4. Du siehst den Reset-Link

---

## 📧 E-Mail in MailHog ansehen

### Web-Interface
```
URL: http://127.0.0.1:1025
```

### Was du siehst
- **Liste aller E-Mails** - Alle versendeten E-Mails
- **E-Mail-Details** - Betreff, Von, An, Inhalt
- **HTML-Ansicht** - Formatierte E-Mail
- **Raw-Ansicht** - Rohe E-Mail-Daten
- **MIME-Teile** - Anhänge und Teile

### Reset-Link kopieren
1. Öffne die E-Mail in MailHog
2. Suche nach "reset-password"
3. Kopiere den Link
4. Öffne ihn im Browser
5. Setze dein neues Passwort

---

## 🔄 Workflow für Entwicklung

### Terminal 1: MailHog starten
```bash
mailhog
# Läuft auf http://127.0.0.1:1025
```

### Terminal 2: Laravel Server starten
```bash
php artisan serve
# Läuft auf http://127.0.0.1:8000
```

### Terminal 3: Vite Dev Server starten
```bash
npm run dev
# Läuft auf http://localhost:5173
```

### Browser
```
1. Öffne http://localhost:8000
2. Teste Password Reset
3. Öffne http://127.0.0.1:1025 um E-Mails zu sehen
```

---

## 💾 E-Mails speichern

### E-Mails exportieren
1. Öffne http://127.0.0.1:1025
2. Klicke auf eine E-Mail
3. Klicke "Download" um die E-Mail zu speichern

### E-Mails löschen
1. Öffne http://127.0.0.1:1025
2. Klicke "Delete all" um alle E-Mails zu löschen

---

## 🆘 Troubleshooting

### Problem: "Connection refused"
**Lösung:**
- Stelle sicher, dass MailHog läuft
- Überprüfe, dass Port 1025 nicht belegt ist
- Versuche einen anderen Port: `mailhog -smtp-bind-addr 127.0.0.1:1026`

### Problem: MailHog startet nicht
**Lösung:**
- Überprüfe die Installation: `mailhog --version`
- Versuche neu zu installieren
- Überprüfe Firewall-Einstellungen

### Problem: E-Mail wird nicht in MailHog angezeigt
**Lösung:**
- Überprüfe `.env` Datei
- Stelle sicher, dass `MAIL_HOST=127.0.0.1` ist
- Stelle sicher, dass `MAIL_PORT=1025` ist
- Starte Laravel Server neu

### Problem: Port 1025 ist bereits belegt
**Lösung:**
- Verwende einen anderen Port: `mailhog -smtp-bind-addr 127.0.0.1:1026`
- Aktualisiere `.env`: `MAIL_PORT=1026`

---

## 📊 MailHog vs. andere Optionen

| Feature | MailHog | LOG | Mailtrap | Brevo |
|---------|---------|-----|----------|-------|
| **Kosten** | Kostenlos | Kostenlos | Kostenlos | Kostenlos |
| **Lokal** | ✅ | ✅ | ❌ | ❌ |
| **Web-Interface** | ✅ | ❌ | ✅ | ✅ |
| **E-Mails/Tag** | ∞ | ∞ | 100 | 300 |
| **Für Produktion** | ❌ | ❌ | ❌ | ✅ |
| **Setup-Zeit** | 5 min | 0 min | 5 min | 10 min |

---

## ✅ Checkliste

- [ ] MailHog installiert
- [ ] MailHog läuft auf http://127.0.0.1:1025
- [ ] `.env` aktualisiert
- [ ] Laravel Server läuft
- [ ] Vite Dev Server läuft
- [ ] Password Reset getestet
- [ ] E-Mail in MailHog angezeigt
- [ ] Reset-Link funktioniert

---

## 🎓 Zusammenfassung

**MailHog ist perfekt für lokale Entwicklung:**
- ✅ 100% kostenlos
- ✅ Lokal - keine externe Abhängigkeit
- ✅ Unbegrenzte E-Mails
- ✅ Web-Interface
- ✅ Einfache Konfiguration

**Nächste Schritte:**
1. Installiere MailHog
2. Starte MailHog
3. Aktualisiere `.env`
4. Teste Password Reset
5. Fertig!

---

## 📚 Weitere Ressourcen

- **MailHog GitHub:** https://github.com/mailhog/MailHog
- **MailHog Releases:** https://github.com/mailhog/MailHog/releases
- **Laravel Mail:** https://laravel.com/docs/mail

