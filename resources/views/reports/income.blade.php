
@extends('layouts.app')

@section('title', 'Reporte de ingresos')
@section('page-title', 'Reporte de ingresos')

@section('content')
<div class="container-fluid px-0">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print">
        <div>
            <span class="report-eyebrow">CONTROL FINANCIERO</span>
            <h2 class="report-title">Ingresos del estudio</h2>
            <p class="text-muted mb-0">Pagos efectivamente recibidos por Meraki.</p>
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

    {{-- ENCABEZADO EXCLUSIVO DEL PDF --}}
    <div class="print-header">
        <div class="print-brand">MERAKI</div>
        <div class="print-subtitle">ESTUDIO DE BELLEZA</div>
        <h1>Reporte de ingresos</h1>
        <p>Control financiero del estudio</p>

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
        <form method="GET" action="{{ route('reports.income') }}"
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
                <button class="btn btn-meraki" type="submit">
                    <i class="bi bi-funnel me-2"></i>Filtrar
                </button>

                <a href="{{ route('reports.income') }}"
                   class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    {{-- INDICADORES --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Ingresos recibidos</span>
                <h3>Q{{ number_format($totalIncome, 2) }}</h3>
                <small>Durante el período seleccionado</small>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Movimientos registrados</span>
                <h3>{{ $totalPayments }}</h3>
                <small>Pagos y abonos registrados</small>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Saldos pendientes</span>
                <h3>Q{{ number_format($pendingBalance, 2) }}</h3>
                <small>De citas no canceladas del período</small>
            </div>
        </div>

    </div>

    {{-- MÉTODOS DE PAGO --}}
    <div class="report-panel mb-4">
        <h5 class="report-section-title">Ingresos por método de pago</h5>

        <div class="row g-3">
            @forelse($paymentsByMethod as $method)
                <div class="col-md-4">
                    <div class="method-card">
                        <span>{{ ucfirst($method->payment_method) }}</span>
                        <strong>Q{{ number_format($method->total, 2) }}</strong>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">
                    No hay pagos registrados en este período.
                </div>
            @endforelse
        </div>
    </div>

    {{-- DETALLE DE MOVIMIENTOS --}}
    <div class="report-panel">
        <h5 class="report-section-title">Detalle de movimientos</h5>

        <div class="table-responsive">
            <table class="table align-middle report-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Clienta</th>
                        <th>Método</th>
                        <th>Referencia</th>
                        <th class="text-end">Importe</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date?->format('d/m/Y h:i A') }}</td>
                            <td>{{ $payment->appointment?->client?->name ?? 'Sin clienta' }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td>{{ $payment->reference ?: '—' }}</td>
                            <td class="text-end fw-semibold">
                                Q{{ number_format($payment->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No se encontraron movimientos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="no-print">
            {{ $payments->links() }}
        </div>
    </div>

    {{-- PIE DEL PDF --}}
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

.report-metric span,
.report-metric small {
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

/* ENCABEZADO Y PIE PARA PDF */
.print-header,
.print-footer {
    display:none;
}

/* CONFIGURACIÓN DE IMPRESIÓN */
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

    /* Ocultar elementos de navegación */
    .sidebar,
    .topbar,
    .navbar,
    .app-header,
    .no-print,
    header,
    nav {
        display:none !important;
    }

    /* Recuperar el ancho del contenido */
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
