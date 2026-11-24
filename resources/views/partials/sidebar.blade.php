@php
    $currentUser = auth()->user();
@endphp

<aside class="sidebar">
    {{-- Identidad de Meraki --}}
    <div class="brand">
        <a href="{{ route('dashboard') }}" class="brand-link" aria-label="Ir al inicio">
            @if($businessSettings?->logo_path)
                <img
                    src="{{ asset('storage/' . $businessSettings->logo_path) }}"
                    alt="{{ $businessSettings->business_name ?? 'Meraki Estudio de Belleza' }}"
                    class="brand-logo"
                >
            @else
                <img
                    src="{{ asset('images/meraki-logo.png') }}"
                    alt="{{ $businessSettings?->business_name ?? 'Meraki Estudio de Belleza' }}"
                    class="brand-logo"
                >
            @endif
        </a>
    </div>

    <div class="sidebar-divider"></div>

    {{-- Navegación principal --}}
    <div class="sidebar-content">
        <div class="sidebar-label">ESPACIO DE TRABAJO</div>

        <nav class="sidebar-menu" aria-label="Menú principal">
            <a href="{{ route('dashboard') }}"
               class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Inicio</span>
                @if(request()->routeIs('dashboard'))
                    <span class="active-indicator"></span>
                @endif
            </a>

            <a href="{{ route('appointments.index') }}"
               class="menu-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span>Agenda</span>
                @if(request()->routeIs('appointments.*'))
                    <span class="active-indicator"></span>
                @endif
            </a>

            <a href="{{ route('clients.index') }}"
               class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Clientas</span>
                @if(request()->routeIs('clients.*'))
                    <span class="active-indicator"></span>
                @endif
            </a>

            <a href="{{ route('services.index') }}"
               class="menu-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <i class="bi bi-stars"></i>
                <span>Servicios</span>
                @if(request()->routeIs('services.*'))
                    <span class="active-indicator"></span>
                @endif
            </a>

            <a href="{{ route('reports.index') }}"
               class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reportes</span>
                @if(request()->routeIs('reports.*'))
                    <span class="active-indicator"></span>
                @endif
            </a>

            <a href="{{ route('business-settings.edit') }}"
               class="menu-item {{ request()->routeIs('business-settings.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i>
                <span>Administración del estudio</span>
                @if(request()->routeIs('business-settings.*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </nav>

        <div class="sidebar-section-divider"></div>

        <div class="sidebar-label">ASISTENCIA</div>
        <nav class="sidebar-menu" aria-label="Ayuda y soporte">
            <a href="{{ route('support.index') }}"
               class="menu-item {{ request()->routeIs('support.*') ? 'active' : '' }}">
                <i class="bi bi-headset"></i>
                <span>Soporte técnico</span>
                @if(request()->routeIs('support.*'))
                    <span class="active-indicator"></span>
                @endif
            </a>
        </nav>
    </div>

    {{-- Cuenta y sesión --}}
    <div class="sidebar-bottom">
        <div class="sidebar-section-divider"></div>
        <div class="sidebar-label">MI CUENTA</div>

        <a href="{{ route('profile.edit') }}"
           class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i>
            <span>Mi perfil</span>
            @if(request()->routeIs('profile.*'))
                <span class="active-indicator"></span>
            @endif
        </a>

        <a href="{{ route('profile.edit') }}" class="sidebar-user">
            <div class="sidebar-user-avatar">
                @if($currentUser?->profile_photo_path)
                    <img
                        src="{{ asset('storage/' . $currentUser->profile_photo_path) }}"
                        alt="Fotografía de {{ $currentUser->name }}"
                    >
                @else
                    <i class="bi bi-person"></i>
                @endif
            </div>

            <div class="sidebar-user-info">
                <strong>{{ $currentUser?->name ?? 'Administradora' }}</strong>
                <small>Administradora</small>
            </div>

            <i class="bi bi-chevron-right sidebar-user-arrow"></i>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">
                <i class="bi bi-box-arrow-left"></i>
                <span>Cerrar sesión</span>
            </button>
        </form>

        <div class="sidebar-footer">
            <span class="sidebar-footer-brand">MERAKI SIGNATURE</span>
            <small>Gestión y organización</small>
            <div class="footer-decoration"></div>
        </div>
    </div>
</aside>

<style>
    .sidebar {
        --sb-ink: #514541;
        --sb-muted: #92847f;
        --sb-rose: #a97878;
        --sb-rose-soft: #f6eeeb;
        --sb-border: #eee5e0;
        width: 258px;
        height: 100vh;
        position: fixed;
        inset: 0 auto 0 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        padding: 19px 15px 15px;
        overflow-x: hidden;
        overflow-y: auto;
        background: #fffdfc;
        border-right: 1px solid var(--sb-border);
        scrollbar-width: thin;
        scrollbar-color: #eadbd6 transparent;
    }

    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb {
        background: #eadbd6;
        border-radius: 10px;
    }

    .brand {
        min-height: 142px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding: 0 3px 5px;
    }

    .brand-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .brand-logo {
        display: block;
        width: 218px;
        max-width: 100%;
        height: 137px;
        object-fit: contain;
        transition: transform .25s ease;
    }

    .brand-link:hover .brand-logo { transform: scale(1.02); }

    .sidebar-divider,
    .sidebar-section-divider {
        height: 1px;
        flex-shrink: 0;
        background: var(--sb-border);
    }

    .sidebar-divider { margin: 0 8px 16px; }
    .sidebar-section-divider { margin: 17px 8px 7px; }

    .sidebar-content { flex: 1 0 auto; }

    .sidebar-label {
        padding: 12px 11px 9px;
        color: #a0918c;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1.55px;
    }

    .sidebar-menu {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .menu-item {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 44px;
        padding: 10px 13px;
        border: 1px solid transparent;
        border-radius: 10px;
        color: #817672;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.35;
        transition: background .2s ease, color .2s ease, border-color .2s ease, transform .2s ease;
    }

    .menu-item > i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 19px;
        flex: 0 0 19px;
        color: #a78b85;
        font-size: 16px;
        transition: color .2s ease;
    }

    .menu-item:hover {
        background: #faf5f2;
        color: #986d69;
        transform: translateX(2px);
    }

    .menu-item:hover > i { color: #986d69; }

    .menu-item.active {
        border-color: #f0e3df;
        background: #f7eeeb;
        color: #946b67;
        font-weight: 650;
    }

    .menu-item.active > i { color: #a97878; }

    .active-indicator {
        position: absolute;
        right: 11px;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #b9877e;
    }

    .sidebar-bottom {
        flex-shrink: 0;
        margin-top: 15px;
    }

    .sidebar-bottom > .sidebar-label { padding-top: 10px; }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 13px;
        padding: 10px 9px;
        border: 1px solid var(--sb-border);
        border-radius: 12px;
        background: #faf7f5;
        text-decoration: none;
        transition: border-color .2s ease, background .2s ease;
    }

    .sidebar-user:hover {
        border-color: #ddc8c1;
        background: #fff;
    }

    .sidebar-user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 37px;
        height: 37px;
        min-width: 37px;
        overflow: hidden;
        border: 1px solid #fff;
        border-radius: 50%;
        background: #f1e4df;
        color: #a97878;
        font-size: 17px;
    }

    .sidebar-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-user-info {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .sidebar-user-info strong {
        overflow: hidden;
        color: var(--sb-ink);
        font-size: 11px;
        font-weight: 650;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sidebar-user-info small {
        color: #a0918c;
        font-size: 9px;
    }

    .sidebar-user-arrow {
        color: #a0918c;
        font-size: 11px;
    }

    .logout-form { margin-top: 7px; }

    .logout-button {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 13px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: #91837e;
        font-size: 11px;
        font-weight: 500;
        text-align: left;
        cursor: pointer;
        transition: background .2s ease, color .2s ease;
    }

    .logout-button i {
        display: inline-flex;
        justify-content: center;
        width: 19px;
        font-size: 15px;
    }

    .logout-button:hover {
        background: #faf1ef;
        color: #a36f6d;
    }

    .sidebar-footer {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-top: 13px;
        padding: 13px 10px 3px;
        border-top: 1px solid var(--sb-border);
    }

    .sidebar-footer-brand {
        color: #9b716d;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 1.45px;
    }

    .sidebar-footer small {
        color: #a0918c;
        font-size: 10px;
    }

    .footer-decoration {
        width: 28px;
        height: 2px;
        margin-top: 4px;
        border-radius: 5px;
        background: #d5b69c;
    }

    @media (max-width: 768px) {
        .sidebar { display: none; }
    }
</style>
