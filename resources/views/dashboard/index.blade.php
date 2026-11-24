@extends('layouts.app')

@section('title', 'Inicio')
@section('page-title', 'Panel principal')

@section('content')

<div class="container-fluid px-0">

    {{-- IDENTIDAD DEL ESTUDIO · MINIMALISMO PREMIUM --}}
    <section class="meraki-masthead mb-4">
        <div class="masthead-brand">
            <div class="masthead-logo-wrap">
                @if($businessSettings?->logo_path)
                    <img
                        src="{{ asset('storage/' . $businessSettings->logo_path) }}"
                        alt="Logotipo de {{ $businessSettings->business_name ?? 'Meraki Estudio de Belleza' }}"
                        class="masthead-logo"
                    >
                @else
                    <div class="masthead-logo-fallback">
                        <i class="bi bi-stars"></i>
                    </div>
                @endif
            </div>

            <div class="masthead-copy">
                <span class="masthead-overline">EL ARTE DE CUIDAR CADA DETALLE</span>
                <h1>{{ $businessSettings?->business_name ?? 'Meraki Estudio de Belleza' }}</h1>
                <p>{{ $businessSettings?->tagline ?: 'Un espacio para realzar tu belleza.' }}</p>
            </div>
        </div>

        <div class="masthead-welcome">
            <span class="masthead-greeting">{{ $greeting }}, {{ auth()->user()->name }}</span>
            <span class="masthead-date">
                <i class="bi bi-calendar3"></i>
                {{ now()->locale('es')->translatedFormat('l, d \\d\\e F \\d\\e Y') }}
            </span>
            <div class="masthead-time">
                <span>HORA LOCAL · GUATEMALA</span>
                <strong id="meraki-clock">--:--:--</strong>
            </div>
        </div>
    </section>

    {{-- ENCABEZADO DEL RESUMEN --}}
    <div class="dashboard-heading mb-3">
        <div>
            <span class="section-eyebrow">VISTA GENERAL</span>
            <h2>Resumen de tu negocio</h2>
            <p>Todo lo importante de Meraki, en un solo lugar.</p>
        </div>

        <a href="{{ route('appointments.create') }}"
           class="btn btn-meraki">
            <i class="bi bi-plus-lg me-2"></i>
            Nueva cita
        </a>
    </div>

   
{{-- INDICADORES PRINCIPALES --}}
<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon pink">
                <i class="bi bi-calendar-heart"></i>
            </div>
            <div>
                <span>Citas de hoy</span>
                <h3>{{ $appointmentsToday->count() }}</h3>
                <small>Atenciones programadas</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon champagne">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <span>Citas pendientes</span>
                <h3>{{ $pendingAppointments }}</h3>
                <small>Por confirmar · Próximas fechas</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon rose">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <span>Citas completadas</span>
                <h3>{{ $completedAppointmentsMonth }}</h3>
                <small>Durante este mes</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon pink">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <span>Nuevas clientas</span>
                <h3>{{ $newClientsMonth }}</h3>
                <small>Registradas este mes</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon champagne">
                <i class="bi bi-scissors"></i>
            </div>
            <div>
                <span>Servicios realizados</span>
                <h3>{{ $servicesCompletedMonth }}</h3>
                <small>Durante este mes</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon rose">
                <i class="bi bi-person-hearts"></i>
            </div>
            <div>
                <span>Total de clientas</span>
                <h3>{{ $totalClients }}</h3>
                <small>Base de Meraki</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-card">
            <div class="metric-icon champagne">
                <i class="bi bi-stars"></i>
            </div>
            <div>
                <span>Servicios disponibles</span>
                <h3>{{ $totalServices }}</h3>
                <small>Catálogo activo</small>
            </div>
        </div>
    </div>

