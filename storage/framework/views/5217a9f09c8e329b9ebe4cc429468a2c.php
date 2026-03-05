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
        <h4 class="mb-0">Importa Prenotazioni da Holidu</h4>
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Indietro
        </a>
    </div>

    <?php if(session('import_result')): ?>
        <?php $result = session('import_result'); ?>
        <div class="alert alert-<?php echo e(($result['created'] + $result['updated']) > 0 ? 'success' : 'warning'); ?> mb-4">
            <strong>Import completato:</strong>
            <?php echo e($result['created']); ?> nuove prenotazioni create,
            <?php echo e($result['updated']); ?> aggiornate con dati finanziari,
            <?php echo e($result['skipped']); ?> saltate (CANCELLED o riga non valida).
            <?php if(count($result['errors'])): ?>
                <hr class="my-2">
                <strong>Avvisi:</strong>
                <ul class="mb-0 mt-1">
                    <?php $__currentLoopData = $result['errors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><small><?php echo e($err); ?></small></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-excel me-2"></i>Carica file Excel
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.bookings.import.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">File Excel Holidu (.xlsx)</label>
                            <input type="file"
                                   name="file"
                                   class="form-control <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept=".xlsx,.xls">
                            <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">
                                Esporta il file da <strong>Holidu › Rendiconti › Prenotazioni</strong> in formato Excel.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-2"></i>Importa
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informazioni</div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Il file deve contenere le seguenti colonne nell'ordine standard Holidu:</p>
                    <table class="table table-sm table-borderless small mb-0">
                        <tbody>
                            <tr><td class="text-muted pe-2">A</td><td>Booking ID</td></tr>
                            <tr><td class="text-muted pe-2">E</td><td>Channel</td></tr>
                            <tr><td class="text-muted pe-2">F</td><td>Guest Name</td></tr>
                            <tr><td class="text-muted pe-2">G–I</td><td>Nr. Adults / Children / Babies</td></tr>
                            <tr><td class="text-muted pe-2">K</td><td>Paid by Guest</td></tr>
                            <tr><td class="text-muted pe-2">L</td><td>Date of Booking</td></tr>
                            <tr><td class="text-muted pe-2">M–N</td><td>Check In / Check Out</td></tr>
                            <tr><td class="text-muted pe-2">O</td><td>Booking Status</td></tr>
                            <tr><td class="text-muted pe-2">P</td><td>Home Owner Payout</td></tr>
                            <tr><td class="text-muted pe-2">Q</td><td>VAT</td></tr>
                            <tr><td class="text-muted pe-2">R</td><td>Bookiply Commission</td></tr>
                            <tr><td class="text-muted pe-2">S</td><td>Channel Commission</td></tr>
                            <tr><td class="text-muted pe-2">T</td><td>Bookiply Processing Markup</td></tr>
                            <tr><td class="text-muted pe-2">X</td><td>Withheld amounts (Cedolare Secca)</td></tr>
                        </tbody>
                    </table>
                    <hr class="my-2">
                    <p class="text-muted small mb-0">
                        Le prenotazioni già presenti (stesso Booking ID o stessa data di check-in
                        e cognome ospite) vengono <strong>aggiornate</strong> con i dati finanziari
                        dell'Excel, senza sovrascrivere i dati anagrafici già compilati.
                        Le prenotazioni con stato <strong>CANCELLED</strong> vengono saltate.
                    </p>
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
<?php /**PATH /var/www/html/resources/views/admin/bookings/import.blade.php ENDPATH**/ ?>