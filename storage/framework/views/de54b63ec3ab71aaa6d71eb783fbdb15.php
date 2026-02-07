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
    <h4 class="mb-4">Dashboard</h4>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stats-card warning">
                <h3><?php echo e($stats['incomplete']); ?></h3>
                <p>Da completare</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card info">
                <h3><?php echo e($stats['complete']); ?></h3>
                <p>In attesa check-in</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card success">
                <h3><?php echo e($stats['checked_in'] + $stats['sent']); ?></h3>
                <p>Check-in OK</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card danger">
                <h3><?php echo e($stats['failed']); ?></h3>
                <p>Errori invio</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Check-in Oggi -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-event me-2"></i>Check-in Oggi
                </div>
                <div class="card-body p-0">
                    <?php if($todayBookings->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $todayBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <strong><?php echo e($booking->full_guest_name ?: 'N/D'); ?></strong>
                                        <?php echo $__env->make('admin.bookings._status-badge', ['status' => $booking->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                    <small class="text-muted"><?php echo e($booking->guests->count()); ?> ospiti</small>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4 mb-0">Nessun check-in oggi</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Da Completare -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle me-2"></i>Da Completare
                </div>
                <div class="card-body p-0">
                    <?php if($incompleteBookings->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $incompleteBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('admin.bookings.edit', $booking)); ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <strong><?php echo e($booking->full_guest_name ?: 'Ospite sconosciuto'); ?></strong>
                                        <span class="badge bg-secondary"><?php echo e($booking->check_in->format('d/m')); ?></span>
                                    </div>
                                    <?php if($booking->icalSource): ?>
                                        <small class="text-muted"><?php echo e($booking->icalSource->name); ?></small>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4 mb-0">Tutto in ordine!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Prossimi 7 giorni -->
    <?php if($upcomingBookings->count() > 0): ?>
    <div class="card mt-4">
        <div class="card-header">
            <i class="bi bi-calendar-week me-2"></i>Prossimi 7 Giorni
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Check-in</th>
                            <th>Ospite</th>
                            <th>Notti</th>
                            <th>Stato</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $upcomingBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($booking->check_in->format('d/m/Y')); ?></td>
                                <td><?php echo e($booking->full_guest_name ?: 'N/D'); ?></td>
                                <td><?php echo e($booking->nights); ?></td>
                                <td><?php echo $__env->make('admin.bookings._status-badge', ['status' => $booking->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                <td><a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="btn btn-sm btn-outline-primary">Dettagli</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
<?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>