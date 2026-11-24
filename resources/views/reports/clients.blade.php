
@extends('layouts.app')

@section('title', 'Reporte de clientas')
@section('page-title', 'Reporte de clientas')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print">
        <div>
            <span class="report-eyebrow">RELACIÓN CON CLIENTAS</span>
            <h2 class="report-title">Reporte de clientas</h2>
            <p class="text-muted mb-0">Actividad y crecimiento de la cartera de Meraki.</p>
        </div>

        <div class="d-flex gap-2">
            <button type="button" onclick="window.print()" class="btn btn-meraki">
                <i class="bi bi-file-earmark-pdf me-2"></i>Exportar PDF
            </button>

            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    <div class="print-header">
        <div class="print-brand">MERAKI</div>
        <div class="print-subtitle">ESTUDIO DE BELLEZA</div>
        <h2>Reporte de clientas</h2>
        <p>Actividad y crecimiento de la cartera de clientas</p>
        <div class="print-period">
            Período:
            {{ $startDate->format('d/m/Y') }}
            al
            {{ $endDate->format('d/m/Y') }}
        </div>
        <div class="print-generated">
            Generado el {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="report-panel mb-4 no-print">
        <form method="GET" action="{{ route('reports.clients') }}"
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

                <a href="{{ route('reports.clients') }}"
                   class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Total de clientas registradas</span>
                <h3>{{ $totalClients }}</h3>
                <small>Base completa de Meraki</small>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Nuevas clientas</span>
                <h3>{{ $newClients }}</h3>
                <small>Registradas en el período</small>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="report-metric">
                <span>Clientas con citas</span>
                <h3>{{ $activeClients }}</h3>
                <small>Con reservas en el período</small>
            </div>
        </div>
    </div>

    <div class="report-panel">
        <h5 class="report-section-title">Actividad por clienta</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Clienta</th>
                        <th>Teléfono</th>
                        <th>Correo electrónico</th>
                        <th class="text-center">Citas del período</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td class="fw-semibold">{{ $client->name }}</td>
                            <td>{{ $client->phone ?: '—' }}</td>
                            <td>{{ $client->email ?: '—' }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill client-count">
                                    {{ $client->appointments_count }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No hay clientas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="no-print">
            {{ $clients->links() }}
        </div>
    </div>

    <div class="print-footer">
        <strong>MERAKI ESTUDIO DE BELLEZA</strong>
        <span>Gestión y organización de tu negocio</span>
    </div>

</div>
@endsection

@push('styles')
<style>
.report-eyebrow {
    color: #b77d82;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
}

.report-title {
    font-family: 'Playfair Display', serif;
    color: #654d50;
    margin: 7px 0;
}

.report-panel {
    background: #fff;
    padding: 24px;
    border: 1px solid #f0e5e3;
    border-radius: 17px;
    box-shadow: 0 5px 20px rgba(90,65,68,.04);
}

.report-metric {
    height: 100%;
    padding: 23px;
    background: #fff;
    border: 1px solid #f0e5e3;
    border-radius: 15px;
}

.report-metric span {
    display: block;
    color: #998b90;
    font-size: 12px;
}

.report-metric h3 {
    color: #654d50;
    font-size: 27px;
    margin: 9px 0;
}

.report-metric small {
    color: #998b90;
    font-size: 11px;
}

.report-section-title {
    color: #654d50;
    font-weight: 600;
    margin-bottom: 20px;
}

.table thead th {
    color: #a17e80;
    font-size: 11px;
    text-transform: uppercase;
    border-bottom-color: #eee4e2;
}

.table tbody td {
    color: #71636a;
    font-size: 13px;
}

.client-count {
    background: #f8e9ed;
    color: #a96f78;
}

.btn-meraki {
    background: #bd8980;
    color: white;
    border: 0;
}

.btn-meraki:hover {
    background: #a9716b;
    color: white;
}

.print-header,
.print-footer {
    display: none;
}

@media print {
    @page {
        size: A4 portrait;
        margin: 15mm 13mm 18mm;
    }

    body {
        background: #fff !important;
        color: #333 !important;
        font-family: Arial, sans-serif !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .sidebar,
    .topbar,
    .navbar,
    .app-header,
    header,
    nav,
    .no-print,
    .btn,
    .pagination {
        display: none !important;
    }

    .container-fluid,
    .content,
    .main-content,
    main {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .print-header {
        display: block !important;
        text-align: center;
        padding-bottom: 18px;
        margin-bottom: 22px;
        border-bottom: 2px solid #bd8980;
    }

    .print-brand {
        color: #9f6e70;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 30px;
        font-weight: bold;
        letter-spacing: 6px;
    }

    .print-subtitle {
        color: #a98b87;
        font-size: 9px;
        letter-spacing: 4px;
        margin-top: -3px;
    }

    .print-header h2 {
        color: #654d50;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 21px;
        margin: 18px 0 5px;
    }

    .print-header p {
        color: #88777a;
        font-size: 11px;
        margin-bottom: 10px;
    }

    .print-period {
        color: #654d50;
        font-size: 11px;
        font-weight: bold;
    }

    .print-generated {
        color: #998b90;
        font-size: 9px;
        margin-top: 5px;
    }

    .report-panel,
    .report-metric {
        box-shadow: none !important;
        border: 1px solid #eadbd8 !important;
        border-radius: 8px !important;
        background: #fff !important;
    }

    .report-panel {
        padding: 16px !important;
    }

    .report-metric {
        padding: 15px !important;
        min-height: 95px;
    }

    .report-metric span,
    .report-metric small {
        color: #88777a !important;
    }

    .report-metric h3 {
        color: #654d50 !important;
        font-size: 22px !important;
    }

    .report-section-title {
        color: #654d50 !important;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .table-responsive {
        overflow: visible !important;
    }

    .table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 10px !important;
    }

    .table thead {
        display: table-header-group;
    }

    .table thead th {
        background: #f8e9ed !important;
        color: #805d62 !important;
        font-size: 9px !important;
        padding: 9px 7px !important;
        border: 1px solid #eadbd8 !important;
    }

    .table tbody td {
        color: #5f5559 !important;
        font-size: 10px !important;
        padding: 8px 7px !important;
        border: 1px solid #eee4e2 !important;
    }

    .table tbody tr {
        page-break-inside: avoid;
    }

    .client-count {
        background: #f8e9ed !important;
        color: #a96f78 !important;
    }

    .print-footer {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        padding-top: 10px;
        border-top: 1px solid #eadbd8;
        color: #998b90;
        font-size: 8px;
    }

    .print-footer strong {
        color: #805d62;
        letter-spacing: 1px;
    }
}
</style>
@endpush
