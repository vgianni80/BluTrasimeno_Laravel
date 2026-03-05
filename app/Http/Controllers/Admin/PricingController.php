<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LengthDiscount;
use App\Models\PricingRule;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Mostra la pagina principale di gestione tariffe
     */
    public function index()
    {
        $rules = PricingRule::orderBy('priority', 'desc')->orderBy('name')->get();
        $discounts = LengthDiscount::orderBy('min_nights')->get();

        return view('admin.pricing.index', compact('rules', 'discounts'));
    }

    /**
     * Mostra il form per creare una nuova regola
     */
    public function createRule()
    {
        return view('admin.pricing.rules.create');
    }

    /**
     * Salva una nuova regola tariffaria
     */
    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:base,seasonal,weekend,special',
            'price_per_night' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'integer|between:0,6',
            'priority' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        // Prepara i dati
        $data = [
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price_per_night' => $validated['price_per_night'],
            'priority' => $validated['priority'],
            'is_active' => $request->has('is_active'),
        ];

        // Aggiungi date solo se il tipo lo richiede
        if (in_array($validated['type'], ['seasonal', 'special'])) {
            $data['start_date'] = $validated['start_date'] ?? null;
            $data['end_date'] = $validated['end_date'] ?? null;
        }

        // Aggiungi giorni della settimana solo se il tipo lo richiede
        if ($validated['type'] === 'weekend') {
            $data['days_of_week'] = $validated['days_of_week'] ?? null;
        }

        PricingRule::create($data);

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Regola tariffaria creata con successo!');
    }

    /**
     * Mostra il form per modificare una regola
     */
    public function editRule(PricingRule $pricingRule)
    {
        return view('admin.pricing.rules.edit', compact('pricingRule'));
    }

    /**
     * Aggiorna una regola tariffaria esistente
     */
    public function updateRule(Request $request, PricingRule $pricingRule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:base,seasonal,weekend,special',
            'price_per_night' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'integer|between:0,6',
            'priority' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        // Prepara i dati
        $data = [
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price_per_night' => $validated['price_per_night'],
            'priority' => $validated['priority'],
            'is_active' => $request->has('is_active'),
            'start_date' => null,
            'end_date' => null,
            'days_of_week' => null,
        ];

        // Aggiungi date solo se il tipo lo richiede
        if (in_array($validated['type'], ['seasonal', 'special'])) {
            $data['start_date'] = $validated['start_date'] ?? null;
            $data['end_date'] = $validated['end_date'] ?? null;
        }

        // Aggiungi giorni della settimana solo se il tipo lo richiede
        if ($validated['type'] === 'weekend') {
            $data['days_of_week'] = $validated['days_of_week'] ?? null;
        }

        $pricingRule->update($data);

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Regola tariffaria aggiornata!');
    }

    /**
     * Elimina una regola tariffaria
     */
    public function destroyRule(PricingRule $pricingRule)
    {
        $pricingRule->delete();

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Regola tariffaria eliminata!');
    }

    /**
     * Salva un nuovo sconto per durata
     */
    public function storeDiscount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_nights' => 'required|integer|min:2',
            'discount_percent' => 'required|numeric|min:0.5|max:100',
        ]);

        LengthDiscount::create([
            'name' => $validated['name'],
            'min_nights' => $validated['min_nights'],
            'discount_percent' => $validated['discount_percent'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Sconto creato con successo!');
    }

    /**
     * Elimina uno sconto per durata
     */
    public function destroyDiscount(LengthDiscount $lengthDiscount)
    {
        $lengthDiscount->delete();

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Sconto eliminato!');
    }

    /**
     * Attiva/disattiva uno sconto
     */
    public function toggleDiscount(LengthDiscount $lengthDiscount)
    {
        $lengthDiscount->update([
            'is_active' => !$lengthDiscount->is_active,
        ]);

        $status = $lengthDiscount->is_active ? 'attivato' : 'disattivato';

        return redirect()->route('admin.pricing.index')
            ->with('success', "Sconto {$status}!");
    }
}
