
@extends('layouts.app')

@section('title', 'Nuevo servicio')
@section('page-title', 'Registrar servicio')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-semibold mb-1"
                style="font-family: 'Playfair Display', serif; color: var(--meraki-text);">
                Nuevo servicio
            </h2>
            <p class="small mb-0" style="color: var(--meraki-muted);">
                Agrega un nuevo servicio al catálogo de Meraki.
            </p>
        </div>

        <a href="{{ route('services.index') }}"
           class="btn btn-light rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i>
            Volver al catálogo
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3">
            <strong>Revisa los siguientes datos:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- Formulario --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="mb-4">
                        <h5 class="fw-semibold mb-1"
                            style="color: var(--meraki-text);">
                            Información del servicio
                        </h5>
                        <p class="small mb-0"
                           style="color: var(--meraki-muted);">
                            Completa los datos para registrar el servicio.
                        </p>
                    </div>

                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nombre del servicio <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control rounded-3 @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Ej. Soft gel con diseños"
                                   maxlength="255"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Categoría
                            </label>

                            <select name="category"
                                    id="category"
                                    class="form-select rounded-3 @error('category') is-invalid @enderror">

                                <option value="">Selecciona una categoría</option>

                                @foreach(['Uñas', 'Maquillaje', 'Peinados', 'Pestañas', 'Adicionales', 'Otros'] as $item)
                                    <option value="{{ $item }}"
                                        {{ old('category') == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Profesional responsable --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Profesional responsable
                            </label>

                            <select name="staff_id"
                                    id="staff_id"
                                    class="form-select rounded-3 @error('staff_id') is-invalid @enderror">

                                <option value="">Selecciona una profesional</option>

                                @foreach($staff as $person)
                                    <option value="{{ $person->id }}"
                                            data-name="{{ $person->name }}"
                                        {{ old('staff_id') == $person->id ? 'selected' : '' }}>
                                        {{ $person->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('staff_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2" id="staff-suggestion">
                                La profesional se sugerirá según la categoría.
                            </small>
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Descripción
                            </label>

                            <textarea name="description"
                                      rows="3"
                                      class="form-control rounded-3"
                                      placeholder="Describe brevemente el servicio, sus características o condiciones...">{{ old('description') }}</textarea>
                        </div>

                        <hr style="border-color: var(--meraki-border);">

                        
{{-- Precio y duración --}}
<div class="mb-3">
    <h6 class="fw-semibold mb-1" style="color: var(--meraki-text);">
        Precio y duración
    </h6>
    <p class="small text-muted">
        Configura cómo se cobrará el servicio. El importe puede ajustarse según la solicitud de la clienta.
    </p>
</div>

<div class="row g-3">

    {{-- Modalidad de precio --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Modalidad de precio <span class="text-danger">*</span>
        </label>

        <select name="price_type" id="price_type"
                class="form-select rounded-3 @error('price_type') is-invalid @enderror"
                required>
            <option value="fixed" {{ old('price_type', 'fixed') === 'fixed' ? 'selected' : '' }}>
                Precio fijo
            </option>
            <option value="from" {{ old('price_type') === 'from' ? 'selected' : '' }}>
                Precio desde
            </option>
            <option value="variable" {{ old('price_type') === 'variable' ? 'selected' : '' }}>
                Precio variable
            </option>
            <option value="per_unit" {{ old('price_type') === 'per_unit' ? 'selected' : '' }}>
                Precio por unidad
            </option>
        </select>

        @error('price_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Importe --}}
    <div class="col-md-6" id="price-container">
        <label class="form-label fw-semibold" id="price-label">
            Precio (Q)
        </label>

        <div class="input-group">
            <span class="input-group-text rounded-start-3">Q</span>

            <input type="number"
                   name="price"
                   id="price"
                   class="form-control rounded-end-3 @error('price') is-invalid @enderror"
                   value="{{ old('price') }}"
                   placeholder="Ej. 150.00"
                   min="0"
                   step="0.01">
        </div>

        @error('price')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror

        <small class="text-muted" id="price-help">
            Precio establecido para el servicio.
        </small>
    </div>

    {{-- Unidad de cobro --}}
    <div class="col-md-6" id="price-unit-container" style="display: none;">
        <label class="form-label fw-semibold">
            Unidad de cobro <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="price_unit"
               id="price_unit"
               class="form-control rounded-3 @error('price_unit') is-invalid @enderror"
               value="{{ old('price_unit') }}"
               placeholder="Ej. pieza, pareja, aplicación"
               maxlength="50">

        @error('price_unit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <small class="text-muted">
            Indica cómo se contabiliza el importe.
        </small>
    </div>

    {{-- Duración --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Duración estimada
        </label>

        <div class="input-group">
            <input type="number"
                   name="duration_minutes"
                   class="form-control rounded-start-3 @error('duration_minutes') is-invalid @enderror"
                   value="{{ old('duration_minutes') }}"
                   placeholder="Ej. 150"
                   min="1"
                   max="65535">

            <span class="input-group-text rounded-end-3">
                minutos
            </span>
        </div>

        @error('duration_minutes')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror

        <small class="text-muted">
            Puedes dejarlo vacío si depende del servicio solicitado.
        </small>
    </div>
    
<div class="col-md-4">
    <label class="form-label">
        Profesional asignada
    </label>

    <select name="services[0][staff_id]" class="form-select staff-select">
        <option value="">Seleccionar profesional</option>

        @foreach($staff as $member)
            <option value="{{ $member->id }}">
                {{ $member->name }}
            </option>
        @endforeach
    </select>

    <div class="form-note">
        Puedes cambiar la asignación si es necesario.
    </div>
</div>


</div>

                        {{-- Estado --}}
                        <div class="d-flex justify-content-between align-items-center gap-3 p-3 rounded-3"
                             style="background: var(--meraki-ivory);">

                            <div>
                                <label class="fw-semibold mb-1">
                                    Servicio activo
                                </label>
                                <p class="small text-muted mb-0">
                                    Los servicios activos estarán disponibles para registrar citas.
                                </p>
                            </div>

                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_active"
                                       value="1"
                                       id="is_active"
                                       {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                       style="width: 42px; height: 22px;">
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">

                            <a href="{{ route('services.index') }}"
                               class="btn btn-light rounded-3 px-4">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn text-white rounded-3 px-4"
                                    style="background: var(--meraki-primary);">
                                <i class="bi bi-check2-circle me-1"></i>
                                Guardar servicio
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- Panel informativo --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="service-info-icon mb-3">
                        <i class="bi bi-stars"></i>
                    </div>

                    <h5 class="fw-semibold mb-2"
                        style="color: var(--meraki-text);">
                        Catálogo organizado
                    </h5>

                    <p class="small text-muted mb-4">
                        Mantén los servicios del estudio organizados para facilitar la gestión de las citas.
                    </p>

                    <div class="service-tip">
                        <i class="bi bi-person-check"></i>
                        <div>
                            <strong>Profesionales asignadas</strong>
                            <p>Cada servicio tendrá una profesional responsable predeterminada.</p>
                        </div>
                    </div>

                    <div class="service-tip">
                        <i class="bi bi-tag"></i>
                        <div>
                            <strong>Precios variables</strong>
                            <p>Si el costo depende del diseño, puedes dejar el precio vacío.</p>
                        </div>
                    </div>

                    <div class="service-tip">
                        <i class="bi bi-clock"></i>
                        <div>
                            <strong>Duraciones estimadas</strong>
                            <p>Registra el tiempo habitual que requiere cada servicio.</p>
                        </div>
                    </div>

                    <div class="service-tip">
                        <i class="bi bi-toggle-on"></i>
                        <div>
                            <strong>Control de disponibilidad</strong>
                            <p>Puedes desactivar temporalmente un servicio sin perder su información.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<style>
    .form-control,
    .form-select,
    .input-group-text {
        border-color: var(--meraki-border);
        font-size: 13px;
        padding: 11px 13px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--meraki-primary);
        box-shadow: 0 0 0 3px rgba(189, 137, 128, .12);
    }

    .form-check-input {
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--meraki-primary);
        border-color: var(--meraki-primary);
    }

    .service-info-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--meraki-rose);
        color: var(--meraki-primary-dark);
        font-size: 21px;
    }

    .service-tip {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .service-tip > i {
        font-size: 17px;
        color: var(--meraki-primary);
        margin-top: 2px;
    }

    .service-tip strong {
        display: block;
        font-size: 12px;
        color: var(--meraki-text);
        margin-bottom: 4px;
    }

    .service-tip p {
        font-size: 11px;
        color: var(--meraki-muted);
        margin: 0;
        line-height: 1.6;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const categorySelect = document.getElementById('category');
    const staffSelect = document.getElementById('staff_id');
    const suggestion = document.getElementById('staff-suggestion');

// Modalidades de precio
const priceType = document.getElementById('price_type');
const priceInput = document.getElementById('price');
const priceLabel = document.getElementById('price-label');
const priceHelp = document.getElementById('price-help');
const priceUnitContainer = document.getElementById('price-unit-container');
const priceUnitInput = document.getElementById('price_unit');

function updatePriceFields() {

    const type = priceType.value;

    priceUnitContainer.style.display =
        type === 'per_unit' ? 'block' : 'none';

    priceUnitInput.required = type === 'per_unit';

    switch (type) {

        case 'fixed':
            priceLabel.textContent = 'Precio fijo (Q)';
            priceInput.placeholder = 'Ej. 350.00';
            priceHelp.textContent = 'Importe establecido para el servicio.';
            break;

        case 'from':
            priceLabel.textContent = 'Precio inicial (Q)';
            priceInput.placeholder = 'Ej. 250.00';
            priceHelp.textContent = 'La tarifa comienza desde este importe.';
            break;

        case 'variable':
            priceLabel.textContent = 'Precio de referencia (Q)';
            priceInput.placeholder = 'Opcional';
            priceHelp.textContent = 'El importe final se determinará según el diseño o solicitud.';
            break;

        case 'per_unit':
            priceLabel.textContent = 'Precio por unidad (Q)';
            priceInput.placeholder = 'Ej. 2.00';
            priceHelp.textContent = 'Importe que se cobrará por cada unidad.';
            break;
    }
}

priceType.addEventListener('change', updatePriceFields);
updatePriceFields();


    function suggestStaff(preserveSelection = false) {

        const category = categorySelect.value;

        const suggestedName = category === 'Peinados'
            ? 'Jessy'
            : 'Pao';

        const options = Array.from(staffSelect.options);

        const suggestedOption = options.find(option =>
            option.dataset.name === suggestedName
        );

        if (!preserveSelection || !staffSelect.value) {
            if (suggestedOption) {
                staffSelect.value = suggestedOption.value;
            } else {
                staffSelect.value = '';
            }
        }

        if (suggestedOption) {
            suggestion.textContent =
                'Profesional sugerida para esta categoría: ' +
                suggestedName + '. Puedes cambiarla si lo necesitas.';
        } else {
            suggestion.textContent =
                'No hay una profesional activa configurada para esta categoría.';
        }
    }

    // Al cargar, conserva la selección anterior si hubo un error.
    suggestStaff(true);

    // Al cambiar la categoría, actualiza la profesional sugerida.
    categorySelect.addEventListener('change', function () {
        suggestStaff(false);
    });

});
</script>

@endsection
