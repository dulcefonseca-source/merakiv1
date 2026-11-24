
@extends('layouts.app')

@section('title', 'Ficha de clienta')
@section('page-title', 'Ficha de clienta')

@section('content')

<div class="client-profile-heading">
    <div>
        <span class="heading-label">DIRECTORIO MERAKI</span>
        <h2>Ficha de clienta</h2>
        <p>Información personal e historial de visitas.</p>
    </div>

    <div class="heading-actions">
        <a href="{{ route('clients.index') }}" class="btn btn-meraki-outline">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>

        <a href="{{ route('clients.edit', $client) }}" class="btn btn-meraki">
            <i class="bi bi-pencil me-2"></i>
            Editar información
        </a>
    </div>
</div>

{{-- PERFIL DE CLIENTA --}}
<div class="content-card profile-card">

    <div class="profile-main">
        <div class="profile-avatar">
            {{ strtoupper(substr($client->name, 0, 1)) }}
        </div>

        <div class="profile-identity">
            <span class="profile-label">CLIENTA MERAKI</span>
            <h3>{{ $client->name }}</h3>
            <p>
                <i class="bi bi-calendar3 me-1"></i>
                Registrada el {{ $client->created_at->format('d/m/Y') }}
            </p>
        </div>
    </div>

    <div class="profile-contact">
        <div class="contact-item">
            <span>Teléfono</span>
            <strong>
                <i class="bi bi-telephone me-2"></i>
                {{ $client->phone ?: 'No registrado' }}
            </strong>
        </div>

        <div class="contact-item">
            <span>Correo electrónico</span>
            <strong>
                <i class="bi bi-envelope me-2"></i>
                {{ $client->email ?: 'No registrado' }}
            </strong>
        </div>

        <div class="contact-item">
            <span>Cumpleaños</span>
            <strong>
                <i class="bi bi-gift me-2"></i>
                {{ $client->birth_date ? $client->birth_date->format('d/m/Y') : 'No registrado' }}
            </strong>
        </div>

        <div class="contact-item">
            <span>Dirección</span>
            <strong>
                <i class="bi bi-geo-alt me-2"></i>
                {{ $client->address ?: 'No registrada' }}
            </strong>
        </div>
    </div>

</div>

{{-- RESUMEN --}}
<div class="profile-stats">

    <div class="stat-card">
        <div class="stat-icon stat-rose">
            <i class="bi bi-calendar2-heart"></i>
        </div>
        <div>
            <span>Total de citas</span>
            <h3>{{ $totalAppointments }}</h3>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-green">
            <i class="bi bi-check-circle"></i>
        </div>
        <div>
            <span>Completadas</span>
            <h3>{{ $completedAppointments }}</h3>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-gold">
            <i class="bi bi-clock-history"></i>
        </div>
        <div>
            <span>Pendientes / confirmadas</span>
            <h3>{{ $pendingAppointments }}</h3>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon stat-red">
            <i class="bi bi-calendar-x"></i>
        </div>
        <div>
            <span>Canceladas</span>
            <h3>{{ $cancelledAppointments }}</h3>
        </div>
    </div>

</div>

