<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Prenotazioni</h4>
        <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Nuova
        </a>
    </div>

    <!-- Filtri -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tutti gli stati</option>
                        <option value="incomplete" <?php echo e(request('status') === 'incomplete' ? 'selected' : ''); ?>>Da completare</option>
                        <option value="complete" <?php echo e(request('status') === 'complete' ? 'selected' : ''); ?>>In attesa</option>
                        <option value="checked_in" <?php echo e(request('status') === 'checked_in' ? 'selected' : ''); ?>>Check-in OK</option>
                        <option value="sent" <?php echo e(request('status') === 'sent' ? 'selected' : ''); ?>>Inviato</option>
                        <option value="failed" <?php echo e(request('status') === 'failed' ? 'selected' : ''); ?>>Errore</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cerca ospite..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtra</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabella -->
    <div class="card">
        <div class="card-body p-0">
            <?php if($bookings->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Ospite</th>
                                <th>Ospiti</th>
                                <th>Fonte</th>
                                <th>Stato</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($booking->check_in->format('d/m/Y')); ?></td>
                                    <td><?php echo e($booking->check_out->format('d/m/Y')); ?></td>
                                    <td>
                                        <strong><?php echo e($booking->full_guest_name ?: 'N/D'); ?></strong>
                                        <?php if($booking->guest_email): ?>
                                            <br><small class="text-muted"><?php echo e($booking->guest_email); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($booking->guests->count() ?: ($booking->number_of_guests ?: '-')); ?></td>
                                    <td>
                                        <?php if($booking->icalSource): ?>
                                            <small><?php echo e($booking->icalSource->name); ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">Manuale</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $__env->make('admin.bookings._status-badge', ['status' => $booking->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted text-center py-5 mb-0">Nessuna prenotazione trovata</p>
            <?php endif; ?>
        </div>
        <?php if($bookings->hasPages()): ?>
            <div class="card-footer"><?php echo e($bookings->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/admin/bookings/index.blade.php ENDPATH**/ ?>