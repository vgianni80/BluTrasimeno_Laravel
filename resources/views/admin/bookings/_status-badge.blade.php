@php
$classes = match($status) {
    'incomplete' => 'bg-warning text-dark',
    'complete' => 'bg-info',
    'checked_in' => 'bg-success',
    'sent' => 'bg-primary',
    'failed' => 'bg-danger',
    default => 'bg-secondary'
};
$labels = [
    'incomplete' => 'Da completare',
    'complete' => 'In attesa',
    'checked_in' => 'Check-in OK',
    'sent' => 'Inviato',
    'failed' => 'Errore',
];
@endphp
<span class="badge {{ $classes }}">{{ $labels[$status] ?? $status }}</span>
