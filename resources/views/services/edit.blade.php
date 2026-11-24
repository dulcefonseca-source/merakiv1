
@extends('layouts.app')

@section('title', 'Editar servicio')
@section('page-title', 'Editar servicio')

@section('content')

<div class="container-fluid px-0">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-semibold mb-1"
                style="font-family: 'Playfair Display', serif; color: var(--meraki-text);">
                Editar servicio
            </h2>

            <p class="small mb-0" style="color: var(--meraki-muted);">
                Modifica la información del servicio seleccionado.
            </p>
        </div>

        <a href="{{ route('services.index') }}"
           class="btn btn-light rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i>
            Volver al catálogo
        </a>
    </div>

    {{-- ERRORES --}}
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

        {{-- FORMULARIO --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="mb-4">
                        <h5 class="fw-semibold mb-1"
                            style="color: var(--meraki-text);">
                            Información del servicio
                        </h5>

                        <p class="small text-muted mb-0">
                            Actualiza los datos del catálogo.
                        </p>
                    </div>

                    <form action="{{ route('services.update', $service) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        {{-- NOMBRE --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nombre del servicio <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control rounded-3 @error('name') is-invalid @enderror"
                                   value="{{ old('name', $service->name) }}"
                                   maxlength="255"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CATEGORÍA --}}
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
                                        {{ old('category', $service->category) == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach

                                @if($service->category && !in_array($service->category, ['Uñas', 'Maquillaje', 'Peinados', 'Pestañas', 'Adicionales', 'Otros']))
                                    <option value="{{ $service->category }}"
                                        {{ old('category', $service->category) == $service->category ? 'selected' : '' }}>
                                        {{ $service->category }}
                                    </option>
                                @endif

                            </select>

                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PROFESIONAL RESPONSABLE --}}
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
                                        {{ (string) old('staff_id', $service->staff_id) === (string) $person->id ? 'selected' : '' }}>
                                        {{ $person->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('staff_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2" id="staff-suggestion">
                                Puedes seleccionar la profesional responsable del servicio.
                            </small>
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Descripción
                            </label>

                            <textarea name="description"
                                      rows="3"
                                      class="form-control rounded-3"
                                      placeholder="Descripción del servicio...">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <hr style="border-color: var(--meraki-border);">

                        {{-- PRECIO Y DURACIÓN --}}
                        <div class="mb-3">
                            <h6 class="fw-semibold mb-1"
                                style="color: var(--meraki-text);">
                                Precio y duración
                            </h6>

                            <p class="small text-muted">
                                Configura la modalidad de cobro y el importe del servicio.
                            </p>
                        </div>

                        <div class="row g-3">

                            {{-- MODALIDAD --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Modalidad de precio
                                </label>

                                <select name="price_type"
                                        id="price_type"
                                        class="form-select rounded-3 @error('price_type') is-invalid @enderror"
                                        required>

                                    <option value="fixed"
                                        {{ old('price_type', $service->price_type ?? 'fixed') === 'fixed' ? 'selected' : '' }}>
                                        Precio fijo
                                    </option>

                                    <option value="from"
                                        {{ old('price_type', $service->price_type ?? 'fixed') === 'from' ? 'selected' : '' }}>
                                        Precio desde
                                    </option>

                                    <option value="variable"
                                        {{ old('price_type', $service->price_type ?? 'fixed') === 'variable' ? 'selected' : '' }}>
                                        Precio variable
                                    </option>

                                    <option value="per_unit"
                                        {{ old('price_type', $service->price_type ?? 'fixed') === 'per_unit' ? 'selected' : '' }}>
                                        Precio por unidad
                                    </option>

                                </select>

                                @error('price_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IMPORTE --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" id="price-label">
                                    Precio fijo (Q)
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text rounded-start-3">Q</span>

                                    <input type="number"
                                           name="price"
                                           id="price"
                                           class="form-control rounded-end-3 @error('price') is-invalid @enderror"
                                           value="{{ old('price', $service->price) }}"
                                           placeholder="Ej. 150.00"
                                           min="0"
                                           step="0.01">
                                </div>

                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                <small class="text-muted" id="price-help">
                                    Importe establecido para el servicio.
                                </small>
                            </div>

                            {{-- UNIDAD DE COBRO --}}
                            <div class="col-md-6"
                                 id="price-unit-container"
                                 style="display: none;">

                                <label class="form-label fw-semibold">
                                    Unidad de cobro
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="price_unit"
                                       id="price_unit"
                                       class="form-control rounded-3 @error('price_unit') is-invalid @enderror"
                                       value="{{ old('price_unit', $service->price_unit) }}"
                                       placeholder="Ej. pieza, pareja, aplicación"
                                       maxlength="50">

                                @error('price_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">
                                    Indica cómo se contabiliza el importe.
                                </small>
                            </div>

                            {{-- DURACIÓN --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Duración estimada
                                </label>

                                <div class="input-group">
                                    <input type="number"
                                           name="duration_minutes"
                                           class="form-control rounded-start-3 @error('duration_minutes') is-invalid @enderror"
                                           value="{{ old('duration_minutes', $service->duration_minutes) }}"
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
                                    Vacío si depende del servicio.
                                </small>
                            </div>

                        </div>

                        <hr style="border-color: var(--meraki-border);">

                        {{-- ESTADO --}}
                        <div class="d-flex justify-content-between align-items-center gap-3 p-3 rounded-3"
                             style="background: var(--meraki-ivory);">

                            <div>
                                <label for="is_active" class="fw-semibold mb-1">
                                    Servicio activo
                                </label>

                                <p class="small text-muted mb-0">
                                    Controla si estará disponible para nuevas citas.
                                </p>
                            </div>

                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_active"
                                       value="1"
                                       id="is_active"
                                       {{ old('is_active', $service->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                                       style="width: 42px; height: 22px;">
                            </div>

                        </div>

                        {{-- BOTONES --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">

                            <a href="{{ route('services.index') }}"
                               class="btn btn-light rounded-3 px-4">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn text-white rounded-3 px-4"
                                    style="background: var(--meraki-primary);">
                                <i class="bi bi-check2-circle me-1"></i>
                                Guardar cambios
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- PANEL INFORMATIVO --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="service-info-icon mb-3">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <h5 class="fw-semibold mb-2"
                        style="color: var(--meraki-text);">
                        Actualización del servicio
                    </h5>

                    <p class="small text-muted mb-3">
                        Los cambios se aplicarán al catálogo una vez guardados.
                    </p>

                    <div class="p-3 rounded-3"
                         style="background: var(--meraki-ivory);">

                        <small class="text-muted d-block mb-1">
                            Servicio seleccionado
                        </small>

                        <strong style="color: var(--meraki-text);">
                            {{ $service->name }}
                        </strong>

                        <small class="text-muted d-block mt-3 mb-1">
                            Registrado el
                        </small>

                        <strong style="color: var(--meraki-text);">
                            {{ $service->created_at?->format('d/m/Y') }}
                        </strong>

                    </div>

                    <hr style="border-color: var(--meraki-border);">

                    <div class="service-tip">
                        <i class="bi bi-tag"></i>
                        <div>
                            <strong>Modalidades de precio</strong>
                            <p>Configura precios fijos, iniciales, variables o por unidad.</p>
                        </div>
                    </div>

                    <div class="service-tip">
                        <i class="bi bi-person-check"></i>
                        <div>
                            <strong>Profesional responsable</strong>
                            <p>Selecciona quién estará a cargo del servicio.</p>
                        </div>
                    </div>

                    <div class="service-tip">
                        <i class="bi bi-clock"></i>
                        <div>
                            <strong>Duración estimada</strong>
                            <p>Actualiza el tiempo habitual de atención.</p>
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

    // ELEMENTOS DE PROFESIONALES
    const categorySelect = document.getElementById('category');
    const staffSelect = document.getElementById('staff_id');
    const suggestion = document.getElementById('staff-suggestion');

    // SUGERENCIA DE PROFESIONAL
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

    suggestStaff(true);

    categorySelect.addEventListener('change', function () {
        suggestStaff(false);
    });


    // ELEMENTOS DE PRECIO
    const priceType = document.getElementById('price_type');
    const priceInput = document.getElementById('price');
    const priceLabel = document.getElementById('price-label');
    const priceHelp = document.getElementById('price-help');
    const unitContainer = document.getElementById('price-unit-container');
    const unitInput = document.getElementById('price_unit');

    // ACTUALIZACIÓN DINÁMICA DE PRECIOS
    function updatePriceFields() {

        const type = priceType.value;

        unitContainer.style.display =
            type === 'per_unit' ? 'block' : 'none';

        unitInput.required = type === 'per_unit';

        switch (type) {

            case 'fixed':
                priceLabel.textContent = 'Precio fijo (Q)';
                priceInput.placeholder = 'Ej. 350.00';
                priceHelp.textContent =
                    'Importe establecido para el servicio.';
                break;

            case 'from':
                priceLabel.textContent = 'Precio inicial (Q)';
                priceInput.placeholder = 'Ej. 250.00';
                priceHelp.textContent =
                    'La tarifa comienza desde este importe.';
                break;

            case 'variable':
                priceLabel.textContent = 'Precio de referencia (Q)';
                priceInput.placeholder = 'Opcional';
                priceHelp.textContent =
                    'El importe final dependerá del diseño o solicitud.';
                break;

            case 'per_unit':
                priceLabel.textContent = 'Precio por unidad (Q)';
                priceInput.placeholder = 'Ej. 2.00';
                priceHelp.textContent =
                    'Importe que se cobrará por cada unidad.';
                break;
        }
    }

    priceType.addEventListener('change', updatePriceFields);

    // Cargar modalidad guardada al abrir el formulario
    updatePriceFields();

});
</script>

@endsection
