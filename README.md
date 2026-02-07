# Gestione Prenotazioni - AlloggiatiWeb

Sistema di gestione prenotazioni per strutture ricettive con integrazione AlloggiatiWeb.

## Requisiti

- PHP 8.2+
- MySQL 5.7+
- Composer
- Estensione PHP SOAP

## Installazione con Docker

```bash
docker-compose up -d
docker exec -it bt_laravel_app composer install
docker exec -it bt_laravel_app php artisan key:generate
docker exec -it bt_laravel_app php artisan migrate:fresh --seed
```

Accedi a: http://localhost:8000

## Credenziali Admin

- **Email**: admin@example.com
- **Password**: password

## Funzionalità

1. **Sincronizzazione iCal** - Importa prenotazioni da Booking, Airbnb, etc.
2. **Check-in Online** - Form pubblica per raccolta dati ospiti
3. **AlloggiatiWeb** - Invio automatico alla Polizia di Stato
4. **Notifiche Email** - Avvisi per admin e ospiti

## Cron Job

```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Comandi

```bash
php artisan ical:sync              # Sincronizza calendari
php artisan alloggiatiweb:send     # Invia dati ad AlloggiatiWeb
```
