


<?php $__env->startSection('title', 'Servicios'); ?>
<?php $__env->startSection('page-title', 'Catálogo de servicios'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid px-0">

    
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-semibold mb-1"
                style="font-family: 'Playfair Display', serif; color: var(--meraki-text);">
                Nuestros servicios
            </h2>
            <p class="mb-0 small" style="color: var(--meraki-muted);">
                Administra los tratamientos y servicios de Meraki Estudio de Belleza.
            </p>
        </div>

        <a href="<?php echo e(route('services.create')); ?>"
           class="btn text-white rounded-3 px-4 py-2"
           style="background: var(--meraki-primary);">
            <i class="bi bi-plus-lg me-2"></i>
            Nuevo servicio
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success border-0 rounded-3">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0 rounded-3">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="service-stat-icon">
                        <i class="bi bi-scissors"></i>
                    </div>
                    <div>
                        <small class="text-muted">Servicios registrados</small>
                        <h4 class="fw-semibold mb-0" style="color: var(--meraki-text);">
                            <?php echo e($services->total()); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="service-stat-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div>
                        <small class="text-muted">Categorías</small>
                        <h4 class="fw-semibold mb-0" style="color: var(--meraki-text);">
                            <?php echo e($categories->count()); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="service-stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <small class="text-muted">Servicios activos</small>
                        <h4 class="fw-semibold mb-0" style="color: var(--meraki-text);">
                            <?php echo e(\App\Models\Service::where('is_active', true)->count()); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">

            <form action="<?php echo e(route('services.index')); ?>" method="GET">
                <div class="row g-3">

                    <div class="col-lg-6">
                        <label class="form-label small fw-semibold">
                            Buscar servicio
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control border-start-0"
                                   placeholder="Nombre o descripción..."
                                   value="<?php echo e($search); ?>">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label small fw-semibold">
                            Categoría
                        </label>

                        <select name="category" class="form-select">
                            <option value="">Todas las categorías</option>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>"
                                    <?php echo e($category == $item ? 'selected' : ''); ?>>
                                    <?php echo e($item); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">
                        <button type="submit"
                                class="btn text-white rounded-3 flex-grow-1"
                                style="background: var(--meraki-primary);">
                            Filtrar
                        </button>

                        <a href="<?php echo e(route('services.index')); ?>"
                           class="btn btn-light rounded-3"
                           title="Limpiar filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-0">

            <div class="p-4 pb-3">
                <h5 class="fw-semibold mb-1" style="color: var(--meraki-text);">
                    Listado de servicios
                </h5>
                <small style="color: var(--meraki-muted);">
                    Consulta y administra el catálogo del estudio.
                </small>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead style="background: var(--meraki-ivory);">
                        <tr>
                            <th class="ps-4">Servicio</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold"
                                         style="color: var(--meraki-text);">
                                        <?php echo e($service->name); ?>

                                    </div>

                                    <?php if($service->description): ?>
                                        <small class="text-muted">
                                            <?php echo e(Str::limit($service->description, 65)); ?>

                                        </small>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="category-badge">
                                        <?php echo e($service->category ?: 'Sin categoría'); ?>

                                    </span>
                                </td>

                               
<td>
    <div class="fw-semibold" style="color: var(--meraki-primary-dark);">

        <?php
            $priceType = $service->price_type ?? 'fixed';
        ?>

        <?php if($priceType === 'fixed'): ?>

            <?php if($service->price !== null): ?>
                Q<?php echo e(number_format((float) $service->price, 2)); ?>

            <?php else: ?>
                <span class="text-muted">Sin precio</span>
            <?php endif; ?>

        <?php elseif($priceType === 'from'): ?>

            <?php if($service->price !== null): ?>
                Desde Q<?php echo e(number_format((float) $service->price, 2)); ?>

            <?php else: ?>
                <span class="text-muted">Por definir</span>
            <?php endif; ?>

        <?php elseif($priceType === 'variable'): ?>

            <span>Precio variable</span>

        <?php elseif($priceType === 'per_unit'): ?>

            <?php if($service->price !== null): ?>
                Q<?php echo e(number_format((float) $service->price, 2)); ?>

                <small class="text-muted fw-normal">
                    / <?php echo e($service->price_unit ?: 'unidad'); ?>

                </small>
            <?php else: ?>
                <span class="text-muted">Por definir / unidad</span>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</td>

                                <td>
                                    <?php if($service->duration_minutes): ?>
                                        <?php echo e($service->duration_minutes); ?> min
                                    <?php else: ?>
                                        <span class="text-muted">Variable</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($service->is_active): ?>
                                        <span class="status-active">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Activo
                                        </span>
                                    <?php else: ?>
                                        <span class="status-inactive">
                                            <i class="bi bi-pause-circle-fill me-1"></i>
                                            Inactivo
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="<?php echo e(route('services.edit', $service)); ?>"
                                           class="action-button"
                                           title="Editar servicio">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="<?php echo e(route('services.destroy', $service)); ?>"
                                              method="POST"
                                              onsubmit="return confirm('¿Deseas eliminar o desactivar este servicio?')">

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit"
                                                    class="action-button delete-button"
                                                    title="Eliminar o desactivar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-scissors fs-1 d-block mb-3"
                                       style="color: var(--meraki-champagne);"></i>

                                    <h6 class="fw-semibold" style="color: var(--meraki-text);">
                                        Aún no hay servicios registrados
                                    </h6>

                                    <p class="small text-muted mb-3">
                                        Comienza agregando los servicios que ofrece el estudio.
                                    </p>

                                    <a href="<?php echo e(route('services.create')); ?>"
                                       class="btn btn-sm text-white rounded-3"
                                       style="background: var(--meraki-primary);">
                                        Registrar primer servicio
                                    </a>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

            
            <?php if($services->hasPages()): ?>
                <div class="p-3 border-top">
                    <?php echo e($services->links()); ?>

                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<style>
    .service-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--meraki-rose);
        color: var(--meraki-primary-dark);
        font-size: 20px;
        flex-shrink: 0;
    }

    .category-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        background: var(--meraki-ivory);
        color: var(--meraki-text);
        font-size: 11px;
    }

    .status-active,
    .status-inactive {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        white-space: nowrap;
    }

    .status-active {
        background: #edf6ef;
        color: #54815e;
    }

    .status-inactive {
        background: #f2eeee;
        color: #918487;
    }

    .action-button {
        width: 32px;
        height: 32px;
        border: 1px solid var(--meraki-border);
        background: white;
        border-radius: 8px;
        color: var(--meraki-primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .2s;
    }

    .action-button:hover {
        background: var(--meraki-rose);
        border-color: var(--meraki-primary);
    }

    .delete-button {
        color: #ad7474;
    }

    .delete-button:hover {
        background: #fbefef;
        border-color: #d9aaaa;
    }

    .table th {
        font-size: 11px;
        font-weight: 600;
        color: var(--meraki-muted);
        padding: 14px 10px;
        white-space: nowrap;
    }

    .table td {
        font-size: 12px;
        padding: 15px 10px;
        border-color: var(--meraki-border);
    }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\meraki-signature\resources\views/services/index.blade.php ENDPATH**/ ?>