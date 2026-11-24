
@extends('layouts.app')

@section('title', 'Reportes')
@section('page-title', 'Reportes')

@section('content')
<div class="container-fluid px-0">

    <div class="mb-4">
        <span class="text-uppercase small fw-bold" style="letter-spacing:2px;color:#b77d82">
            MERAKI · ANÁLISIS DEL NEGOCIO
        </span>
        <h2 style="font-family:'Playfair Display',serif;color:#654d50">
            Centro de reportes
        </h2>
        <p class="text-muted">Consulta y analiza la actividad de tu estudio.</p>
    </div>

    <div class="row g-4">

        @php
            $modules = [
                [
                    'title' => 'Ingresos',
                    'description' => 'Consulta pagos recibidos, anticipos, abonos y saldos pendientes.',
                    'icon' => 'bi-cash-stack',
                    'route' => 'reports.income',
                ],
                [
                    'title' => 'Citas',
                    'description' => 'Analiza las reservas según su estado y fecha.',
                    'icon' => 'bi-calendar-heart',
                    'route' => 'reports.appointments',
                ],
                [
                    'title' => 'Servicios',
                    'description' => 'Identifica los servicios más solicitados y realizados.',
                    'icon' => 'bi-scissors',
                    'route' => 'reports.services',
                ],
                [
                    'title' => 'Clientas',
                    'description' => 'Consulta nuevas clientas y su actividad en el estudio.',
                    'icon' => 'bi-people',
                    'route' => 'reports.clients',
                ],
            ];
        @endphp

        @foreach($modules as $module)
            <div class="col-xl-3 col-md-6">
                <a href="{{ route($module['route']) }}"
                   class="report-card text-decoration-none">

                    <div class="report-icon">
                        <i class="bi {{ $module['icon'] }}"></i>
                    </div>

                    <h5>{{ $module['title'] }}</h5>
                    <p>{{ $module['description'] }}</p>

                    <span class="report-link">
                        Consultar reporte
                        <i class="bi bi-arrow-right"></i>
                    </span>
                </a>
            </div>
        @endforeach

    </div>
</div>
@endsection

@push('styles')
<style>
.report-card {
    display:block;
    height:100%;
    padding:27px;
    background:#fff;
    border:1px solid #f0e5e3;
    border-radius:17px;
    box-shadow:0 5px 20px rgba(90,65,68,.04);
    transition:.2s ease;
}
.report-card:hover {
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(90,65,68,.09);
}
.report-icon {
    width:52px;
    height:52px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:15px;
    background:#f8e9ed;
    color:#b77d8d;
    font-size:23px;
    margin-bottom:20px;
}
.report-card h5 {
    color:#654d50;
    font-weight:600;
}
.report-card p {
    color:#998b90;
    font-size:13px;
    line-height:1.7;
    min-height:65px;
}
.report-link {
    color:#ad7484;
    font-size:12px;
    font-weight:600;
}
</style>
@endpush
