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
        <h4 class="mb-0">
            Prenotazione #<?php echo e($booking->id); ?>

            <?php echo $__env->make('admin.bookings._status-badge', ['status' => $booking->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </h4>
        <div>
            <a href="<?php echo e(route('admin.bookings.edit', $booking)); ?>" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-2"></i>Modifica
            </a>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Indietro
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Dettagli prenotazione -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-calendar-check me-2"></i>Dettagli Soggiorno</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Check-in</label>
                            <div class="fw-bold"><?php echo e($booking->check_in->format('d/m/Y')); ?></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Check-out</label>
                            <div class="fw-bold"><?php echo e($booking->check_out->format('d/m/Y')); ?></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Notti</label>
                            <div class="fw-bold"><?php echo e($booking->nights); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Ospite Principale</label>
                            <div class="fw-bold"><?php echo e($booking->full_guest_name ?: 'N/D'); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <div><?php echo e($booking->guest_email ?: 'N/D'); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Telefono</label>
                            <div><?php echo e($booking->guest_phone ?: 'N/D'); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Fonte</label>
                            <div><?php echo e($booking->icalSource?->name ?? 'Manuale'); ?></div>
                        </div>
                    </div>
                    <?php if($booking->notes): ?>
                        <hr>
                        <label class="text-muted small">Note</label>
                        <div><?php echo e($booking->notes); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ospiti registrati -->
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-people me-2"></i>Ospiti Registrati (<?php echo e($booking->guests->count()); ?>)</div>
                <div class="card-body p-0">
                    <?php if($booking->guests->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Nascita</th>
                                        <th>Documento</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $booking->guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($guest->nome_completo); ?>

                                                <?php if($guest->is_capogruppo): ?>
                                                    <span class="badge bg-primary">Capogruppo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($guest->data_nascita->format('d/m/Y')); ?><br><small class="text-muted"><?php echo e($guest->comune_nascita); ?></small></td>
                                            <td><?php echo e($guest->numero_documento); ?></td>
                                            <td><?php echo e(ucfirst(str_replace('_', ' ', $guest->tipo_documento))); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4 mb-0">Nessun ospite registrato</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Log AlloggiatiWeb -->
            <?php if($booking->alloggiatiwebLogs->count() > 0): ?>
            <div class="card">
                <div class="card-header"><i class="bi bi-journal-text me-2"></i>Log Invii</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead><tr><th>Data</th><th>Stato</th><th>Messaggio</th></tr></thead>
                            <tbody>
                                <?php $__currentLoopData = $booking->alloggiatiwebLogs->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($log->sent_at->format('d/m/Y H:i')); ?></td>
                                        <td>
                                            <?php if($log->status === 'success'): ?>
                                                <span class="badge bg-success">OK</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Errore</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><small><?php echo e(Str::limit($log->error_message, 50)); ?></small></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Azioni -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-lightning me-2"></i>Azioni</div>
                <div class="card-body">
                    <?php if($booking->checkin_token): ?>
                        <div class="mb-3">
                            <label class="text-muted small">Link Check-in</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" value="<?php echo e($booking->getCheckinUrl()); ?>" id="checkinUrl" readonly>
                                <button class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('checkinUrl').value); alert('Copiato!')">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                            <?php if($booking->checkin_link_expires_at): ?>
                                <small class="text-muted">Scade: <?php echo e($booking->checkin_link_expires_at->format('d/m/Y')); ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!$booking->checkin_token && $booking->status === 'incomplete'): ?>
                        <form method="POST" action="<?php echo e(route('admin.bookings.generate-link', $booking)); ?>" class="mb-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-link-45deg me-2"></i>Genera Link Check-in
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($booking->guest_email && $booking->checkin_token): ?>
                        <form method="POST" action="<?php echo e(route('admin.bookings.send-checkin-email', $booking)); ?>" class="mb-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-envelope me-2"></i>Invia Email Check-in
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if(in_array($booking->status, ['checked_in', 'failed'])): ?>
                        <form method="POST" action="<?php echo e(route('admin.bookings.resend-alloggiatiweb', $booking)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-arrow-repeat me-2"></i>Reinvia ad AlloggiatiWeb
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($booking->last_error): ?>
                        <div class="alert alert-danger mt-3 mb-0">
                            <small><strong>Ultimo errore:</strong><br><?php echo e($booking->last_error); ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Elimina -->
            <div class="card border-danger">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" onsubmit="return confirm('Eliminare questa prenotazione?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Elimina Prenotazione
                        </button>
                    </form>
                </div>
            </div>
        </div>
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
<?php /**PATH /var/www/html/resources/views/admin/bookings/show.blade.php ENDPATH**/ ?>