<?php
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
?>
<span class="badge <?php echo e($classes); ?>"><?php echo e($labels[$status] ?? $status); ?></span>
<?php /**PATH /var/www/html/resources/views/admin/bookings/_status-badge.blade.php ENDPATH**/ ?>