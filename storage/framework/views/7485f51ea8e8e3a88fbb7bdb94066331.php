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
        <h4 class="mb-0">Fonti iCal</h4>
        <a href="<?php echo e(route('admin.ical-sources.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Aggiungi
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <?php if($icalSources->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Frequenza</th>
                                <th>Ultima Sync</th>
                                <th>Prenotazioni</th>
                                <th>Stato</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $icalSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($source->name); ?></strong>
                                        <br><small class="text-muted"><?php echo e(Str::limit($source->url, 40)); ?></small>
                                    </td>
                                    <td><?php echo e($source->polling_frequency_minutes); ?> min</td>
                                    <td>
                                        <?php if($source->last_synced_at): ?>
                                            <?php echo e($source->last_synced_at->diffForHumans()); ?>

                                        <?php else: ?>
                                            <span class="text-muted">Mai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($source->bookings_count); ?></td>
                                    <td>
                                        <?php if($source->is_active): ?>
                                            <span class="badge bg-success">Attivo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inattivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <form method="POST" action="<?php echo e(route('admin.ical-sources.sync', $source)); ?>" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-success" title="Sincronizza ora">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('admin.ical-sources.edit', $source)); ?>" class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('admin.ical-sources.destroy', $source)); ?>" 
                                                  onsubmit="return confirm('Eliminare questo calendario?')" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                    <p class="mt-3">Nessun calendario configurato</p>
                    <a href="<?php echo e(route('admin.ical-sources.create')); ?>" class="btn btn-primary">Aggiungi il primo</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Come funziona</div>
        <div class="card-body">
            <p>I calendari iCal vengono sincronizzati automaticamente in base alla frequenza impostata. Le nuove prenotazioni vengono create con stato "Da completare".</p>
            <p class="mb-0"><strong>Dove trovo l'URL?</strong></p>
            <ul class="mb-0">
                <li><strong>Booking.com:</strong> Extranet → Tariffe e disponibilità → Sincronizza calendari → Esporta</li>
                <li><strong>Airbnb:</strong> Calendario → Impostazioni → Esporta calendario</li>
            </ul>
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
<?php /**PATH /var/www/html/resources/views/admin/ical-sources/index.blade.php ENDPATH**/ ?>