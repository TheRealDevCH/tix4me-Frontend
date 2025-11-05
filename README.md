# Tix4me - Event Ticketing Platform

Eine moderne Event-Ticketing-Plattform gebaut mit Laravel und Vue.js.

## 🚀 Features

- **Event-Verwaltung:** Erstellen, bearbeiten und löschen Sie Events
- **Ticket-System:** Kaufen Sie Tickets für Events
- **Benutzer-Authentifizierung:** Registrierung, Login, Email-Verifizierung
- **Profil-Verwaltung:** Ändern Sie Name, Email und Passwort
- **Warenkorb:** Fügen Sie Tickets zum Warenkorb hinzu
- **Mehrsprachig:** Deutsch, Englisch, Französisch
- **Dark Mode:** Umschalten zwischen hellem und dunklem Design

## 🛠️ Technologien

- **Backend:** Laravel 12.0
- **Frontend:** Vue.js 3.5.22
- **State Management:** Pinia 3.0.3
- **Routing:** Vue Router 4.6.3
- **Styling:** Tailwind CSS 3.4.18
- **Build Tool:** Vite 7.0.7
- **Datenbank:** SQLite
- **Email:** Gmail SMTP

## 📦 Installation (Lokal)

### Voraussetzungen

- PHP 8.2+
- Composer
- Node.js 18+
- npm oder yarn

### Schritte

1. **Repository klonen:**
   ```bash
   git clone <your-repo-url>
   cd FRONTEND
   ```

2. **Dependencies installieren:**
   ```bash
   composer install
   npm install
   ```

3. **Environment-Datei erstellen:**
   ```bash
   cp .env.example .env
   ```

4. **App-Key generieren:**
   ```bash
   php artisan key:generate
   ```

5. **Datenbank erstellen:**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Development-Server starten:**
   ```bash
   # Terminal 1: Laravel
   php artisan serve

   # Terminal 2: Vite
   npm run dev
   ```

7. **Öffnen Sie:** `http://localhost:8000`

## 🌐 Deployment auf Vercel

### Voraussetzungen

- GitHub Account
- Vercel Account (kostenlos)

### Schritte

1. **GitHub Repository erstellen:**
   - Gehen Sie zu [github.com/new](https://github.com/new)
   - Erstellen Sie ein neues Repository (z.B. "tix4me")
   - **Wichtig:** Machen Sie es **privat** (wegen .env Daten)

2. **Code zu GitHub pushen:**
   ```bash
   git add .
   git commit -m "Initial commit - Tix4me Platform"
   git branch -M main
   git remote add origin https://github.com/IHR-USERNAME/tix4me.git
   git push -u origin main
   ```

3. **Vercel Projekt erstellen:**
   - Gehen Sie zu [vercel.com](https://vercel.com)
   - Klicken Sie auf "Add New Project"
   - Importieren Sie Ihr GitHub Repository
   - Wählen Sie "Other" als Framework Preset

4. **Environment Variables in Vercel setzen:**
   
   Gehen Sie zu **Settings → Environment Variables** und fügen Sie hinzu:

   ```
   APP_NAME=Tix4me
   APP_ENV=production
   APP_KEY=<generieren Sie einen mit: php artisan key:generate --show>
   APP_DEBUG=false
   APP_URL=https://ihr-projekt.vercel.app
   FRONTEND_URL=https://ihr-projekt.vercel.app
   
   DB_CONNECTION=sqlite
   
   SESSION_DRIVER=cookie
   SESSION_LIFETIME=120
   SESSION_SECURE_COOKIE=true
   
   QUEUE_CONNECTION=sync
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=buildersfrenchdude@gmail.com
   MAIL_PASSWORD=dmbnacqwptwsgaiw
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=buildersfrenchdude@gmail.com
   MAIL_FROM_NAME=Tix4me
   ```

5. **Deploy:**
   - Klicken Sie auf "Deploy"
   - Warten Sie bis der Build abgeschlossen ist
   - Ihre App ist jetzt live! 🎉

### Nach dem Deployment

1. **Datenbank migrieren:**
   - Vercel unterstützt keine SQLite-Persistenz
   - Sie müssen zu einer Cloud-Datenbank wechseln (z.B. PlanetScale, Supabase)
   - Oder verwenden Sie Vercel Postgres

2. **Domain anpassen:**
   - Gehen Sie zu **Settings → Domains**
   - Fügen Sie Ihre eigene Domain hinzu (optional)

## 📧 Email-Konfiguration

Die App verwendet Gmail SMTP für Email-Versand:

- **Verifizierungs-Emails** bei Registrierung
- **Passwort-Reset-Emails**
- **Email-Änderungs-Bestätigungen**

### Gmail App-Passwort erstellen:

1. Gehen Sie zu [myaccount.google.com/security](https://myaccount.google.com/security)
2. Aktivieren Sie 2-Faktor-Authentifizierung
3. Gehen Sie zu "App-Passwörter"
4. Erstellen Sie ein neues App-Passwort für "Mail"
5. Verwenden Sie dieses Passwort in `MAIL_PASSWORD`

## 🔒 Sicherheit

- **Session-basierte Authentifizierung** mit SHA-256 Token-Hashing
- **Bcrypt Passwort-Hashing**
- **CSRF-Schutz**
- **Email-Verifizierung** erforderlich
- **Sichere Cookies** in Produktion

## 📝 Lizenz

Dieses Projekt ist privat und nicht für öffentliche Nutzung bestimmt.

## 👨‍💻 Entwickler

Entwickelt von Philipp Karnath

---

**Viel Erfolg mit Ihrem Deployment! 🚀**

