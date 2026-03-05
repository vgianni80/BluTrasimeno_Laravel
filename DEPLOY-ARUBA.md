# Guida Deploy su Aruba - Blu Trasimeno Booking System

## Panoramica

Questa guida ti aiuterà a installare il sistema di prenotazioni Laravel sul tuo hosting Aruba, affiancandolo al sito WordPress esistente.

**Struttura finale:**
- `www.blutrasimeno.it` → WordPress (vetrina)
- `www.blutrasimeno.it/prenota` → Laravel (prenotazioni)
- `www.blutrasimeno.it/checkin/{token}` → Laravel (check-in ospiti)
- `www.blutrasimeno.it/admin` → Laravel (pannello admin)

---

## Requisiti Aruba

Verifica che il tuo hosting abbia:
- PHP 8.1 o superiore
- MySQL 5.7 o superiore
- Estensione PHP: pdo_mysql, mbstring, xml, zip, soap, curl
- Accesso SSH (consigliato) o File Manager

---

## STEP 1: Preparazione Database

### 1.1 Crea un nuovo database su Aruba

1. Accedi al pannello Aruba → **Hosting Linux** → **Database MySQL**
2. Crea un nuovo database (es. `blutrasimeno_booking`)
3. Annota:
   - Nome database: `blutrasimeno_booking`
   - Username: (quello che crei)
   - Password: (quella che crei)
   - Host: `localhost` (di solito) o l'host fornito da Aruba

---

## STEP 2: Upload dei File

### 2.2 Struttura cartelle

La struttura sul server sarà:

```
/htdocs/ (o public_html/)
├── index.php              ← WordPress
├── wp-admin/
├── wp-content/
├── wp-includes/
├── prenota/               ← Laravel PUBLIC (solo questa cartella)
│   ├── index.php
│   ├── .htaccess
│   └── ... (altri file public)
│
└── booking-app/           ← Laravel APP (FUORI dalla cartella pubblica!)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── ...
```

### 2.3 Passaggi Upload

**Via FTP o File Manager:**

1. **Estrai lo ZIP** sul tuo computer

2. **Crea la cartella `booking-app`** nella root (stesso livello di htdocs, NON dentro):
   ```
   /home/tuousername/booking-app/
   ```

3. **Carica TUTTO il contenuto dello ZIP** in `booking-app/` ECCETTO la cartella `public/`

4. **Crea la cartella `prenota`** dentro htdocs:
   ```
   /htdocs/prenota/
   ```

5. **Carica il contenuto della cartella `public/`** dentro `prenota/`

---

## STEP 3: Configurazione Laravel

### 3.1 Modifica il file prenota/index.php