{{-- HISTORIAL --}}
<div class="content-card history-card">

    <div class="section-heading">
        <div>
            <span class="heading-label">ACTIVIDAD</span>
            <h4>Historial de citas</h4>
            <p>Consulta los servicios que ha solicitado esta clienta.</p>
        </div>

        <a href="{{ route('appointments.create') }}" class="btn btn-meraki-outline">
            <i class="bi bi-plus-lg me-2"></i>
            Nueva cita
        </a>
    </div>

    @if($appointments->isNotEmpty())

        <div class="history-list">

            @foreach($appointments as $appointment)

                @php
                    $statusLabels = [
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                        'no_show' => 'No asistió',
                    ];

                    $statusClasses = [
                        'pending' => 'status-pending',
                        'confirmed' => 'status-confirmed',
                        'completed' => 'status-completed',
                        'cancelled' => 'status-cancelled',
                        'no_show' => 'status-noshow',
                    ];
                @endphp

                <div class="history-item">

                    <div class="history-date">
                        <strong>{{ $appointment->appointment_date->format('d') }}</strong>
                        <span>{{ ucfirst($appointment->appointment_date->translatedFormat('M')) }}</span>
                        <small>{{ $appointment->appointment_date->format('Y') }}</small>
                    </div>

                    <div class="history-content">

                        <div class="history-top">
                            <div>
                                <h5>
                                    Cita #{{ $appointment->id }}
                                </h5>

                                <span class="history-time">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                    @if($appointment->end_time)
                                        – {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                    @endif
                                </span>
                            </div>

                            <span class="status-badge {{ $statusClasses[$appointment->status] ?? '' }}">
                                {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                            </span>
                        </div>

                        <div class="history-services">

                            @foreach($appointment->appointmentServices as $item)

                                <div class="service-history-item">
                                    <div>
                                        <strong>{{ $item->service_name ?? 'Servicio por definir' }}</strong>

                                        <span>
                                            {{ $item->category ?? 'Sin categoría' }}
                                            @if($item->staff)
                                                · {{ $item->staff->name }}
                                            @endif
                                            @if($item->duration_minutes)
                                                · {{ $item->duration_minutes }} min
                                            @endif
                                        </span>
                                    </div>

                                    <strong class="service-price">
                                        {{ $item->price !== null ? 'Q'.number_format((float) $item->price, 2) : 'Por definir' }}
                                    </strong>
                                </div>

                            @endforeach

                        </div>

                        @if($appointment->location || $appointment->notes)
                            <div class="history-extra">

                                @if($appointment->location)
                                    <span>
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $appointment->location }}
                                    </span>
                                @endif

                                @if($appointment->notes)
                                    <p>{{ $appointment->notes }}</p>
                                @endif

                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-history">
            <i class="bi bi-calendar-heart"></i>
            <h5>Aún no hay citas registradas</h5>
            <p>Cuando esta clienta reserve un servicio, aparecerá aquí su historial.</p>

            <a href="{{ route('appointments.create') }}" class="btn btn-meraki mt-2">
                <i class="bi bi-plus-lg me-2"></i>
                Registrar primera cita
            </a>
        </div>

    @endif

</div>

{{-- OBSERVACIONES --}}
@if($client->notes)
    <div class="content-card observations-card">
        <div class="observations-icon">
            <i class="bi bi-journal-text"></i>
        </div>

        <div>
            <h5>Observaciones de la clienta</h5>
            <p>{{ $client->notes }}</p>
        </div>
    </div>
@endif

@endsection

