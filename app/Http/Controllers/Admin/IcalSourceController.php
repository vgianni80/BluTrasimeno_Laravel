<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IcalSource;
use App\Services\IcalSyncService;
use Illuminate\Http\Request;

class IcalSourceController extends Controller
{
    public function index()
    {
        $icalSources = IcalSource::withCount('bookings')
            ->orderBy('name')
            ->get();

        return view('admin.ical-sources.index', compact('icalSources'));
    }

    public function create()
    {
        return view('admin.ical-sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'polling_frequency_minutes' => 'required|integer|min:15',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        IcalSource::create($validated);

        return redirect()->route('admin.ical-sources.index')
            ->with('success', 'Calendario iCal aggiunto!');
    }

    public function edit(IcalSource $icalSource)
    {
        return view('admin.ical-sources.edit', compact('icalSource'));
    }

    public function update(Request $request, IcalSource $icalSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'polling_frequency_minutes' => 'required|integer|min:15',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $icalSource->update($validated);

        return redirect()->route('admin.ical-sources.index')
            ->with('success', 'Calendario aggiornato!');
    }

    public function destroy(IcalSource $icalSource)
    {
        $icalSource->delete();
        return redirect()->route('admin.ical-sources.index')
            ->with('success', 'Calendario eliminato!');
    }

    public function sync(IcalSource $icalSource, IcalSyncService $service)
    {
        $log = $service->syncSource($icalSource);

        if ($log->status === 'success') {
            $msg = "Sincronizzato! Trovate {$log->bookings_found} prenotazioni, {$log->bookings_created} nuove.";
            return back()->with('success', $msg);
        } else {
            return back()->with('error', "Errore: {$log->message}");
        }
    }
}
