<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f4f6f9; }
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e3a5f 0%, #0d2137 100%);
            color: white; z-index: 1000; overflow-y: auto;
        }
        .sidebar-brand { padding: 1.5rem; font-size: 1.25rem; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-nav { padding: 1rem 0; }
        .sidebar-nav a {
            display: flex; align-items: center; padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.7); text-decoration: none; transition: all 0.2s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active { color: white; background: rgba(255,255,255,0.1); }
        .sidebar-nav a i { width: 24px; margin-right: 10px; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .top-bar { background: white; padding: 1rem 1.5rem; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 1.5rem; }
        .stats-card { background: white; border-radius: 0.5rem; padding: 1.25rem; border-left: 4px solid; }
        .stats-card.warning { border-color: #ffc107; }
        .stats-card.info { border-color: #17a2b8; }
        .stats-card.success { border-color: #28a745; }
        .stats-card.danger { border-color: #dc3545; }
        .stats-card.primary { border-color: #007bff; }
        .stats-card h3 { font-size: 1.75rem; margin: 0; }
        .stats-card p { margin: 0; color: #6c757d; font-size: 0.875rem; }
        .card { border: none; box-shadow: 0 0 10px rgba(0,0,0,0.05); border-radius: 0.5rem; }
        .card-header { background: white; border-bottom: 1px solid #e9ecef; font-weight: 600; }
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-house-door me-2"></i><?php echo e(config('app.name')); ?>

        </div>
        <div class="sidebar-nav">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="<?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>">
                <i class="bi bi-calendar-check"></i> Prenotazioni
            </a>
            <a href="<?php echo e(route('admin.ical-sources.index')); ?>" class="<?php echo e(request()->routeIs('admin.ical-sources.*') ? 'active' : ''); ?>">
                <i class="bi bi-cloud-download"></i> Fonti iCal
            </a>
            <a href="<?php echo e(route('admin.logs.index')); ?>" class="<?php echo e(request()->routeIs('admin.logs.*') ? 'active' : ''); ?>">
                <i class="bi bi-journal-text"></i> Log Invii
            </a>
            <a href="<?php echo e(route('admin.settings.index')); ?>" class="<?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                <i class="bi bi-gear"></i> Impostazioni
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <button class="btn btn-link d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="ms-auto">
                <span class="me-3"><?php echo e(Auth::user()->name); ?></span>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Esci
                    </button>
                </form>
            </div>
        </div>

        <div class="content">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo e($slot); ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/components/app-layout.blade.php ENDPATH**/ ?>