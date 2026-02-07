<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Ottiene un valore di configurazione
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * Imposta un valore di configurazione
     */
    public static function set(string $key, mixed $value, string $type = 'string'): void
    {
        $storedValue = match ($type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $storedValue, 'type' => $type]
        );

        Cache::forget("setting_{$key}");
    }

    /**
     * Definisce le impostazioni di default
     */
    public static function getDefaults(): array
    {
        return [
            // AlloggiatiWeb
            ['key' => 'alloggiatiweb_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'alloggiatiweb', 'label' => 'Abilita invio AlloggiatiWeb'],
            ['key' => 'alloggiatiweb_wsdl_url', 'value' => 'https://alloggiatiweb.poliziadistato.it/service/service.asmx?wsdl', 'type' => 'string', 'group' => 'alloggiatiweb', 'label' => 'URL WSDL'],
            ['key' => 'alloggiatiweb_username', 'value' => '', 'type' => 'string', 'group' => 'alloggiatiweb', 'label' => 'Username'],
            ['key' => 'alloggiatiweb_password', 'value' => '', 'type' => 'string', 'group' => 'alloggiatiweb', 'label' => 'Password'],
            ['key' => 'alloggiatiweb_ws_key', 'value' => '', 'type' => 'string', 'group' => 'alloggiatiweb', 'label' => 'Chiave WS'],
            ['key' => 'alloggiatiweb_property_id', 'value' => '', 'type' => 'string', 'group' => 'alloggiatiweb', 'label' => 'Codice Struttura'],
            
            // Email
            ['key' => 'admin_email', 'value' => '', 'type' => 'string', 'group' => 'email', 'label' => 'Email Admin'],
            ['key' => 'email_from_name', 'value' => 'Gestione Prenotazioni', 'type' => 'string', 'group' => 'email', 'label' => 'Nome Mittente'],
            ['key' => 'email_from_address', 'value' => '', 'type' => 'string', 'group' => 'email', 'label' => 'Email Mittente'],
            
            // Struttura
            ['key' => 'property_name', 'value' => '', 'type' => 'string', 'group' => 'property', 'label' => 'Nome Struttura'],
            ['key' => 'property_address', 'value' => '', 'type' => 'string', 'group' => 'property', 'label' => 'Indirizzo'],
            ['key' => 'property_phone', 'value' => '', 'type' => 'string', 'group' => 'property', 'label' => 'Telefono'],
            ['key' => 'checkin_instructions', 'value' => '', 'type' => 'string', 'group' => 'property', 'label' => 'Istruzioni Check-in'],
            
            // Generale
            ['key' => 'checkin_link_expiry_days', 'value' => '30', 'type' => 'integer', 'group' => 'general', 'label' => 'Scadenza Link Check-in (giorni)'],
            ['key' => 'send_time', 'value' => '06:00', 'type' => 'string', 'group' => 'general', 'label' => 'Orario Invio AlloggiatiWeb'],
        ];
    }
}
