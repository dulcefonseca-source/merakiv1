
@extends('layouts.app')

@section('title', 'Nuevo cliente')
@section('page-title', 'Registrar cliente')

@section('content')

<div class="form-heading">
    <div>
        <span class="heading-label">DIRECTORIO MERAKI</span>
        <h2>Registrar nuevo cliente</h2>
        <p>Agrega la información de una persona a tu directorio.</p>
    </div>

    <a href="{{ route('clients.index') }}" class="btn btn-meraki-outline">
        <i class="bi bi-arrow-left me-2"></i>
        Volver
    </a>
</div>

<div class="content-card client-form-card">

    <div class="form-intro">
        <div class="form-icon">
            <i class="bi bi-person-heart"></i>
        </div>

        <div>
            <h5>Información del cliente</h5>
            <p>Los campos marcados con * son obligatorios.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa la información ingresada:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            <div class="col-12">
                <h6 class="form-section-title">
                    <i class="bi bi-person me-2"></i>
                    Datos personales
                </h6>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nombre completo *</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Ej. María Fernanda López"
                    value="{{ old('name') }}"
                    maxlength="255"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Número de teléfono</label>
                <input
                    type="tel"
                    name="phone"
                    class="form-control"
                    placeholder="Ej. 5555-5555"
                    value="{{ old('phone') }}"
                    maxlength="20"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="correo@ejemplo.com"
                    value="{{ old('email') }}"
                    maxlength="255"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Fecha de cumpleaños</label>
                <input
                    type="date"
                    name="birth_date"
                    class="form-control"
                    value="{{ old('birth_date') }}"
                >
            </div>

            <div class="col-12 mt-4">
                <h6 class="form-section-title">
                    <i class="bi bi-geo-alt me-2"></i>
                    Información adicional
                </h6>
            </div>

            <div class="col-12">
                <label class="form-label">Dirección</label>
                <textarea
                    name="address"
                    class="form-control"
                    rows="2"
                    placeholder="Dirección del cliente (opcional)"
                >{{ old('address') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Observaciones</label>
                <textarea
                    name="notes"
                    class="form-control"
                    rows="3"
                    placeholder="Preferencias, recomendaciones u otros detalles..."
                >{{ old('notes') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('clients.index') }}" class="btn btn-light">
                Cancelar
            </a>

            <button type="submit" class="btn btn-meraki">
                <i class="bi bi-check-lg me-2"></i>
                Guardar cliente
            </button>
        </div>

    </form>

</div>

@endsection

@push('styles')
<style>
    .form-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .heading-label {
        color: var(--meraki-primary);
        font-size: 10px;
        letter-spacing: 1.7px;
        font-weight: 700;
    }

    .form-heading h2 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        margin: 7px 0;
    }

    .form-heading p {
        color: var(--meraki-muted);
        font-size: 13px;
        margin: 0;
    }

    .client-form-card {
        max-width: 950px;
    }

    .form-intro {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 25px;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--meraki-border);
    }

    .form-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        background: var(--meraki-rose);
        color: var(--meraki-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .form-intro h5 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 4px;
    }

    .form-intro p {
        color: var(--meraki-muted);
        font-size: 11px;
        margin: 0;
    }

    .form-section-title {
        color: var(--meraki-primary-dark);
        font-size: 13px;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--meraki-border);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid var(--meraki-border);
        margin-top: 30px;
        padding-top: 22px;
    }

    @media (max-width: 576px) {
        .form-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush
