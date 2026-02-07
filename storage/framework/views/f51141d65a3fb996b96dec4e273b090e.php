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
    <h4 class="mb-4">Log Invii AlloggiatiWeb</h4>

    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <option value="">Tutti gli stati</option>
                    <option value="success" <?php echo e(request('status') === 'success' ? 'selected' : ''); ?>>Successo</option>
                    <option value="failed" <?php echo e(request('status') === 'failed' ? 'selected' : ''); ?>>Errore</option>
                </select>
            </form>
        </div>
        <div class="card-body p-0">
            <?php if($logs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Data/Ora</th>
                                <th>Prenotazione</th>
                                <th>Stato</th>
                                <th>Messaggio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($log->sent_at->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <?php if($log->booking): ?>
                                            <a href="<?php echo e(route('admin.bookings.show', $log->booking)); ?>">
                                                #<?php echo e($log->booking_id); ?> - <?php echo e($log->booking->full_guest_name); ?>

                                            </a>
                                        <?php else: ?>
                                            #<?php echo e($log->booking_id); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($log->status === 'success'): ?>
                                            <span class="badge bg-success">OK</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Errore</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small><?php echo e(Str::limit($log->error_message, 80)); ?></small></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted text-center py-5 mb-0">Nessun log trovato</p>
            <?php endif; ?>
        </div>
        <?php if($logs->hasPages()): ?>
            <div class="card-footer"><?php echo e($logs->withQueryString()->links()); ?></div>
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
<?php /**PATH /var/www/html/resources/views/admin/logs/index.blade.php ENDPATH**/ ?>