@push('styles')
<style>
    .client-profile-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .heading-label {
        color: var(--meraki-primary);
        font-size: 10px;
        letter-spacing: 1.7px;
        font-weight: 700;
    }

    .client-profile-heading h2 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        margin: 7px 0;
    }

    .client-profile-heading p {
        color: var(--meraki-muted);
        font-size: 13px;
        margin: 0;
    }

    .heading-actions {
        display: flex;
        gap: 9px;
    }

    .profile-card {
        padding: 28px;
        margin-bottom: 20px;
    }

    .profile-main {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 25px;
        border-bottom: 1px solid var(--meraki-border);
    }

    .profile-avatar {
        width: 76px;
        height: 76px;
        border-radius: 22px;
        background: var(--meraki-rose);
        color: var(--meraki-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 35px;
    }

    .profile-label {
        color: var(--meraki-primary);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
    }

    .profile-identity h3 {
        font-family: 'Playfair Display', serif;
        font-size: 25px;
        margin: 5px 0;
    }

    .profile-identity p {
        font-size: 12px;
        color: var(--meraki-muted);
        margin: 0;
    }

    .profile-contact {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding-top: 24px;
    }

    .contact-item {
        min-width: 0;
    }

    .contact-item span {
        display: block;
        font-size: 10px;
        color: var(--meraki-muted);
        margin-bottom: 7px;
    }

    .contact-item strong {
        font-size: 12px;
        font-weight: 500;
        color: var(--meraki-text);
        overflow-wrap: anywhere;
    }

    .contact-item i {
        color: var(--meraki-primary);
    }

    .profile-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--meraki-border);
        border-radius: 13px;
        padding: 17px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .stat-rose {
        background: #F7E9E8;
        color: #BD8980;
    }

    .stat-green {
        background: #EAF2EC;
        color: #789A83;
    }

    .stat-gold {
        background: #F5EFE4;
        color: #B79A6D;
    }

    .stat-red {
        background: #F8EAEA;
        color: #BD7979;
    }

    .stat-card span {
        display: block;
        color: var(--meraki-muted);
        font-size: 10px;
    }

    .stat-card h3 {
        font-size: 23px;
        margin: 3px 0 0;
        font-weight: 600;
        color: var(--meraki-text);
    }

    .history-card {
        padding: 25px;
    }

    .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .section-heading h4 {
        font-family: 'Playfair Display', serif;
        font-size: 21px;
        margin: 6px 0;
    }

    .section-heading p {
        color: var(--meraki-muted);
        font-size: 12px;
        margin: 0;
    }

    .history-list {
        display: flex;
        flex-direction: column;
    }

    .history-item {
        display: grid;
        grid-template-columns: 60px 1fr;
        gap: 18px;
        padding: 22px 0;
        border-top: 1px solid var(--meraki-border);
    }

    .history-date {
        width: 55px;
        height: 65px;
        background: var(--meraki-ivory);
        border: 1px solid var(--meraki-border);
        border-radius: 11px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .history-date strong {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        line-height: 1;
        color: var(--meraki-text);
    }

    .history-date span {
        font-size: 10px;
        color: var(--meraki-primary);
        font-weight: 600;
        text-transform: capitalize;
    }

    .history-date small {
        font-size: 9px;
        color: var(--meraki-muted);
    }

    .history-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 15px;
    }

    .history-top h5 {
        font-size: 13px;
        font-weight: 600;
        margin: 0 0 5px;
    }

    .history-time {
        color: var(--meraki-muted);
        font-size: 11px;
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-pending {
        background: #F5EFE4;
        color: #A68A5D;
    }

    .status-confirmed {
        background: #EAF2EC;
        color: #648C70;
    }

    .status-completed {
        background: #E9EEF7;
        color: #7185AD;
    }

    .status-cancelled {
        background: #F8EAEA;
        color: #B66C6C;
    }

    .status-noshow {
        background: #F0EAF3;
        color: #9679A2;
    }

    .history-services {
        background: #FCFAF9;
        border: 1px solid var(--meraki-border);
        border-radius: 10px;
        padding: 5px 14px;
    }

    .service-history-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 11px 0;
        border-bottom: 1px solid var(--meraki-border);
    }

    .service-history-item:last-child {
        border-bottom: none;
    }

    .service-history-item strong {
        display: block;
        font-size: 12px;
        color: var(--meraki-text);
    }

    .service-history-item span {
        display: block;
        font-size: 10px;
        color: var(--meraki-muted);
        margin-top: 4px;
    }

    .service-history-item .service-price {
        color: var(--meraki-primary-dark);
        white-space: nowrap;
    }

    .history-extra {
        margin-top: 12px;
        font-size: 11px;
        color: var(--meraki-muted);
    }

    .history-extra p {
        margin: 7px 0 0;
        white-space: pre-line;
    }

    .empty-history {
        text-align: center;
        padding: 45px 15px;
        border-top: 1px solid var(--meraki-border);
    }

    .empty-history > i {
        font-size: 38px;
        color: var(--meraki-primary);
    }

    .empty-history h5 {
        font-family: 'Playfair Display', serif;
        margin: 12px 0 7px;
    }

    .empty-history p {
        font-size: 12px;
        color: var(--meraki-muted);
    }

    .observations-card {
        display: flex;
        gap: 15px;
        align-items: flex-start;
        padding: 22px;
        margin-top: 20px;
    }

    .observations-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: var(--meraki-rose);
        color: var(--meraki-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .observations-card h5 {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        margin: 2px 0 7px;
    }

    .observations-card p {
        font-size: 12px;
        color: var(--meraki-muted);
        margin: 0;
        white-space: pre-line;
    }

    @media (max-width: 992px) {
        .profile-contact {
            grid-template-columns: repeat(2, 1fr);
        }

        .profile-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .client-profile-heading,
        .section-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .heading-actions {
            width: 100%;
        }

        .heading-actions .btn {
            flex: 1;
        }

        .profile-card,
        .history-card {
            padding: 18px;
        }

        .profile-main {
            align-items: flex-start;
        }

        .profile-avatar {
            width: 58px;
            height: 58px;
            font-size: 27px;
        }

        .profile-identity h3 {
            font-size: 20px;
        }

        .profile-contact {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .profile-stats {
            gap: 9px;
        }

        .stat-card {
            padding: 12px;
            gap: 9px;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            font-size: 15px;
        }

        .stat-card h3 {
            font-size: 19px;
        }

        .stat-card span {
            font-size: 9px;
        }

        .history-item {
            grid-template-columns: 45px 1fr;
            gap: 10px;
        }

        .history-date {
            width: 43px;
            height: 57px;
        }

        .history-top {
            flex-direction: column;
        }

        .service-history-item {
            align-items: flex-start;
        }
    }
</style>
@endpush
