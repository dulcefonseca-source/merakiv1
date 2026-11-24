
@extends('layouts.app')

@section('title', 'Reporte de servicios')
@section('page-title', 'Reporte de servicios')

@section('content')
<div class="container-fluid px-0">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print">
        <div>
            <span class="report-eyebrow">RENDIMIENTO DEL ESTUDIO</span>
            <h2 class="report-title">Reporte de servicios</h2>
            <p class="text-muted mb-0">Servicios realizados durante el período.</p>
        </div>

        <div class="d-flex gap-2">
            <button type="button" onclick="window.print()" class="btn btn-meraki">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                Exportar PDF
            </button>

            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    {{-- ENCABEZADO PARA PDF --}}
    <div class="print-header">
        <div class="print-brand">MERAKI</div>
        <div class="print-subtitle">ESTUDIO DE BELLEZA</div>
        <h1>Reporte de servicios</h1>
        <p>Rendimiento y servicios realizados</p>

        <div class="print-period">
            Período:
            {{ $startDate->format('d/m/Y') }}
            al
            {{ $endDate->format('d/m/Y') }}
        </div>

        <div class="print-generated">
            Generado el {{ now()->format('d/m/Y h:i A') }}
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="report-panel mb-4 no-print">
        <form method="GET" action="{{ route('reports.services') }}"
              class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">Desde</label>
                <input type="date" name="start_date" class="form-control"
                       value="{{ $startDate->format('Y-m-d') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Hasta</label>
                <input type="date" name="end_date" class="form-control"
                       value="{{ $endDate->format('Y-m-d') }}">
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-meraki">
                    <i class="bi bi-funnel me-2"></i>Filtrar
                </button>

                <a href="{{ route('reports.services') }}"
                   class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    {{-- INDICADORES --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="report-metric">
                <span>Servicios realizados</span>
                <h3>{{ $totalServicesPerformed }}</h3>
            </div>
        </div>

        <div class="col-md-6">
            <div class="report-metric">
                <span>Valor de servicios realizados</span>
                <h3>Q{{ number_format($totalServicesIncome, 2) }}</h3>
            </div>
        </div>

    </div>

    {{-- DETALLE DE SERVICIOS --}}
    <div class="report-panel">
        <h5 class="report-section-title">Servicios más solicitados</h5>

        <div class="table-responsive">
            <table class="table align-middle report-table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th class="text-center">Cantidad realizada</th>
                        <th class="text-end">Valor registrado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="fw-semibold">{{ $service->service_name }}</td>
                            <td class="text-center">{{ $service->total_sold }}</td>
                            <td class="text-end">
                                Q{{ number_format($service->total_income, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No hay servicios realizados en este período.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="no-print">
            {{ $services->links() }}
        </div>
    </div>

    {{-- PIE PARA PDF --}}
    <div class="print-footer">
        MERAKI ESTUDIO DE BELLEZA
        <span>Gestión y organización de tu negocio</span>
    </div>

</div>
@endsection

@push('styles')
<style>
.report-eyebrow {
    color:#b77d82;
    font-size:10px;
    font-weight:700;
    letter-spacing:2px;
}

.report-title {
    font-family:'Playfair Display',serif;
    color:#654d50;
    margin:7px 0;
}

.report-panel {
    background:#fff;
    padding:24px;
    border:1px solid #f0e5e3;
    border-radius:17px;
    box-shadow:0 5px 20px rgba(90,65,68,.04);
}

.report-metric {
    height:100%;
    padding:23px;
    background:#fff;
    border:1px solid #f0e5e3;
    border-radius:15px;
}

.report-metric span {
    display:block;
    color:#998b90;
    font-size:12px;
}

.report-metric h3 {
    color:#654d50;
    font-size:27px;
    margin:9px 0;
}

.report-section-title {
    color:#654d50;
    font-weight:600;
    margin-bottom:20px;
}

.table thead th {
    color:#a17e80;
    font-size:11px;
    text-transform:uppercase;
    border-bottom-color:#eee4e2;
}

.table tbody td {
    color:#71636a;
    font-size:13px;
}

.btn-meraki {
    background:#bd8980;
    color:white;
    border:0;
}

.btn-meraki:hover {
    background:#a9716b;
    color:white;
}

.print-header,
.print-footer {
    display:none;
}

/* IMPRESIÓN Y PDF */
@media print {

    @page {
        size:A4 portrait;
        margin:14mm;
    }

    body {
        background:#fff !important;
        color:#55464a !important;
        font-size:11px;
    }

    .sidebar,
    .topbar,
    .navbar,
    .app-header,
    .no-print,
    header,
    nav {
        display:none !important;
    }

    main,
    .main-content,
    .content,
    .page-content,
    .app-content {
        width:100% !important;
        max-width:100% !important;
        margin:0 !important;
        padding:0 !important;
    }

    .container-fluid {
        width:100% !important;
        max-width:100% !important;
        padding:0 !important;
        margin:0 !important;
    }

    .print-header {
        display:block !important;
        text-align:center;
        padding-bottom:18px;
        margin-bottom:22px;
        border-bottom:2px solid #bd8980;
    }

    .print-brand {
        font-family:'Playfair Display',serif;
        font-size:30px;
        color:#a9716b;
        letter-spacing:3px;
    }

    .print-subtitle {
        font-size:9px;
        letter-spacing:3px;
        color:#998b90;
        margin-top:2px;
    }

    .print-header h1 {
        font-family:'Playfair Display',serif;
        font-size:23px;
        color:#654d50;
        margin:15px 0 5px;
    }

    .print-header p {
        color:#998b90;
        margin-bottom:10px;
    }

    .print-period {
        font-size:11px;
        font-weight:600;
        color:#654d50;
    }

    .print-generated {
        margin-top:5px;
        font-size:9px;
        color:#998b90;
    }

    .report-panel,
    .report-metric {
        box-shadow:none !important;
        border:1px solid #eadbd9 !important;
        break-inside:avoid;
    }

    .report-panel {
        padding:15px !important;
        margin-bottom:15px !important;
    }

    .report-metric {
        padding:15px !important;
    }

    .report-metric h3 {
        font-size:20px !important;
    }

    .table-responsive {
        overflow:visible !important;
    }

    .report-table {
        width:100% !important;
        border-collapse:collapse !important;
    }

    .report-table thead {
        display:table-header-group;
    }

    .report-table tr {
        break-inside:avoid;
    }

    .report-table th,
    .report-table td {
        border:1px solid #eadbd9 !important;
        padding:8px !important;
        font-size:10px !important;
        color:#55464a !important;
    }

    .report-table thead th {
        background:#f8eeee !important;
        color:#8f656b !important;
    }

    .print-footer {
        display:block !important;
        text-align:center;
        border-top:1px solid #eadbd9;
        padding-top:12px;
        margin-top:25px;
        font-size:9px;
        letter-spacing:1px;
        color:#a9716b;
    }

    .print-footer span {
        display:block;
        margin-top:4px;
        font-size:8px;
        color:#998b90;
        letter-spacing:0;
    }

    * {
        -webkit-print-color-adjust:exact !important;
        print-color-adjust:exact !important;
    }
}
</style>
@endpush
