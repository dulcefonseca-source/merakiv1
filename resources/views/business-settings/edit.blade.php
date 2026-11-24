
@extends('layouts.app')

@section('title', 'Administración del estudio')
@section('page-title', 'Administración del estudio')

@section('content')
<div class="container-fluid px-0 business-settings-page">

    {{-- Encabezado --}}
    <div class="settings-heading mb-4">
        <div>
            <span class="settings-eyebrow">PERSONALIZACIÓN DEL NEGOCIO</span>
            <h2>Administración del estudio</h2>
            <p>Personaliza la identidad y la información de Meraki.</p>
        </div>

        <div class="settings-heading-icon">
            <i class="bi bi-shop"></i>
        </div>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>No se pudieron guardar los cambios.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('business-settings.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- IDENTIDAD VISUAL --}}
        <div class="settings-card mb-4">

            <div class="settings-card-heading">
                <div class="settings-icon">
                    <i class="bi bi-stars"></i>
                </div>
                <div>
                    <h5>Identidad visual</h5>
                    <p>La imagen que representa a tu estudio.</p>
                </div>
            </div>

            <div class="row g-4">

                {{-- Logotipo --}}
                <div class="col-lg-4">
                    <label class="form-label settings-label">Logotipo del estudio</label>

                    <div class="image-upload-box logo-upload">
                        <div class="logo-preview-container">
                            <img
                                id="logoPreview"
                                src="{{ $settings->logo_path ? asset('storage/'.$settings->logo_path) : '' }}"
                                alt="Vista previa del logotipo"
                                class="{{ $settings->logo_path ? '' : 'd-none' }}"
                            >

                            <div id="logoPlaceholder"
                                 class="{{ $settings->logo_path ? 'd-none' : '' }}">
                                <i class="bi bi-image"></i>
                                <span>Sin logotipo</span>
                            </div>
                        </div>

                        <label for="logo" class="upload-button">
                            <i class="bi bi-upload me-2"></i>
                            Seleccionar logotipo
                        </label>

                        <input
                            type="file"
                            name="logo"
                            id="logo"
                            class="d-none"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small>JPG, PNG o WEBP. Máximo 2 MB.</small>
                    </div>
                </div>

                {{-- Portada --}}
                <div class="col-lg-8">
                    <label class="form-label settings-label">Fotografía de portada</label>

                    <div class="cover-upload-box">
                        <img
                            id="coverPreview"
                            src="{{ $settings->cover_path ? asset('storage/'.$settings->cover_path) : '' }}"
                            alt="Vista previa de portada"
                            class="{{ $settings->cover_path ? '' : 'd-none' }}"
                        >

                        <div id="coverPlaceholder"
                             class="cover-placeholder {{ $settings->cover_path ? 'd-none' : '' }}">
                            <i class="bi bi-card-image"></i>
                            <span>Tu fotografía de portada aparecerá aquí</span>
                        </div>
                    </div>

                    <label for="cover" class="upload-button mt-3">
                        <i class="bi bi-camera me-2"></i>
                        Seleccionar fotografía
                    </label>

                    <input
                        type="file"
                        name="cover"
                        id="cover"
                        class="d-none"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="upload-hint">JPG, PNG o WEBP. Máximo 5 MB.</small>
                </div>

            </div>
        </div>

        {{-- INFORMACIÓN DEL ESTUDIO --}}
        <div class="settings-card mb-4">

            <div class="settings-card-heading">
                <div class="settings-icon">
                    <i class="bi bi-shop-window"></i>
                </div>
                <div>
                    <h5>Información del estudio</h5>
                    <p>Datos principales que identifican a Meraki.</p>
                </div>
            </div>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label settings-label">Nombre del negocio *</label>
                    <input
                        type="text"
                        name="business_name"
                        class="form-control"
                        value="{{ old('business_name', $settings->business_name) }}"
                        placeholder="Meraki Estudio de Belleza"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">Frase o lema</label>
                    <input
                        type="text"
                        name="tagline"
                        class="form-control"
                        value="{{ old('tagline', $settings->tagline) }}"
                        placeholder="Tu belleza, nuestra inspiración."
                        maxlength="255"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">Teléfono</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $settings->phone) }}"
                        placeholder="Número de contacto"
                        maxlength="30"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">WhatsApp</label>
                    <input
                        type="text"
                        name="whatsapp"
                        class="form-control"
                        value="{{ old('whatsapp', $settings->whatsapp) }}"
                        placeholder="Número de WhatsApp"
                        maxlength="30"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">Correo electrónico</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $settings->email) }}"
                        placeholder="correo@ejemplo.com"
                        maxlength="150"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">Dirección</label>
                    <input
                        type="text"
                        name="address"
                        class="form-control"
                        value="{{ old('address', $settings->address) }}"
                        placeholder="Dirección del estudio"
                    >
                </div>

            </div>
        </div>

        {{-- REDES SOCIALES --}}
        <div class="settings-card mb-4">

            <div class="settings-card-heading">
                <div class="settings-icon">
                    <i class="bi bi-share"></i>
                </div>
                <div>
                    <h5>Redes sociales</h5>
                    <p>Conecta los perfiles digitales de tu negocio.</p>
                </div>
            </div>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label settings-label">
                        <i class="bi bi-instagram me-2"></i>Instagram
                    </label>
                    <input
                        type="text"
                        name="instagram"
                        class="form-control"
                        value="{{ old('instagram', $settings->instagram) }}"
                        placeholder="@usuario o enlace del perfil"
                        maxlength="255"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">
                        <i class="bi bi-facebook me-2"></i>Facebook
                    </label>
                    <input
                        type="text"
                        name="facebook"
                        class="form-control"
                        value="{{ old('facebook', $settings->facebook) }}"
                        placeholder="Enlace de la página"
                        maxlength="255"
                    >
                </div>

            </div>
        </div>

        {{-- APARIENCIA --}}
        <div class="settings-card mb-4">

            <div class="settings-card-heading">
                <div class="settings-icon">
                    <i class="bi bi-palette"></i>
                </div>
                <div>
                    <h5>Apariencia del sistema</h5>
                    <p>Personaliza los colores institucionales de Meraki.</p>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label settings-label">Color principal</label>

                    <div class="color-control">
                        <input
                            type="color"
                            name="primary_color"
                            id="primaryColor"
                            value="{{ old('primary_color', $settings->primary_color) }}"
                        >
                        <div>
                            <strong>Color principal</strong>
                            <small id="primaryColorText">
                                {{ old('primary_color', $settings->primary_color) }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label settings-label">Color secundario</label>

                    <div class="color-control">
                        <input
                            type="color"
                            name="secondary_color"
                            id="secondaryColor"
                            value="{{ old('secondary_color', $settings->secondary_color) }}"
                        >
                        <div>
                            <strong>Color secundario</strong>
                            <small id="secondaryColorText">
                                {{ old('secondary_color', $settings->secondary_color) }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="appearance-preview">
                        <span>Vista previa de la combinación</span>
                        <div class="appearance-preview-colors">
                            <div id="primarySwatch"></div>
                            <div id="secondarySwatch"></div>
                        </div>
                        <strong id="appearancePreviewName">
                            Meraki Estudio de Belleza
                        </strong>
                        <small>Identidad visual del estudio</small>
                    </div>
                </div>

            </div>
        </div>

        {{-- GUARDAR --}}
        <div class="settings-save-bar">
            <div>
                <strong>¿Todo listo?</strong>
                <small>Guarda los cambios para actualizar la información de Meraki.</small>
            </div>

            <button type="submit" class="btn btn-save-settings">
                <i class="bi bi-check2-circle me-2"></i>
                Guardar cambios
            </button>
        </div>

    </form>

</div>
@endsection

@push('styles')
<style>
.business-settings-page {
    color: #71636a;
}

.settings-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.settings-eyebrow {
    color: #b77d82;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
}

.settings-heading h2 {
    color: #654d50;
    font-family: 'Playfair Display', serif;
    font-size: 27px;
    margin: 7px 0;
}

.settings-heading p {
    color: #998b90;
    font-size: 13px;
    margin: 0;
}

.settings-heading-icon {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8e9ed;
    border-radius: 16px;
    color: #b77d82;
    font-size: 24px;
}

.settings-card {
    background: #fff;
    padding: 27px;
    border: 1px solid #f0e5e3;
    border-radius: 17px;
    box-shadow: 0 5px 20px rgba(90,65,68,.04);
}

.settings-card-heading {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 25px;
}

.settings-icon {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9edef;
    border-radius: 13px;
    color: #b77d82;
    font-size: 19px;
}

.settings-card-heading h5 {
    color: #654d50;
    font-weight: 650;
    font-size: 15px;
    margin: 0 0 4px;
}

.settings-card-heading p {
    color: #a4969a;
    font-size: 11px;
    margin: 0;
}

.settings-label {
    color: #76646a;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 9px;
}

.settings-card .form-control {
    min-height: 45px;
    border: 1px solid #eee3e2;
    border-radius: 10px;
    color: #66565b;
    font-size: 13px;
    padding: 11px 13px;
    background: #fff;
}

.settings-card .form-control:focus {
    border-color: #c79b98;
    box-shadow: 0 0 0 3px rgba(189,137,128,.12);
}

.settings-card .form-control::placeholder {
    color: #c0b4b7;
}

.image-upload-box {
    border: 1px dashed #ddc9c8;
    background: #fdf9f8;
    border-radius: 14px;
    padding: 18px;
    text-align: center;
}

.logo-preview-container {
    height: 155px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.logo-preview-container img {
    max-width: 100%;
    max-height: 145px;
    object-fit: contain;
}

.logo-preview-container div {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: #b49a9c;
    font-size: 12px;
}

.logo-preview-container i {
    font-size: 35px;
}

.cover-upload-box {
    width: 100%;
    height: 195px;
    border: 1px dashed #ddc9c8;
    border-radius: 14px;
    overflow: hidden;
    background: #fdf9f8;
}

.cover-upload-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cover-placeholder {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #b49a9c;
    font-size: 12px;
}

.cover-placeholder i {
    font-size: 35px;
}

.upload-button {
    display: inline-block;
    background: #f5e8e7;
    color: #966e70;
    padding: 9px 14px;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.upload-button:hover {
    background: #ead5d3;
}

.image-upload-box small,
.upload-hint {
    display: block;
    color: #aa9b9f;
    font-size: 10px;
    margin-top: 11px;
}

.color-control {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px;
    border: 1px solid #eee3e2;
    border-radius: 12px;
}

.color-control input[type="color"] {
    width: 52px;
    height: 45px;
    padding: 3px;
    background: #fff;
    border: 1px solid #eee3e2;
    border-radius: 9px;
    cursor: pointer;
}

.color-control div {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.color-control strong {
    color: #654d50;
    font-size: 12px;
}

.color-control small {
    color: #a4969a;
    font-size: 11px;
}

.appearance-preview {
    padding: 20px;
    border-radius: 13px;
    border: 1px solid #eee3e2;
    background: #fdfafa;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 9px;
}

.appearance-preview > span {
    color: #998b90;
    font-size: 11px;
}

.appearance-preview-colors {
    display: flex;
    gap: 8px;
}

.appearance-preview-colors div {
    width: 42px;
    height: 12px;
    border-radius: 20px;
}

#primarySwatch {
    background: #bd8980;
}

#secondarySwatch {
    background: #654d50;
}

.appearance-preview strong {
    color: #654d50;
    font-family: 'Playfair Display', serif;
    font-size: 18px;
}

.appearance-preview small {
    color: #a4969a;
    font-size: 10px;
}

.settings-save-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: 20px 23px;
    background: #fff;
    border: 1px solid #f0e5e3;
    border-radius: 15px;
    margin-bottom: 25px;
}

.settings-save-bar div {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.settings-save-bar strong {
    color: #654d50;
    font-size: 13px;
}

.settings-save-bar small {
    color: #998b90;
    font-size: 11px;
}

.btn-save-settings {
    background: #bd8980;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 22px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.btn-save-settings:hover {
    background: #a9716b;
    color: #fff;
}

@media(max-width: 600px) {
    .settings-card {
        padding: 18px;
    }

    .settings-heading h2 {
        font-size: 22px;
    }

    .settings-save-bar {
        align-items: stretch;
        flex-direction: column;
    }

    .btn-save-settings {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Vista previa del logotipo
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');
    const logoPlaceholder = document.getElementById('logoPlaceholder');

    logoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            logoPreview.src = URL.createObjectURL(file);
            logoPreview.classList.remove('d-none');
            logoPlaceholder.classList.add('d-none');
        }
    });

    // Vista previa de portada
    const coverInput = document.getElementById('cover');
    const coverPreview = document.getElementById('coverPreview');
    const coverPlaceholder = document.getElementById('coverPlaceholder');

    coverInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            coverPreview.src = URL.createObjectURL(file);
            coverPreview.classList.remove('d-none');
            coverPlaceholder.classList.add('d-none');
        }
    });

    // Personalización de colores
    const primaryColor = document.getElementById('primaryColor');
    const secondaryColor = document.getElementById('secondaryColor');

    function updateColors() {
        document.getElementById('primaryColorText').textContent = primaryColor.value.toUpperCase();
        document.getElementById('secondaryColorText').textContent = secondaryColor.value.toUpperCase();

        document.getElementById('primarySwatch').style.background = primaryColor.value;
        document.getElementById('secondarySwatch').style.background = secondaryColor.value;
    }

    primaryColor.addEventListener('input', updateColors);
    secondaryColor.addEventListener('input', updateColors);

    updateColors();

    // Actualizar nombre en la vista previa
    const businessName = document.querySelector('[name="business_name"]');
    const previewName = document.getElementById('appearancePreviewName');

    businessName.addEventListener('input', function () {
        previewName.textContent = this.value || 'Meraki Estudio de Belleza';
    });

});
</script>
@endpush
