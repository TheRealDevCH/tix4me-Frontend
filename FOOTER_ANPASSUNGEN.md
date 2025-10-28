# Footer-Anpassungen für Tix4me

## 📍 Wo befindet sich der Footer?

Der Footer ist eine Vue.js-Komponente und befindet sich unter:
```
resources/js/components/Footer.vue
```

## 🎨 Footer-Struktur

Der Footer besteht aus 4 Hauptsektionen:

### 1. **Brand-Sektion** (Linke Spalte)
- Logo und Markenname
- Beschreibung der Plattform
- Social Media Links (Facebook, Twitter, Instagram, LinkedIn)

### 2. **Über uns** (Zweite Spalte)
- Über Tix4me
- Unser Team
- Karriere
- Blog

### 3. **Kontakt** (Dritte Spalte)
- Kontakt
- FAQ
- Support
- Feedback

### 4. **Legal** (Vierte Spalte)
- Datenschutz
- Nutzungsbedingungen
- Cookies
- Impressum

---

## ✏️ Wie man den Footer bearbeitet

### **1. Markenname ändern**

**Datei:** `resources/js/components/Footer.vue` (Zeile 11)

```vue
<span class="text-xl font-bold text-white">Tix4me</span>
```

Ersetze `Tix4me` mit deinem gewünschten Namen.

---

### **2. Beschreibung ändern**

**Datei:** `resources/js/i18n.js`

**Deutsch (Zeile ~113):**
```javascript
description: 'Die beste Plattform für Ticketverkauf und Event-Management.',
```

**Englisch (Zeile ~230):**
```javascript
description: 'The best platform for ticket sales and event management.',
```

**Französisch (Zeile ~352):**
```javascript
description: 'La meilleure plateforme pour la vente de billets et la gestion d\'événements.',
```

---

### **3. Social Media Links ändern**

**Datei:** `resources/js/components/Footer.vue` (Zeilen 15-26)

Ersetze die `href="#"` mit deinen echten Social Media URLs:

```vue
<!-- Facebook -->
<a href="https://facebook.com/tix4me" class="...">

<!-- Twitter -->
<a href="https://twitter.com/tix4me" class="...">

<!-- Instagram -->
<a href="https://instagram.com/ciema_4me" class="...">

<!-- LinkedIn -->
<a href="https://linkedin.com/company/tix4me" class="...">
```

---

### **4. Footer-Links ändern**

**Datei:** `resources/js/components/Footer.vue`

Alle Links sind mit `href="#"` gekennzeichnet. Ersetze diese mit deinen echten URLs:

**Beispiel - Über uns Sektion (Zeilen 32-35):**
```vue
<li><a href="/about">Über Tix4me</a></li>
<li><a href="/team">Unser Team</a></li>
<li><a href="/careers">Karriere</a></li>
<li><a href="/blog">Blog</a></li>
```

**Beispiel - Kontakt Sektion (Zeilen 38-41):**
```vue
<li><a href="/contact">Kontakt</a></li>
<li><a href="/faq">FAQ</a></li>
<li><a href="/support">Support</a></li>
<li><a href="/feedback">Feedback</a></li>
```

**Beispiel - Legal Sektion (Zeilen 44-47):**
```vue
<li><a href="/privacy">Datenschutz</a></li>
<li><a href="/terms">Nutzungsbedingungen</a></li>
<li><a href="/cookies">Cookies</a></li>
<li><a href="/impressum">Impressum</a></li>
```

---

### **5. Copyright-Text ändern**

**Datei:** `resources/js/i18n.js`

**Deutsch (Zeile ~112):**
```javascript
copyright: '© 2024 Tix4me. Alle Rechte vorbehalten.',
```

**Englisch (Zeile ~229):**
```javascript
copyright: '© 2024 Tix4me. All rights reserved.',
```

**Französisch (Zeile ~351):**
```javascript
copyright: '© 2024 Tix4me. Tous droits réservés.',
```

---

## 🌍 Mehrsprachigkeit

Der Footer unterstützt automatisch 3 Sprachen:
- **Deutsch** (de)
- **Englisch** (en)
- **Französisch** (fr)

Alle Texte werden über die i18n-Datei verwaltet. Wenn du einen Text änderst, musst du ihn in allen 3 Sprachen aktualisieren.

**Datei:** `resources/js/i18n.js`

---

## 🎨 Styling anpassen

Der Footer verwendet Tailwind CSS. Hier sind die wichtigsten CSS-Klassen:

- `bg-dark-900` - Dunkler Hintergrund
- `text-white` - Weiße Überschriften
- `text-gray-400` - Graue Texte
- `hover:text-primary-400` - Rote Hover-Effekte
- `transition-colors duration-200` - Smooth Übergänge

**Datei:** `resources/js/components/Footer.vue`

Beispiel - Hintergrundfarbe ändern:
```vue
<footer class="bg-dark-900 border-t border-primary-900/30 mt-20">
                    ↑ Ändere diese Klasse
```

---

## 📱 Responsive Design

Der Footer ist vollständig responsive:
- **Desktop:** 4 Spalten
- **Tablet/Mobile:** 1 Spalte

Dies wird durch Tailwind CSS Grid automatisch gehandhabt:
```vue
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
```

---

## 🔗 Zusammenfassung der Dateien

| Datei | Zweck |
|-------|-------|
| `resources/js/components/Footer.vue` | HTML-Struktur und Layout |
| `resources/js/i18n.js` | Übersetzungen und Texte |
| `tailwind.config.js` | Farben und Styling |

---

## 💡 Tipps

1. **Immer alle 3 Sprachen aktualisieren** - Wenn du einen Text in der i18n.js änderst
2. **Links testen** - Nach dem Ändern von Links, teste sie im Browser
3. **Social Media Icons** - Die Icons sind SVG und können farblich angepasst werden
4. **Mobile testen** - Überprüfe den Footer auf Mobilgeräten

---

## 🚀 Nächste Schritte

Nach der Anpassung des Footers:
1. Speichere die Dateien
2. Der Vite Dev Server lädt automatisch neu
3. Öffne http://localhost:8000 im Browser
4. Überprüfe den Footer auf allen Seiten
5. Teste die Mehrsprachigkeit (Sprachumschalter oben rechts)

---

**Fragen?** Überprüfe die Dateistruktur oder kontaktiere den Support.