</div>

    {{-- RESUMEN FINANCIERO --}}
    <div class="dashboard-heading mb-3 mt-4">
        <div>
            <span class="section-eyebrow">CONTROL FINANCIERO</span>
            <h2>Ingresos y saldos</h2>
            <p>Dinero recibido y pendientes de cobro.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="metric-card financial-card">
                <div class="metric-icon pink"><i class="bi bi-cash-stack"></i></div>
                <div>
                    <span>Ingresos de hoy</span>
                    <h3>Q{{ number_format((float) $incomeToday, 2) }}</h3>
                    <small>Pagos recibidos hoy</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card financial-card">
                <div class="metric-icon champagne"><i class="bi bi-calendar-week"></i></div>
                <div>
                    <span>Ingresos de la semana</span>
                    <h3>Q{{ number_format((float) $incomeWeek, 2) }}</h3>
                    <small>De lunes a domingo</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card financial-card">
                <div class="metric-icon rose"><i class="bi bi-graph-up-arrow"></i></div>
                <div>
                    <span>Ingresos del mes</span>
                    <h3>Q{{ number_format((float) $incomeMonth, 2) }}</h3>
                    <small>Pagos recibidos este mes</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card financial-card">
                <div class="metric-icon champagne"><i class="bi bi-wallet2"></i></div>
                <div>
                    <span>Saldos pendientes</span>
                    <h3>Q{{ number_format((float) $outstandingBalance, 2) }}</h3>
                    <small>En citas no canceladas</small>
                </div>
            </div>
        </div>
    </div>

    {{-- MOVIMIENTOS RECIENTES --}}
    <div class="content-card recent-payments-card mb-4">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">MOVIMIENTOS</span>
                <h2>Últimos pagos recibidos</h2>
                <p>Los cinco movimientos más recientes registrados en Meraki.</p>
            </div>
        </div>

        @forelse($recentPayments as $payment)
            <div class="payment-row-compact">
                <div class="payment-date-compact">
                    {{ $payment->payment_date?->format('d/m/Y') ?? 'Sin fecha' }}
                    <small>{{ $payment->payment_date?->format('h:i A') ?? '' }}</small>
                </div>
                <div class="payment-client-compact">
                    <strong>{{ $payment->appointment?->client?->name ?? 'Clienta no disponible' }}</strong>
                    <small>
                        {{ ucfirst($payment->payment_method) }}
                        @if($payment->reference)
                            · Ref. {{ $payment->reference }}
                        @endif
                    </small>
                </div>
                <strong class="payment-amount">+ Q{{ number_format((float) $payment->amount, 2) }}</strong>
            </div>
        @empty
            <div class="empty-state py-4">
                <div class="empty-icon"><i class="bi bi-wallet2"></i></div>
                <h3>Aún no hay movimientos</h3>
                <p>Cuando registres anticipos o pagos, aparecerán aquí.</p>
            </div>
        @endforelse
    </div>

    {{-- AGENDA --}}
    <div class="content-card agenda-card">

        <div class="section-header">
            <div>
                <span class="section-eyebrow">ORGANIZACIÓN DIARIA</span>
                <h2>Agenda de hoy</h2>
                <p>Consulta las próximas atenciones del estudio.</p>
            </div>

            <a href="{{ route('appointments.index') }}" class="text-link">
                Ver agenda <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @forelse($appointmentsToday as $appointment)

            <div class="appointment-row">

                <div class="appointment-hour">
                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                </div>

                <div class="appointment-info">
                    <strong>{{ $appointment->client->name }}</strong>

                    <div class="appointment-services">
                        @foreach($appointment->appointmentServices as $item)
                            <span>
                                {{ $item->service_name }}
                                @if($item->staff)
                                    · {{ $item->staff->name }}
                                @endif
                            </span>
                            @if(!$loop->last)
                                <span class="service-separator">/</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                @php
                    $statusLabels = [
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                        'no_show' => 'No se presentó',
                    ];

                    $statusClasses = [
                        'pending' => 'status-pending',
                        'confirmed' => 'status-confirmed',
                        'completed' => 'status-completed',
                        'cancelled' => 'status-cancelled',
                        'no_show' => 'status-cancelled',
                    ];
                @endphp

                <span class="status-badge {{ $statusClasses[$appointment->status] ?? 'status-pending' }}">
                    {{ $statusLabels[$appointment->status] ?? 'Pendiente' }}
                </span>

            </div>

        @empty

            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-calendar-heart"></i>
                </div>

                <h3>Un día para crear algo hermoso</h3>

                <p>
                    Todavía no tienes citas registradas para hoy.
                    Tu agenda está lista para recibir nuevas reservas.
                </p>

                <a href="{{ route('appointments.create') }}"
                   class="btn btn-meraki mt-3">
                    <i class="bi bi-plus-lg me-2"></i>
                    Registrar primera cita
                </a>
            </div>

        @endforelse
        {{-- PRÓXIMAS CITAS --}}
