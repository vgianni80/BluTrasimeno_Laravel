<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    protected array $settingKeys = [
        'property_name', 'property_address', 'property_phone', 'checkin_instructions',
        'admin_email', 'email_from_name', 'email_from_address',
        'checkin_link_expiry_days', 'send_time',
        'alloggiatiweb_enabled', 'alloggiatiweb_wsdl_url', 'alloggiatiweb_username',
        'alloggiatiweb_password', 'alloggiatiweb_ws_key', 'alloggiatiweb_property_id',
    ];

    public function index()
    {
        $settings = [];
        foreach ($this->settingKeys as $key) {
            $settings[$key] = Setting::get($key);
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'property_name' => 'nullable|string|max:255',
            'property_address' => 'nullable|string|max:500',
            'property_phone' => 'nullable|string|max:50',
            'checkin_instructions' => 'nullable|string',
            'admin_email' => 'nullable|email',
            'email_from_name' => 'nullable|string|max:255',
            'email_from_address' => 'nullable|email',
            'checkin_link_expiry_days' => 'nullable|integer|min:1|max:365',
            'send_time' => 'nullable|string',
            'alloggiatiweb_enabled' => 'nullable',
            'alloggiatiweb_wsdl_url' => 'nullable|url',
            'alloggiatiweb_username' => 'nullable|string|max:255',
            'alloggiatiweb_password' => 'nullable|string|max:255',
            'alloggiatiweb_ws_key' => 'nullable|string|max:255',
            'alloggiatiweb_property_id' => 'nullable|string|max:255',
        ]);

        $validated['alloggiatiweb_enabled'] = $request->has('alloggiatiweb_enabled') ? '1' : '0';

        foreach ($validated as $key => $value) {
            $type = match($key) {
                'alloggiatiweb_enabled' => 'boolean',
                'checkin_link_expiry_days' => 'integer',
                default => 'string'
            };
            Setting::set($key, $value ?? '', $type);
        }

        // Clear caches
        foreach ($this->settingKeys as $key) {
            Cache::forget("setting_{$key}");
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Impostazioni salvate!');
    }

    public function testAlloggiatiweb(Request $request)
    {
        try {
            $wsdlUrl = $request->input('wsdl_url');
            
            if (empty($wsdlUrl)) {
                return response()->json(['success' => false, 'message' => 'URL WSDL mancante']);
            }

            $client = new \SoapClient($wsdlUrl, [
                'trace' => true,
                'exceptions' => true,
                'connection_timeout' => 30,
            ]);

            $functions = $client->__getFunctions();

            return response()->json([
                'success' => true,
                'message' => 'Connessione riuscita! ' . count($functions) . ' funzioni disponibili.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore: ' . $e->getMessage()
            ]);
        }
    }
}