Modifica `/htdocs/prenota/index.php` per puntare alla cartella corretta:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determina se l'app è in manutenzione
if (file_exists($maintenance = __DIR__.'/../booking-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// IMPORTANTE: Modifica questo percorso!
require __DIR__.'/../booking-app/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../booking-app/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

**NOTA:** Se `booking-app` è in un percorso diverso (es. `/home/tuousername/booking-app`), usa il percorso assoluto.

### 3.2 Configura il file .env

Copia `.env.example` in `.env` nella cartella `booking-app/` e modifica:

```env
APP_NAME="Blu Trasimeno"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://www.blutrasimeno.it

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=blutrasimeno_booking
DB_USERNAME=tuo_username_db
DB_PASSWORD=tua_password_db

SESSION_DRIVER=file
CACHE_STORE=file

MAIL_MAILER=smtp
MAIL_HOST=smtps.aruba.it
MAIL_PORT=465
MAIL_USERNAME=tua_email@blutrasimeno.it
MAIL_PASSWORD=tua_password_email
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@blutrasimeno.it
MAIL_FROM_NAME="Blu Trasimeno"
```

### 3.3 Modifica bootstrap/app.php (opzionale ma consigliato)

Se hai problemi con i percorsi, modifica `booking-app/bootstrap/app.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Imposta la cartella public personalizzata
$app->usePublicPath(realpath(__DIR__.'/../../htdocs/prenota'));

return $app;
```

---

## STEP 4: Installazione Dipendenze

### 4.1 Via SSH (metodo consigliato)

```bash
# Connettiti via SSH
ssh tuousername@tuoserver.aruba.it

# Vai nella cartella Laravel
cd /home/tuousername/booking-app

# Installa dipendenze
php composer.phar install --no-dev --optimize-autoloader

# Genera la chiave
php artisan key:generate

# Esegui le migrazioni
php artisan migrate --force

# Popola i dati iniziali
php artisan db:seed --force

# Ottimizza
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Imposta permessi
chmod -R 775 storage bootstrap/cache
```

### 4.2 Via Terminale Aruba (se non hai SSH)

Se il tuo piano non include SSH, puoi usare il terminale web di Aruba (se disponibile) oppure:

1. Scarica Composer localmente
2. Esegui `composer install` sul tuo PC
3. Carica la cartella `vendor/` via FTP (può essere lento)

---

## STEP 5: Configurazione .htaccess

### 5.1 File .htaccess in /htdocs/prenota/

Il file dovrebbe già esistere, ma verifica che contenga:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Gestisci Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Rimuovi trailing slash
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Invia tutto a index.php
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 5.2 File .htaccess nella root (opzionale)

Se le route `/checkin/` e `/admin/` non funzionano, aggiungi nel `.htaccess` principale di WordPress:

```apache
# Redirect Laravel routes
RewriteEngine On
RewriteRule ^checkin/(.*)$ /prenota/index.php [L]
RewriteRule ^admin/(.*)$ /prenota/index.php [L]
```

---

## STEP 6: Configurazione WordPress

### 6.1 Aggiorna il link "Prenota" nel menu

Nel tuo tema WordPress, il link "Prenota" dovrebbe già puntare a `/prenota/`. Verifica che funzioni.

### 6.2 (Opzionale) Crea una pagina redirect

Se preferisci avere una pagina WordPress che fa redirect:

1. Crea una pagina "Prenota" in WordPress
2. Usa un plugin come "Redirection" per fare redirect a `/prenota/`

---

## STEP 7: Configurazione Cron Job

Per la sincronizzazione automatica iCal e l'invio ad AlloggiatiWeb, configura un cron job.

### Su Aruba:

1. Vai nel pannello → **Hosting Linux** → **Cron Job**
2. Aggiungi:
   - Comando: `php /percorso/completo/booking-app/artisan schedule:run >> /dev/null 2>&1`
   - Frequenza: Ogni minuto (o ogni 5 minuti)

Esempio comando completo:
```bash
/usr/bin/php8.2 /home/tuousername/booking-app/artisan schedule:run >> /dev/null 2>&1
```

---

## STEP 8: Verifica Installazione

### 8.1 Test pagine

1. **Pagina prenotazione:** `https://www.blutrasimeno.it/prenota/`
2. **Pagina admin:** `https://www.blutrasimeno.it/prenota/login`
   - Email: `admin@example.com`
   - Password: `password`
3. **CAMBIA SUBITO LA PASSWORD ADMIN!**

### 8.2 Test email

1. Vai in Admin → Impostazioni
2. Configura l'email admin
3. Crea una prenotazione di test
4. Verifica che le email arrivino

---

## STEP 9: Configurazione Finale

### 9.1 Impostazioni in Admin

Accedi a `/prenota/admin/settings` e configura:

- **Nome Struttura:** Blu Trasimeno
- **Indirizzo:** Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG)
- **Telefono:** Il tuo numero
- **Email Admin:** La tua email per le notifiche
- **Istruzioni Check-in:** Come arrivare, ritiro chiavi, ecc.

### 9.2 Configura le Tariffe

Vai in Admin → Tariffe e crea le regole per:
- Alta stagione (estate)
- Bassa stagione
- Festività
- Sconti per soggiorni lunghi

### 9.3 Aggiungi Fonti iCal

Vai in Admin → Fonti iCal e aggiungi:
- URL iCal di Holidu
- URL iCal di Booking.com (se lo usi)
- URL iCal di Airbnb (se lo usi)

---

## Troubleshooting

### Errore 500
- Controlla i permessi di `storage/` e `bootstrap/cache/` (775)
- Verifica il file di log: `storage/logs/laravel.log`
- Controlla che il percorso in `index.php` sia corretto

### Pagina bianca
- Abilita temporaneamente `APP_DEBUG=true` nel `.env`
- Controlla i log

### Email non funzionano
- Verifica le credenziali SMTP nel `.env`
- Su Aruba usa: `smtps.aruba.it` porta `465` con SSL

### Route non trovate
- Esegui: `php artisan route:clear && php artisan route:cache`
- Verifica il file `.htaccess`

### Errori database
- Verifica le credenziali nel `.env`
- Prova a connetterti via phpMyAdmin con le stesse credenziali

---

## Backup

Ricorda di fare backup regolari di:
1. Database MySQL
2. Cartella `storage/` (contiene i log)
3. File `.env` (contiene le configurazioni)

---

## Supporto

Per problemi specifici:
1. Controlla sempre `storage/logs/laravel.log`
2. Abilita `APP_DEBUG=true` temporaneamente per vedere gli errori
3. Verifica i permessi delle cartelle

Buon lavoro! 🏠