<div class="mt-5 pt-4" style="border-top: 1px solid var(--meraki-border);">

    <div class="section-header">
        <div>
            <span class="section-eyebrow">LO QUE VIENE</span>
            <h2>Próximas citas</h2>
            <p>Las siguientes atenciones programadas en Meraki.</p>
        </div>
    </div>

    @forelse($upcomingAppointments as $appointment)

        <div class="appointment-row">

            <div class="appointment-hour">
                <strong>
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m') }}
                </strong>
                <small>
                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                </small>
            </div>

            <div class="appointment-info">
                <strong>{{ $appointment->client->name }}</strong>

                <div class="appointment-services">
                    @foreach($appointment->appointmentServices as $item)
                        <span>
                            {{ $item->service_name }}
                            @if($item->staff)
                                · {{ $item->staff->name }}
                            @endif
                        </span>
                        @if(!$loop->last)
                            <span class="service-separator">/</span>
                        @endif
                    @endforeach
                </div>
            </div>

            @php
                $upcomingStatusLabels = [
                    'pending' => 'Pendiente',
                    'confirmed' => 'Confirmada',
                    'completed' => 'Completada',
                    'cancelled' => 'Cancelada',
                    'no_show' => 'No se presentó',
                ];

                $upcomingStatusClasses = [
                    'pending' => 'status-pending',
                    'confirmed' => 'status-confirmed',
                    'completed' => 'status-completed',
                    'cancelled' => 'status-cancelled',
                    'no_show' => 'status-cancelled',
                ];
            @endphp

            <span class="status-badge {{ $upcomingStatusClasses[$appointment->status] ?? 'status-pending' }}">
                {{ $upcomingStatusLabels[$appointment->status] ?? 'Pendiente' }}
            </span>

        </div>

    @empty

        <div class="empty-state py-4">
            <div class="empty-icon">
                <i class="bi bi-calendar2-check"></i>
            </div>

            <h3>Todo está por comenzar</h3>
            <p>No hay próximas citas registradas.</p>
        </div>

    @endforelse

</div>

    </div>

</div>

@endsection

