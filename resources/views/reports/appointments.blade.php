
@extends('layouts.app')

@section('title', 'Reporte de citas')
@section('page-title', 'Reporte de citas')

@section('content')
<div class="container-fluid px-0">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print">
        <div>
            <span class="report-eyebrow">ANÁLISIS DE RESERVAS</span>
            <h2 class="report-title">Reporte de citas</h2>
            <p class="text-muted mb-0">Actividad y estado de las citas de Meraki.</p>
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
        <h1>Reporte de citas</h1>
        <p>Análisis de reservas y actividad del estudio</p>

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
        <form method="GET" action="{{ route('reports.appointments') }}"
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

                <a href="{{ route('reports.appointments') }}"
                   class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    {{-- INDICADORES --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Total de citas</span>
                <h3>{{ $totalAppointments }}</h3>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Completadas</span>
                <h3>{{ $completedAppointments }}</h3>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Confirmadas</span>
                <h3>{{ $confirmedAppointments }}</h3>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Pendientes</span>
                <h3>{{ $pendingAppointments }}</h3>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Canceladas</span>
                <h3>{{ $cancelledAppointments }}</h3>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>No se presentaron</span>
                <h3>{{ $noShowAppointments }}</h3>
            </div>
        </div>

    </div>

    {{-- DISTRIBUCIÓN POR ESTADO --}}
    <div class="report-panel mb-4">
        <h5 class="report-section-title">Distribución por estado</h5>

        <div class="row g-3">
            @forelse($appointmentsByStatus as $status)
                @php
                    $labels = [
                        'pending' => 'Pendientes',
                        'confirmed' => 'Confirmadas',
                        'completed' => 'Completadas',
                        'cancelled' => 'Canceladas',
                        'no_show' => 'No se presentaron',
                    ];
                @endphp

                <div class="col-md-4">
                    <div class="method-card">
                        <span>{{ $labels[$status->status] ?? $status->status }}</span>
                        <strong>{{ $status->total }}</strong>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">
                    No hay citas en el período seleccionado.
                </div>
            @endforelse
        </div>
    </div>

    {{-- DETALLE DE CITAS --}}
    <div class="report-panel">
        <h5 class="report-section-title">Detalle de citas</h5>

        <div class="table-responsive">
            <table class="table align-middle report-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Clienta</th>
                        <th>Servicios</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($appointments as $appointment)
                        @php
                            $labels = [
                                'pending' => 'Pendiente',
                                'confirmed' => 'Confirmada',
                                'completed' => 'Completada',
                                'cancelled' => 'Cancelada',
                                'no_show' => 'No se presentó',
                            ];
                        @endphp

                        <tr>
                            <td>{{ $appointment->appointment_date?->format('d/m/Y') }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                            </td>

                            <td>{{ $appointment->client?->name ?? 'Sin clienta' }}</td>

                            <td>
                                @foreach($appointment->appointmentServices as $item)
                                    <span>{{ $item->service_name }}</span>@if(!$loop->last), @endif
                                @endforeach
                            </td>

                            <td>{{ $labels[$appointment->status] ?? $appointment->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No hay citas registradas en este período.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="no-print">
            {{ $appointments->links() }}
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

.method-card {
    padding:17px;
    border-radius:12px;
    background:#fbf5f3;
    display:flex;
    flex-direction:column;
    gap:8px;
}

.method-card span {
    color:#998b90;
    font-size:12px;
}

.method-card strong {
    color:#654d50;
    font-size:19px;
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

    .method-card {
        background:#fbf5f3 !important;
        border:1px solid #f0e5e3;
        padding:12px !important;
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
