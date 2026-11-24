
@php
    $currentUser = auth()->user();
@endphp

<header class="topbar">

    {{-- Información de la página --}}
    <div class="topbar-heading">
        <span class="topbar-eyebrow">MERAKI ESTUDIO DE BELLEZA</span>
        <h5>@yield('page-title', 'Panel principal')</h5>
        <p>Bienvenida a tu espacio de gestión.</p>
    </div>

    <div class="topbar-right">

        {{-- Fecha actual --}}
        <div class="today-date">
            <div class="date-icon">
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="date-info">
                <span>HOY</span>
                <strong>
                    {{ now()->locale('es')->translatedFormat('l, d \d\e F \d\e Y') }}
                </strong>
            </div>
        </div>

        {{-- Perfil de usuario --}}
        <a href="{{ route('profile.edit') }}" class="profile-link">

            <div class="profile-avatar">
                @if($currentUser?->profile_photo_path)
                    <img
                        src="{{ asset('storage/' . $currentUser->profile_photo_path) }}"
                        alt="Fotografía de {{ $currentUser->name }}"
                    >
                @else
                    <i class="bi bi-person"></i>
                @endif
            </div>

            <div class="profile-info">
                <strong>{{ $currentUser?->name ?? 'Administradora' }}</strong>
                <small>{{ $currentUser?->email ?? 'Meraki Signature' }}</small>
            </div>

            <i class="bi bi-chevron-down profile-chevron"></i>

        </a>

    </div>

</header>

<style>
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        margin-bottom: 30px;
        padding: 5px 0 22px;
        border-bottom: 1px solid var(--meraki-border, #EFE6E5);
    }

    .topbar-heading {
        min-width: 0;
    }

    .topbar-eyebrow {
        display: block;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--meraki-champagne, #D5B69C);
        margin-bottom: 7px;
    }

    .topbar h5 {
        font-family: 'Playfair Display', serif;
        font-size: 23px;
        color: var(--meraki-text, #55464A);
        font-weight: 600;
        margin: 0 0 5px;
    }

    .topbar p {
        color: var(--meraki-muted, #9C8D91);
        font-size: 12px;
        margin: 0;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    /* Fecha */

    .today-date {
        display: flex;
        align-items: center;
        gap: 11px;
        padding-right: 24px;
        border-right: 1px solid var(--meraki-border, #EFE6E5);
    }

    .date-icon {
        width: 39px;
        height: 39px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--meraki-rose, #F7E9E8);
        color: var(--meraki-primary-dark, #A96F68);
        font-size: 16px;
    }

    .date-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .date-info span {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1.3px;
        color: var(--meraki-muted, #9C8D91);
    }

    .date-info strong {
        font-size: 11px;
        font-weight: 500;
        color: var(--meraki-text, #55464A);
        text-transform: capitalize;
        white-space: nowrap;
    }

    /* Perfil */

    .profile-link {
        display: flex;
        align-items: center;
        gap: 11px;
        text-decoration: none;
        padding: 6px 10px 6px 6px;
        border-radius: 40px;
        transition: background .2s ease;
    }

    .profile-link:hover {
        background: var(--meraki-ivory, #FBF9F7);
    }

    .profile-avatar {
        width: 43px;
        height: 43px;
        min-width: 43px;
        border-radius: 50%;
        overflow: hidden;
        background: var(--meraki-rose, #F7E9E8);
        color: var(--meraki-primary-dark, #A96F68);
        border: 2px solid var(--meraki-white, #fff);
        box-shadow: 0 0 0 1px var(--meraki-border, #EFE6E5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .profile-info strong {
        font-size: 12px;
        font-weight: 600;
        color: var(--meraki-text, #55464A);
    }

    .profile-info small {
        font-size: 10px;
        color: var(--meraki-muted, #9C8D91);
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .profile-chevron {
        font-size: 11px;
        color: var(--meraki-muted, #9C8D91);
        margin-left: 3px;
    }

    @media (max-width: 768px) {
        .topbar {
            align-items: center;
            margin-bottom: 22px;
            padding-bottom: 17px;
        }

        .topbar h5 {
            font-size: 20px;
        }

        .topbar p {
            font-size: 11px;
        }

        .topbar-eyebrow {
            font-size: 8px;
        }

        .topbar-right {
            gap: 8px;
        }

        .today-date,
        .profile-info,
        .profile-chevron {
            display: none;
        }

        .profile-link {
            padding: 0;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
        }
    }
</style>