@push('styles')
<style>
    /* IDENTIDAD VISUAL · MINIMALISMO PREMIUM */
    .meraki-masthead {
        min-height: 178px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 24px 28px;
        border: 1px solid #e9dfdc;
        border-radius: 17px;
        background: #fffdfb;
        box-shadow: 0 5px 18px rgba(91, 69, 66, .035);
        position: relative;
        overflow: hidden;
    }

    .meraki-masthead::after {
        content: "";
        position: absolute;
        right: -70px;
        top: -105px;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(190, 155, 137, .16);
        border-radius: 50%;
        pointer-events: none;
    }

    .masthead-brand {
        display: flex;
        align-items: center;
        gap: 25px;
        min-width: 0;
        position: relative;
        z-index: 1;
    }

    .masthead-logo-wrap {
        width: 142px;
        height: 118px;
        flex: 0 0 142px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-right: 1px solid #eee4e0;
    }

    .masthead-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .masthead-logo-fallback {
        width: 92px;
        height: 92px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f5eeeb;
        color: #a9827c;
        font-size: 34px;
    }

    .masthead-copy {
        min-width: 0;
    }

    .masthead-overline {
        display: block;
        margin-bottom: 9px;
        color: #ad8981;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2.1px;
    }

    .masthead-copy h1 {
        margin: 0 0 7px;
        color: #514348;
        font-family: 'Playfair Display', serif;
        font-size: clamp(25px, 2.5vw, 34px);
        font-weight: 500;
        letter-spacing: -.4px;
    }

    .masthead-copy p {
        margin: 0;
        color: #9a8987;
        font-size: 12px;
    }

    .masthead-welcome {
        min-width: 230px;
        padding-left: 25px;
        border-left: 1px solid #eee4e0;
        display: flex;
        flex-direction: column;
        gap: 7px;
        position: relative;
        z-index: 1;
    }

    .masthead-greeting {
        color: #66545a;
        font-family: 'Playfair Display', serif;
        font-size: 17px;
    }

    .masthead-date {
        color: #9b8989;
        font-size: 10px;
        text-transform: capitalize;
    }

    .masthead-date i {
        margin-right: 5px;
        color: #b58c83;
    }

    .masthead-time {
        display: flex;
        align-items: baseline;
        gap: 9px;
        margin-top: 3px;
    }

    .masthead-time span {
        color: #ae9189;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 1.1px;
    }

    #meraki-clock {
        color: #765c60;
        font-family: 'Playfair Display', serif;
        font-size: 17px;
        font-variant-numeric: tabular-nums;
    }

    .dashboard-heading,
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .dashboard-heading h2,
    .section-header h2 {
        font-family: 'Playfair Display', serif;
        color: #654d50;
        font-size: 21px;
        margin-bottom: 5px;
    }

    .dashboard-heading p,
    .section-header p {
        font-size: 12px;
        color: var(--meraki-muted);
        margin: 0;
    }

    .metric-card {
        height: 100%;
        min-height: 112px;
        background: #fff;
        border: 1px solid #f0e7e5;
        border-radius: 16px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 17px;
        box-shadow: var(--shadow-soft);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(90, 65, 68, .07);
    }

    .metric-icon {
        width: 49px;
        height: 49px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 21px;
    }

    .metric-icon.pink {
        background: #f8e9ed;
        color: #b77d8d;
    }

    .metric-icon.champagne {
        background: #f5eee6;
        color: #b18c69;
    }

    .metric-icon.rose {
        background: #f2e9eb;
        color: #a97882;
    }

    .metric-card span {
        color: #918287;
        font-size: 12px;
    }

    .metric-card h3 {
        font-size: 27px;
        font-weight: 600;
        margin: 3px 0;
        color: #59454d;
    }

    .metric-card small {
        color: #aaa0a3;
        font-size: 10px;
    }

    .content-card {
        background: #fff;
        border: 1px solid #f0e7e5;
        border-radius: 17px;
        padding: 25px;
        box-shadow: var(--shadow-soft);
    }

    .section-header {
        margin-bottom: 20px;
    }

    .section-header .section-eyebrow {
        margin-bottom: 8px;
    }

    .text-link {
        color: #ad7484;
        font-size: 12px;
        text-decoration: none;
        white-space: nowrap;
    }

    .appointment-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 17px 8px;
        border-top: 1px solid #f2ebea;
    }

    .appointment-hour {
        min-width: 90px;
        color: #a97882;
        font-size: 13px;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .appointment-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .appointment-info strong {
        color: #59454d;
        font-size: 13px;
    }

    .appointment-services {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        color: #a69a9e;
        font-size: 11px;
    }

    .service-separator {
        color: #d5b69c;
    }

    .status-badge {
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 10px;
        white-space: nowrap;
    }

    .status-pending {
        background: #f8f0e4;
        color: #a57e4e;
    }

    .status-confirmed {
        background: #eaf3ed;
        color: #60836b;
    }

    .status-completed {
        background: #eeeaf3;
        color: #85729b;
    }

    .status-cancelled {
        background: #f8e9e9;
        color: #ad7474;
    }

    .empty-state {
        text-align: center;
        padding: 42px 15px;
    }

    .empty-icon {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        background: #f8edf0;
        color: #bd8495;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        margin: 0 auto 16px;
    }

    .empty-state h3 {
        color: #59454d;
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        margin-bottom: 8px;
    }

    .empty-state p {
        max-width: 410px;
        margin: 0 auto;
        color: #aaa0a3;
        font-size: 12px;
        line-height: 1.7;
    }

    .financial-card h3 {
        font-size: 24px;
        white-space: nowrap;
    }

    .payment-amount {
        color: #789477;
        font-size: 14px;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }


    /* Acabado editorial cálido */
    .dashboard-heading h2,
    .section-header h2 {
        color: #5c484d;
        font-weight: 500;
    }

    .section-eyebrow {
        color: #a9857d;
        letter-spacing: 1.8px;
    }

    .dashboard-heading p,
    .section-header p {
        color: #9b8b8d;
    }

    .dashboard-heading .btn-meraki {
        border-radius: 9px;
        background: #a97d78;
        border-color: #a97d78;
        box-shadow: 0 4px 10px rgba(169, 125, 120, .12);
    }

    .dashboard-heading .btn-meraki:hover {
        background: #936b68;
        border-color: #936b68;
    }

    .metric-card {
        min-height: 108px;
        padding: 19px;
        border-color: #ebe2df;
        border-radius: 14px;
        background: #fffdfb;
        box-shadow: 0 4px 13px rgba(91, 69, 66, .035);
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 19px rgba(91, 69, 66, .065);
    }

    .metric-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 19px;
        box-shadow: none;
    }

    .metric-icon.pink {
        background: #f4e9e8;
        color: #a77b7d;
    }

    .metric-icon.champagne {
        background: #f3eee6;
        color: #a68a69;
    }

    .metric-icon.rose {
        background: #f1eaec;
        color: #95737c;
    }

    .metric-card h3 {
        color: #59464c;
        font-weight: 500;
    }

    .metric-card span {
        color: #88777c;
    }

    .metric-card small {
        color: #a39899;
    }

    .dashboard-heading.mt-4 {
        padding-top: 7px;
        border-top: 1px solid #e9dfdc;
    }

    .financial-card {
        background: #f8f3ef;
        border-color: #eee4df;
        box-shadow: none;
    }

    .financial-card:nth-child(2) {
        background: #f6f0ea;
    }

    .financial-card:nth-child(3) {
        background: #f5eef0;
    }

    .financial-card:nth-child(4) {
        background: #f4f0e9;
    }

    .financial-card h3 {
        color: #72585f;
    }

    .recent-payments-card,
    .agenda-card {
        border: 1px solid #e9dfdc;
        border-radius: 15px;
        background: #fffdfb;
        box-shadow: 0 5px 16px rgba(91, 69, 66, .035);
    }

    .recent-payments-card {
        padding: 20px 23px;
    }

    .recent-payments-card .section-header {
        margin-bottom: 10px;
    }

    .payment-row-compact {
        display: grid;
        grid-template-columns: 112px minmax(0, 1fr) auto;
        align-items: center;
        gap: 15px;
        min-height: 52px;
        padding: 8px 5px;
        border-top: 1px solid #f0e9e6;
    }

    .payment-date-compact {
        color: #a17c7c;
        font-size: 10px;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .payment-date-compact small,
    .payment-client-compact small {
        display: block;
        margin-top: 3px;
        color: #a39899;
        font-size: 9px;
        font-weight: 400;
    }

    .payment-client-compact {
        min-width: 0;
    }

    .payment-client-compact strong {
        display: block;
        color: #5b484e;
        font-size: 11px;
        font-weight: 600;
    }

    .payment-amount {
        color: #6f866f;
        background: #eef2eb;
        border-radius: 20px;
        padding: 5px 9px;
        font-size: 11px;
    }

    .agenda-card {
        padding: 23px;
    }

    .agenda-card .appointment-row {
        border-top-color: #f0e9e6;
    }

    .appointment-hour {
        color: #a17a7e;
    }

    .appointment-info strong {
        color: #5b484e;
    }

    .status-pending {
        background: #f5efe5;
        color: #9b7a50;
    }

    .status-confirmed {
        background: #edf2eb;
        color: #648066;
    }

    .status-completed {
        background: #f0edf3;
        color: #806f91;
    }

    .status-cancelled {
        background: #f6ebea;
        color: #a87575;
    }

    .empty-state {
        background: #faf6f3;
        border-radius: 12px;
    }

    @media(max-width: 768px) {
        .meraki-masthead {
            padding: 20px 17px;
            align-items: flex-start;
            flex-direction: column;
            gap: 17px;
        }

        .masthead-brand {
            gap: 14px;
        }

        .masthead-logo-wrap {
            width: 88px;
            height: 82px;
            flex-basis: 88px;
            padding: 5px;
        }

        .masthead-welcome {
            width: 100%;
            min-width: 0;
            padding: 13px 0 0;
            border-left: 0;
            border-top: 1px solid #eee4e0;
        }

        .payment-row-compact {
            grid-template-columns: 86px minmax(0, 1fr);
            gap: 8px;
        }

        .payment-row-compact .payment-amount {
            grid-column: 2;
            justify-self: start;
        }

        .dashboard-heading,
        .section-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .appointment-row {
            gap: 10px;
            flex-wrap: wrap;
        }

        .appointment-status {
            margin-left: 100px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const clock = document.getElementById('meraki-clock');

    if (!clock) return;

    function updateMerakiClock() {
        const now = new Date();

        clock.textContent = new Intl.DateTimeFormat('es-GT', {
            timeZone: 'America/Guatemala',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        }).format(now).toUpperCase();
    }

    updateMerakiClock();
    setInterval(updateMerakiClock, 1000);
})();
</script>
@endpush
