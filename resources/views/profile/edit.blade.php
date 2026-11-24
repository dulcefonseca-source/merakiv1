@extends('layouts.app')

@section('title', 'Mi perfil')
@section('page-title', 'Mi perfil')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

<style>
    .profile-page {
        --profile-ink: #514541;
        --profile-muted: #92837e;
        --profile-rose: #aa7974;
        --profile-rose-dark: #956b66;
        --profile-soft: #f7efec;
        --profile-line: #eee5e0;
        color: var(--profile-ink);
    }

    .profile-heading {
        margin-bottom: 24px;
    }

    .profile-heading h1 {
        margin: 0 0 5px;
        color: #493d3a;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(1.8rem, 3vw, 2.25rem);
        font-weight: 500;
    }

    .profile-heading p {
        margin: 0;
        color: var(--profile-muted);
        font-size: .9rem;
    }

    .profile-card {
        height: 100%;
        border: 1px solid var(--profile-line);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 4px 18px rgba(74, 55, 49, .045);
    }

    .profile-card-body { padding: 25px; }

    .profile-card-title {
        margin: 0 0 5px;
        color: #493d3a;
        font-size: 1.04rem;
        font-weight: 650;
    }

    .profile-card-description {
        margin: 0;
        color: var(--profile-muted);
        font-size: .83rem;
        line-height: 1.6;
    }

    .profile-avatar {
        display: flex;
        width: 116px;
        height: 116px;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        overflow: hidden;
        border: 4px solid #f4e8e4;
        border-radius: 50%;
        background: #f7efec;
        color: var(--profile-rose);
        font-size: 2.6rem;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        margin-bottom: 4px;
        color: #493d3a;
        font-size: 1.13rem;
        font-weight: 650;
    }

    .profile-email {
        overflow-wrap: anywhere;
        color: var(--profile-muted);
        font-size: .82rem;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 9px;
        padding: 7px 13px;
        border-radius: 30px;
        background: #f6eae6;
        color: #986f69;
        font-size: .72rem;
        font-weight: 650;
    }

    .profile-divider {
        height: 1px;
        margin: 22px 0;
        background: var(--profile-line);
    }

    .profile-form-label {
        margin-bottom: 7px;
        color: #655752;
        font-size: .82rem;
        font-weight: 600;
    }

    .profile-page .form-control {
        min-height: 45px;
        border: 1px solid #eadfda;
        border-radius: 10px;
        color: #514541;
        font-size: .88rem;
        box-shadow: none;
    }

    .profile-page .form-control:focus {
        border-color: #c69a91;
        box-shadow: 0 0 0 3px rgba(183, 137, 128, .12);
    }

    .profile-page .form-control::placeholder { color: #b5a8a2; }

    .profile-help {
        display: block;
        margin-top: 7px;
        color: #a0928d;
        font-size: .74rem;
        line-height: 1.55;
    }

    .btn-profile-primary {
        display: inline-flex;
        min-height: 43px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
        border: 1px solid var(--profile-rose);
        border-radius: 10px;
        background: var(--profile-rose);
        color: #fff;
        font-size: .83rem;
        font-weight: 600;
        transition: background .2s ease, border-color .2s ease;
    }

    .btn-profile-primary:hover {
        border-color: var(--profile-rose-dark);
        background: var(--profile-rose-dark);
        color: #fff;
    }

    .btn-profile-primary:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .btn-profile-outline {
        min-height: 39px;
        border: 1px solid #d9c9c3;
        border-radius: 9px;
        color: #8d706b;
        font-size: .79rem;
    }

    .btn-profile-outline:hover {
        border-color: #b88b82;
        background: #faf5f2;
        color: #8d625d;
    }

    .profile-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f2ece8;
        font-size: .83rem;
    }

    .profile-meta:last-child { border-bottom: 0; padding-bottom: 0; }
    .profile-meta-label { color: var(--profile-muted); }
    .profile-meta-value { color: #5c4d48; font-weight: 600; text-align: right; }

    .profile-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #62816b;
        font-size: .78rem;
        font-weight: 650;
    }

    .profile-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #7eaa86;
    }

    .password-input-wrap { position: relative; }
    .password-input-wrap .form-control { padding-right: 46px; }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        padding: 4px;
        border: 0;
        background: transparent;
        color: #a08d87;
        cursor: pointer;
    }

    .password-toggle:hover { color: #805f59; }

    .password-guidance {
        padding: 13px 15px;
        border: 1px solid #eee4df;
        border-radius: 11px;
        background: #fbf8f6;
        color: #867872;
        font-size: .78rem;
        line-height: 1.7;
    }

    .password-guidance i { color: #a97878; }

    .preference-item {
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 68px;
        padding: 13px 0;
        border-bottom: 1px solid #f2ece8;
    }

    .preference-item:last-child { border-bottom: 0; padding-bottom: 0; }

    .preference-icon {
        display: grid;
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        place-items: center;
        border-radius: 12px;
        background: #f7efec;
        color: #a97878;
        font-size: 1rem;
    }

    .preference-copy { flex: 1; min-width: 0; }
    .preference-copy strong {
        display: block;
        color: #5b4b46;
        font-size: .82rem;
        font-weight: 650;
    }
    .preference-copy small {
        display: block;
        margin-top: 3px;
        color: var(--profile-muted);
        font-size: .74rem;
    }

    .preference-value {
        color: #8b706b;
        font-size: .77rem;
        font-weight: 650;
        white-space: nowrap;
    }

    .theme-choice-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .theme-choice {
        position: relative;
        display: block;
        padding: 10px;
        border: 1px solid #eadfda;
        border-radius: 13px;
        background: #fff;
        color: #64534e;
        text-align: left;
        transition: border-color .2s ease, background .2s ease, transform .2s ease;
    }

    .theme-choice:hover {
        transform: translateY(-2px);
        border-color: #c9a39b;
    }

    .theme-choice.selected {
        border-color: #b9877e;
        background: #fcf7f5;
        box-shadow: 0 0 0 2px rgba(185, 135, 126, .12);
    }

    .theme-preview {
        display: flex;
        height: 86px;
        overflow: hidden;
        border: 1px solid rgba(90, 70, 65, .12);
        border-radius: 8px;
    }

    .theme-preview-sidebar { width: 25%; }
    .theme-preview-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 7px;
        padding: 11px;
    }
    .theme-preview-content i {
        display: block;
        height: 9px;
        border-radius: 4px;
    }
    .theme-preview-content i:first-child { width: 65%; }
    .theme-preview-content i:nth-child(2) { width: 88%; }
    .theme-preview-content i:nth-child(3) { width: 50%; }

    .theme-preview-light { background: #fbf8f6; }
    .theme-preview-light .theme-preview-sidebar { background: #f0e5e1; }
    .theme-preview-light .theme-preview-content i { background: #e7d8d2; }

    .theme-preview-dark { background: #302a30; }
    .theme-preview-dark .theme-preview-sidebar { background: #211e23; }
    .theme-preview-dark .theme-preview-content i { background: #65505a; }

    .theme-choice-label {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-top: 10px;
        font-size: .82rem;
        font-weight: 650;
    }

    .theme-choice-label i { color: #a97878; }

    .theme-current {
        position: absolute;
        top: 9px;
        right: 9px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #8e6b66;
        font-size: .65rem;
        font-weight: 700;
    }

    @media (max-width: 480px) {
        .theme-choice-grid { grid-template-columns: 1fr; }
    }

    .profile-alert {
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: .86rem;
    }

    .profile-alert-success {
        border-color: #dce9de;
        background: #f3f8f3;
        color: #54735a;
    }

    .profile-alert-danger {
        border-color: #f0d8d5;
        background: #fff7f6;
        color: #9d5f5a;
    }

    #cropImage { display: block; max-width: 100%; }

    @media (max-width: 767.98px) {
        .profile-card-body { padding: 20px; }
        .profile-meta { align-items: flex-start; }
        .profile-meta-value { max-width: 58%; }
    }
</style>

<div class="profile-page">
    <div class="profile-heading">
        <h1>Mi perfil</h1>
        <p>Administra tu información personal, seguridad y preferencias de acceso.</p>
    </div>

    @if(session('success'))
        <div class="alert profile-alert profile-alert-success mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('password_success'))
        <div class="alert profile-alert profile-alert-success mb-4">
            <i class="bi bi-shield-check me-2"></i>{{ session('password_success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert profile-alert profile-alert-danger mb-4">
            <div class="fw-semibold mb-1">
                <i class="bi bi-exclamation-circle me-2"></i>No se pudieron guardar los cambios.
            </div>
            <ul class="mb-0 ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- Columna de identidad y datos de cuenta --}}
        <div class="col-xl-4 col-lg-5">
            <section class="profile-card">
                <div class="profile-card-body text-center">
                    <div class="profile-avatar">
                        @if($user->profile_photo_path)
                            <img
                                src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                alt="Fotografía de {{ $user->name }}"
                            >
                        @else
                            <i class="bi bi-person"></i>
                        @endif
                    </div>

                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <div class="profile-email">{{ $user->email }}</div>
                    <span class="profile-role">
                        <i class="bi bi-gem"></i>
                        Administradora
                    </span>

                    <div class="profile-divider"></div>

                    <div class="text-start">
                        <h3 class="profile-card-title mb-1">Fotografía de perfil</h3>
                        <p class="profile-card-description mb-3">
                            Actualiza tu imagen para identificar tu cuenta.
                        </p>

                        <form id="photoForm"
                              action="{{ route('profile.photo.update') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <input
                                type="file"
                                id="profilePhotoInput"
                                name="profile_photo"
                                class="form-control form-control-sm mb-2"
                                accept="image/jpeg,image/png,image/webp"
                                required
                            >

                            <small class="profile-help mb-3">
                                JPG, PNG o WEBP. Tamaño máximo: 5 MB.
                            </small>

                            <button type="submit"
                                    id="uploadPhotoButton"
                                    class="btn btn-profile-primary w-100"
                                    disabled>
                                <i class="bi bi-upload"></i>
                                Subir fotografía
                            </button>
                        </form>

                        @if($user->profile_photo_path)
                            <form action="{{ route('profile.photo.destroy') }}"
                                  method="POST"
                                  class="mt-2"
                                  onsubmit="return confirm('¿Deseas eliminar tu fotografía de perfil?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-profile-outline w-100">
                                    <i class="bi bi-trash3 me-1"></i>
                                    Eliminar fotografía
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="profile-divider"></div>

                    <div class="text-start">
                        <h3 class="profile-card-title mb-2">Información de la cuenta</h3>

                        <div class="profile-meta">
                            <span class="profile-meta-label">Tipo de cuenta</span>
                            <span class="profile-meta-value">Administradora</span>
                        </div>

                        <div class="profile-meta">
                            <span class="profile-meta-label">Estado</span>
                            <span class="profile-status">
                                <span class="profile-status-dot"></span>
                                Activa
                            </span>
                        </div>

                        <div class="profile-meta">
                            <span class="profile-meta-label">Miembro desde</span>
                            <span class="profile-meta-value">
                                {{ $user->created_at?->timezone(config('app.timezone'))->format('d/m/Y') ?? 'No disponible' }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- Columna de información, seguridad y preferencias --}}
        <div class="col-xl-8 col-lg-7">
            <div class="d-flex flex-column gap-4">
                {{-- Información personal --}}
                <section class="profile-card">
                    <div class="profile-card-body">
                        <div class="mb-4">
                            <h2 class="profile-card-title">Información personal</h2>
                            <p class="profile-card-description">
                                Mantén actualizados los datos de tu cuenta administrativa.
                            </p>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label profile-form-label">Nombre completo</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $user->name) }}"
                                    maxlength="255"
                                    autocomplete="name"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label profile-form-label">Nombre de usuario</label>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="form-control"
                                    value="{{ old('username', $user->username) }}"
                                    minlength="3"
                                    maxlength="50"
                                    autocomplete="username"
                                    autocapitalize="none"
                                    spellcheck="false"
                                    pattern="[A-Za-z0-9_-]+"
                                    title="Usa letras, números, guiones o guiones bajos."
                                    required
                                >
                                <small class="profile-help">
                                    Este será tu usuario para iniciar sesión. Usa letras, números, guiones o guiones bajos.
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label profile-form-label">Correo electrónico</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email', $user->email) }}"
                                    maxlength="255"
                                    autocomplete="email"
                                    required
                                >
                                <small class="profile-help">
                                    Conservamos este correo para contacto y recuperación de contraseña.
                                </small>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-profile-primary">
                                    <i class="bi bi-check2-circle"></i>
                                    Guardar información
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                {{-- Seguridad y contraseña --}}
                <section class="profile-card">
                    <div class="profile-card-body">
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="preference-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <div>
                                <h2 class="profile-card-title">Seguridad de la cuenta</h2>
                                <p class="profile-card-description">
                                    Cambia tu contraseña para mantener protegido el acceso al sistema.
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label profile-form-label">
                                    Contraseña actual
                                </label>
                                <div class="password-input-wrap">
                                    <input
                                        type="password"
                                        id="current_password"
                                        name="current_password"
                                        class="form-control"
                                        autocomplete="current-password"
                                        required
                                    >
                                    <button type="button" class="password-toggle"
                                            data-password-toggle="current_password"
                                            aria-label="Mostrar u ocultar contraseña">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="new_password" class="form-label profile-form-label">
                                        Nueva contraseña
                                    </label>
                                    <div class="password-input-wrap">
                                        <input
                                            type="password"
                                            id="new_password"
                                            name="new_password"
                                            class="form-control"
                                            autocomplete="new-password"
                                            required
                                        >
                                        <button type="button" class="password-toggle"
                                                data-password-toggle="new_password"
                                                aria-label="Mostrar u ocultar contraseña">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="new_password_confirmation" class="form-label profile-form-label">
                                        Confirmar nueva contraseña
                                    </label>
                                    <div class="password-input-wrap">
                                        <input
                                            type="password"
                                            id="new_password_confirmation"
                                            name="new_password_confirmation"
                                            class="form-control"
                                            autocomplete="new-password"
                                            required
                                        >
                                        <button type="button" class="password-toggle"
                                                data-password-toggle="new_password_confirmation"
                                                aria-label="Mostrar u ocultar contraseña">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="password-guidance mt-3 mb-4">
                                <i class="bi bi-info-circle me-1"></i>
                                La nueva contraseña debe tener al menos 8 caracteres e incluir letras y números.
                                También debes escribir correctamente tu contraseña actual.
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-profile-primary">
                                    <i class="bi bi-lock"></i>
                                    Actualizar contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                {{-- Preferencias de uso --}}
                <section class="profile-card">
                    <div class="profile-card-body">
                        <div class="mb-3">
                            <h2 class="profile-card-title">Preferencias de uso</h2>
                            <p class="profile-card-description">
                                Personaliza la apariencia de Meraki Signature para trabajar con mayor comodidad.
                            </p>
                        </div>

                        <form action="{{ route('profile.theme.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="preference-item">
                                <div class="preference-icon"><i class="bi bi-palette2"></i></div>
                                <div class="preference-copy">
                                    <strong>Apariencia del sistema</strong>
                                    <small>Elige cómo deseas visualizar Meraki en todas las pantallas.</small>
                                </div>
                            </div>

                            <div class="theme-choice-grid mt-3">
                                <button type="submit"
                                        name="theme_preference"
                                        value="light"
                                        class="theme-choice {{ ($user->theme_preference ?? 'light') === 'light' ? 'selected' : '' }}">
                                    <span class="theme-preview theme-preview-light">
                                        <span class="theme-preview-sidebar"></span>
                                        <span class="theme-preview-content"><i></i><i></i><i></i></span>
                                    </span>
                                    <span class="theme-choice-label"><i class="bi bi-sun"></i> Claro</span>
                                    @if(($user->theme_preference ?? 'light') === 'light')
                                        <span class="theme-current"><i class="bi bi-check-circle-fill"></i> Actual</span>
                                    @endif
                                </button>

                                <button type="submit"
                                        name="theme_preference"
                                        value="dark"
                                        class="theme-choice {{ ($user->theme_preference ?? 'light') === 'dark' ? 'selected' : '' }}">
                                    <span class="theme-preview theme-preview-dark">
                                        <span class="theme-preview-sidebar"></span>
                                        <span class="theme-preview-content"><i></i><i></i><i></i></span>
                                    </span>
                                    <span class="theme-choice-label"><i class="bi bi-moon-stars"></i> Oscuro</span>
                                    @if(($user->theme_preference ?? 'light') === 'dark')
                                        <span class="theme-current"><i class="bi bi-check-circle-fill"></i> Actual</span>
                                    @endif
                                </button>
                            </div>
                        </form>

                        <div class="preference-item mt-3">
                            <div class="preference-icon"><i class="bi bi-translate"></i></div>
                            <div class="preference-copy">
                                <strong>Idioma del sistema</strong>
                                <small>Idioma utilizado en los módulos y mensajes.</small>
                            </div>
                            <span class="preference-value">Español</span>
                        </div>

                        <small class="profile-help mt-3">
                            La apariencia se aplicará a todo el sistema y se conservará en tu cuenta.
                        </small>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

{{-- Modal para recortar fotografía --}}
<div class="modal fade" id="cropPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-semibold" style="color: var(--profile-ink);">
                        Ajustar fotografía
                    </h5>
                    <p class="small mb-0" style="color: var(--profile-muted);">
                        Mueve y amplía la imagen hasta conseguir el encuadre ideal.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-0">
                <div style="max-height: 420px; overflow: hidden; background: #f8f5f4; border-radius: 12px;">
                    <img id="cropImage" src="" alt="Imagen para recortar" style="display: block; max-width: 100%;">
                </div>

                <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                    <button type="button" id="zoomOut" class="btn btn-sm btn-profile-outline">
                        <i class="bi bi-zoom-out"></i>
                    </button>
                    <button type="button" id="zoomIn" class="btn btn-sm btn-profile-outline">
                        <i class="bi bi-zoom-in"></i>
                    </button>
                    <button type="button" id="rotateLeft" class="btn btn-sm btn-profile-outline">
                        <i class="bi bi-arrow-counterclockwise"></i> Girar
                    </button>
                    <button type="button" id="rotateRight" class="btn btn-sm btn-profile-outline">
                        <i class="bi bi-arrow-clockwise"></i> Girar
                    </button>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="cropConfirm" class="btn btn-profile-primary">
                    <i class="bi bi-check2-circle"></i>
                    Recortar y continuar
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mostrar u ocultar campos de contraseña.
    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            const field = document.getElementById(this.dataset.passwordToggle);
            const icon = this.querySelector('i');

            if (!field || !icon) return;

            const showPassword = field.type === 'password';
            field.type = showPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !showPassword);
            icon.classList.toggle('bi-eye-slash', showPassword);
        });
    });

    // Recorte de fotografía de perfil.
    const input = document.getElementById('profilePhotoInput');
    const image = document.getElementById('cropImage');
    const modalElement = document.getElementById('cropPhotoModal');
    const uploadButton = document.getElementById('uploadPhotoButton');

    if (!input || !image || !modalElement || !uploadButton || typeof bootstrap === 'undefined') {
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    let cropper = null;
    let imageUrl = null;

    input.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Selecciona un archivo de imagen válido.');
            this.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('La fotografía no puede superar los 5 MB.');
            this.value = '';
            return;
        }

        if (imageUrl) URL.revokeObjectURL(imageUrl);

        imageUrl = URL.createObjectURL(file);
        image.src = imageUrl;
        uploadButton.disabled = true;
        modal.show();
    });

    modalElement.addEventListener('shown.bs.modal', function () {
        if (typeof Cropper === 'undefined') {
            alert('No se pudo cargar la herramienta para recortar la fotografía.');
            modal.hide();
            return;
        }

        if (cropper) cropper.destroy();

        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.9,
            responsive: true,
            background: false,
            guides: true,
            center: true,
            movable: true,
            zoomable: true,
            rotatable: true,
            scalable: false,
        });
    });

    document.getElementById('zoomIn').addEventListener('click', function () {
        cropper?.zoom(0.1);
    });

    document.getElementById('zoomOut').addEventListener('click', function () {
        cropper?.zoom(-0.1);
    });

    document.getElementById('rotateLeft').addEventListener('click', function () {
        cropper?.rotate(-90);
    });

    document.getElementById('rotateRight').addEventListener('click', function () {
        cropper?.rotate(90);
    });

    document.getElementById('cropConfirm').addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 800,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function (blob) {
            if (!blob) {
                alert('No se pudo procesar la fotografía. Inténtalo nuevamente.');
                return;
            }

            const croppedFile = new File(
                [blob],
                'fotografia-perfil.jpg',
                { type: 'image/jpeg' }
            );

            const transfer = new DataTransfer();
            transfer.items.add(croppedFile);
            input.files = transfer.files;
            uploadButton.disabled = false;
            modal.hide();
        }, 'image/jpeg', 0.92);
    });

    modalElement.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        if (imageUrl) {
            URL.revokeObjectURL(imageUrl);
            imageUrl = null;
        }
    });
});
</script>
@endsection
