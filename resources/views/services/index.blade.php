
@extends('layouts.app')

@section('title', 'Servicios')
@section('page-title', 'Catálogo de servicios')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado del módulo --}}
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

        <a href="{{ route('services.create') }}"
           class="btn text-white rounded-3 px-4 py-2"
           style="background: var(--meraki-primary);">
            <i class="bi bi-plus-lg me-2"></i>
            Nuevo servicio
        </a>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Indicadores --}}
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
                            {{ $services->total() }}
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
                            {{ $categories->count() }}
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
                            {{ \App\Models\Service::where('is_active', true)->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Buscador y filtros --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">

            <form action="{{ route('services.index') }}" method="GET">
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
                                   value="{{ $search }}">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label small fw-semibold">
                            Categoría
                        </label>

                        <select name="category" class="form-select">
                            <option value="">Todas las categorías</option>

                            @foreach($categories as $item)
                                <option value="{{ $item }}"
                                    {{ $category == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">
                        <button type="submit"
                                class="btn text-white rounded-3 flex-grow-1"
                                style="background: var(--meraki-primary);">
                            Filtrar
                        </button>

                        <a href="{{ route('services.index') }}"
                           class="btn btn-light rounded-3"
                           title="Limpiar filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- Tabla de servicios --}}
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

                        @forelse($services as $service)

                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold"
                                         style="color: var(--meraki-text);">
                                        {{ $service->name }}
                                    </div>

                                    @if($service->description)
                                        <small class="text-muted">
                                            {{ Str::limit($service->description, 65) }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    <span class="category-badge">
                                        {{ $service->category ?: 'Sin categoría' }}
                                    </span>
                                </td>

                               
<td>
    <div class="fw-semibold" style="color: var(--meraki-primary-dark);">

        @php
            $priceType = $service->price_type ?? 'fixed';
        @endphp

        @if($priceType === 'fixed')

            @if($service->price !== null)
                Q{{ number_format((float) $service->price, 2) }}
            @else
                <span class="text-muted">Sin precio</span>
            @endif

        @elseif($priceType === 'from')

            @if($service->price !== null)
                Desde Q{{ number_format((float) $service->price, 2) }}
            @else
                <span class="text-muted">Por definir</span>
            @endif

        @elseif($priceType === 'variable')

            <span>Precio variable</span>

        @elseif($priceType === 'per_unit')

            @if($service->price !== null)
                Q{{ number_format((float) $service->price, 2) }}
                <small class="text-muted fw-normal">
                    / {{ $service->price_unit ?: 'unidad' }}
                </small>
            @else
                <span class="text-muted">Por definir / unidad</span>
            @endif

        @endif

    </div>
</td>

                                <td>
                                    @if($service->duration_minutes)
                                        {{ $service->duration_minutes }} min
                                    @else
                                        <span class="text-muted">Variable</span>
                                    @endif
                                </td>

                                <td>
                                    @if($service->is_active)
                                        <span class="status-active">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="status-inactive">
                                            <i class="bi bi-pause-circle-fill me-1"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('services.edit', $service) }}"
                                           class="action-button"
                                           title="Editar servicio">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('services.destroy', $service) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Deseas eliminar o desactivar este servicio?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="action-button delete-button"
                                                    title="Eliminar o desactivar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty

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

                                    <a href="{{ route('services.create') }}"
                                       class="btn btn-sm text-white rounded-3"
                                       style="background: var(--meraki-primary);">
                                        Registrar primer servicio
                                    </a>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- Paginación --}}
            @if($services->hasPages())
                <div class="p-3 border-top">
                    {{ $services->links() }}
                </div>
            @endif

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

@endsection
