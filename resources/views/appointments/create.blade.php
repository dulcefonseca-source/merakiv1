
@extends('layouts.app')

@section('content')

<style>
    .appointment-page {
        color: var(--meraki-text);
    }

    .appointment-heading {
        margin-bottom: 25px;
    }

    .appointment-heading h2 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        margin-bottom: 5px;
    }

    .appointment-heading p {
        color: var(--meraki-muted);
        font-size: 14px;
        margin: 0;
    }

    .appointment-card {
        background: white;
        border: 1px solid var(--meraki-border);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .appointment-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        margin-bottom: 5px;
    }

    .appointment-section-description {
        font-size: 12px;
        color: var(--meraki-muted);
        margin-bottom: 22px;
    }

    .appointment-page .form-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--meraki-text);
        margin-bottom: 7px;
    }

    .appointment-page .form-control,
    .appointment-page .form-select {
        border: 1px solid var(--meraki-border);
        border-radius: 9px;
        padding: 11px 12px;
        font-size: 13px;
    }

    .appointment-page .form-control:focus,
    .appointment-page .form-select:focus {
        border-color: var(--meraki-primary);
        box-shadow: 0 0 0 3px rgba(189,137,128,.12);
    }

    .service-item {
        background: var(--meraki-ivory);
        border: 1px solid var(--meraki-border);
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 14px;
    }

    .btn-meraki {
        background: var(--meraki-primary);
        color: white;
        border: none;
        border-radius: 9px;
        padding: 11px 19px;
        font-size: 13px;
    }

    .btn-meraki:hover {
        background: var(--meraki-primary-dark);
        color: white;
    }

    .btn-outline-meraki {
        border: 1px solid var(--meraki-primary);
        color: var(--meraki-primary-dark);
        background: white;
        border-radius: 9px;
        padding: 9px 14px;
        font-size: 12px;
    }

    .btn-outline-meraki:hover {
        background: var(--meraki-rose);
        color: var(--meraki-primary-dark);
    }

    .remove-service {
        color: #B85D5D;
        background: transparent;
        border: none;
        font-size: 12px;
    }

    .required-mark {
        color: #B85D5D;
    }

    .form-note {
        font-size: 11px;
        color: var(--meraki-muted);
        margin-top: 5px;
    }
</style>

<div class="appointment-page">

    <div class="appointment-heading">
        <a href="{{ route('appointments.index') }}"
           class="text-decoration-none small"
           style="color: var(--meraki-primary-dark);">
            <i class="bi bi-arrow-left"></i> Volver a agenda
        </a>

        <h2 class="mt-3">Nueva cita</h2>
        <p>Registra una nueva reserva para tus clientas.</p>
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

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <!-- INFORMACIÓN DE LA CITA -->
        <div class="appointment-card">

            <h5 class="appointment-section-title">
                Información de la reserva
            </h5>

            <p class="appointment-section-description">
                Datos generales de la clienta y su cita.
            </p>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">
                        Clienta <span class="required-mark">*</span>
                    </label>

                    <select name="client_id" class="form-select" required>
                        <option value="">Seleccionar clienta</option>

                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>

                    @if($clients->isEmpty())
                        <div class="form-note">
                            Primero debes registrar una clienta en el módulo Clientas.
                        </div>
                    @endif
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Fecha <span class="required-mark">*</span>
                    </label>

                    <input type="date"
                           name="appointment_date"
                           class="form-control"
                           value="{{ old('appointment_date') }}"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Estado <span class="required-mark">*</span>
                    </label>

                    <select name="status" class="form-select" required>
                        <option value="pending"
                            {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                            Pendiente de confirmación
                        </option>

                        <option value="confirmed"
                            {{ old('status') == 'confirmed' ? 'selected' : '' }}>
                            Confirmada
                        </option>

                        <option value="completed"
                            {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Completada
                        </option>

                        <option value="cancelled"
                            {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelada
                        </option>

                        <option value="no_show"
                            {{ old('status') == 'no_show' ? 'selected' : '' }}>
                            No asistió
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Hora de inicio <span class="required-mark">*</span>
                    </label>

                    <input type="time"
                           name="start_time"
                           class="form-control"
                           value="{{ old('start_time') }}"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Hora de finalización
                    </label>

                    <input type="time"
                           name="end_time"
                           class="form-control"
                           value="{{ old('end_time') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lugar de la cita</label>

                    <select name="location" class="form-select">
                        <option value="">Seleccionar lugar</option>

                        <option value="Estudio"
                            {{ old('location') == 'Estudio' ? 'selected' : '' }}>
                            En el estudio
                        </option>

                        <option value="Domicilio"
                            {{ old('location') == 'Domicilio' ? 'selected' : '' }}>
                            A domicilio
                        </option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">
                        Dirección de domicilio
                    </label>

                    <textarea name="address"
                              class="form-control"
                              rows="2"
                              placeholder="Dirección si el servicio es a domicilio">{{ old('address') }}</textarea>
                </div>

            </div>
        </div>

        <!-- SERVICIOS -->
        <div class="appointment-card">

            <h5 class="appointment-section-title">
                Servicios solicitados
            </h5>

            <p class="appointment-section-description">
                Puedes agregar uno o varios servicios. Cada servicio puede
                tener su propia profesional, precio y duración.
            </p>

            <div id="services-container">

                <!-- PRIMER SERVICIO -->
                <div class="service-item">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong style="font-size:13px;">Servicio 1</strong>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">
                                Categoría <span class="required-mark">*</span>
                            </label>

                            <select name="services[0][category]"
                                    class="form-select category-select"
                                    required>
                                <option value="">Seleccionar categoría</option>
                                <option value="Uñas">Uñas</option>
                                <option value="Maquillaje">Maquillaje</option>
                                <option value="Peinados">Peinados</option>
                                <option value="Pestañas">Pestañas</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Servicio específico</label>

                            <select name="services[0][service_id]"
                                    class="form-select service-select">
                                <option value="">Por definir</option>
                            </select>

                            <div class="form-note">
                                Puedes dejarlo pendiente y completarlo después.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Precio acordado (Q)</label>

                            <input type="number"
                                   name="services[0][price]"
                                   class="form-control"
                                   min="0"
                                   step="0.01"
                                   placeholder="Precio pendiente">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Duración (minutos)</label>

                            <input type="number"
                                   name="services[0][duration_minutes]"
                                   class="form-control"
                                   min="1"
                                   max="65535"
                                   placeholder="Ej. 150">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Profesional asignada</label>

                            <select name="services[0][staff_id]"
                                    class="form-select staff-select">
                                <option value="">Seleccionar profesional</option>

                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}">
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="form-note">
                                Puedes modificar la sugerencia.
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <button type="button"
                    class="btn-outline-meraki"
                    id="add-service">
                <i class="bi bi-plus-lg"></i>
                Agregar otro servicio
            </button>

        </div>

        <!-- OBSERVACIONES -->
        <div class="appointment-card">

            <h5 class="appointment-section-title">
                Observaciones
            </h5>

            <p class="appointment-section-description">
                Información adicional sobre la reserva.
            </p>

            <textarea name="notes"
                      class="form-control"
                      rows="4"
                      placeholder="Ej. La clienta enviará una fotografía de referencia...">{{ old('notes') }}</textarea>

        </div>

        <!-- ACCIONES -->
        <div class="d-flex justify-content-end gap-2 mb-4">

            <a href="{{ route('appointments.index') }}"
               class="btn btn-light border rounded-3 px-4"
               style="font-size:13px;">
                Cancelar
            </a>

            <button type="submit"
                    class="btn-meraki"
                    @if($clients->isEmpty()) disabled @endif>
                <i class="bi bi-calendar-check me-1"></i>
                Guardar cita
            </button>

        </div>

    </form>

</div>

<script>
    const availableServices = @json($servicesForJs);

    const availableStaff = @json(
        $staff->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->name
            ];
        })->values()
    );

    let serviceIndex = 1;

    // SUGERIR PROFESIONAL SEGÚN CATEGORÍA
    function suggestProfessional(card) {

        const category = card.querySelector('.category-select').value;
        const staffSelect = card.querySelector('.staff-select');

        if (!staffSelect) return;

        const suggested = category === 'Peinados'
            ? 'Jessy'
            : 'Pao';

        const option = Array.from(staffSelect.options).find(item =>
            item.textContent.trim().toLowerCase() === suggested.toLowerCase()
        );

        if (option) {
            staffSelect.value = option.value;
        }
    }

    // CARGAR SERVICIOS SEGÚN CATEGORÍA
    function updateServiceOptions(card) {

        const categorySelect = card.querySelector('.category-select');
        const serviceSelect = card.querySelector('.service-select');

        const category = categorySelect.value;

        serviceSelect.innerHTML = '<option value="">Por definir</option>';

        availableServices
            .filter(service => service.category === category)
            .forEach(service => {

                const option = document.createElement('option');

                option.value = service.id;
                option.textContent = service.name;

                option.dataset.price = service.price ?? '';
                option.dataset.duration = service.duration ?? '';
                option.dataset.staff = service.staff_id ?? '';

                serviceSelect.appendChild(option);
            });

        // Limpiar precio y duración anteriores
        card.querySelector('[name$="[price]"]').value = '';
        card.querySelector('[name$="[duration_minutes]"]').value = '';
    }

    // CARGAR DATOS DEL SERVICIO SELECCIONADO
    function updateServiceDetails(card) {

        const serviceSelect = card.querySelector('.service-select');
        const selectedOption = serviceSelect.selectedOptions[0];

        const priceInput = card.querySelector('[name$="[price]"]');
        const durationInput = card.querySelector('[name$="[duration_minutes]"]');

        if (serviceSelect.value) {

            priceInput.value = selectedOption.dataset.price || '';
            durationInput.value = selectedOption.dataset.duration || '';

            // Asignar profesional registrada en el catálogo
            const staffSelect = card.querySelector('.staff-select');
            const serviceStaff = selectedOption.dataset.staff;

            if (staffSelect && serviceStaff) {
                staffSelect.value = serviceStaff;
            }

        } else {

            priceInput.value = '';
            durationInput.value = '';
        }
    }

    // CONFIGURAR EVENTOS DE UNA TARJETA
    function configureServiceCard(card) {

        card.querySelector('.category-select').addEventListener('change', () => {

            updateServiceOptions(card);
            suggestProfessional(card);

        });

        card.querySelector('.service-select').addEventListener('change', () => {

            updateServiceDetails(card);

        });

    }

    // CONFIGURAR PRIMER SERVICIO
    document.querySelectorAll('.service-item').forEach(card => {
        configureServiceCard(card);
    });

    // AGREGAR SERVICIOS ADICIONALES
    document.getElementById('add-service').addEventListener('click', function () {

        const container = document.getElementById('services-container');

        const card = document.createElement('div');

        card.className = 'service-item';

        const staffOptions = availableStaff.map(member => `
            <option value="${member.id}">${member.name}</option>
        `).join('');

        card.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">

                <strong style="font-size:13px;">
                    Servicio ${serviceIndex + 1}
                </strong>

                <button type="button" class="remove-service">
                    <i class="bi bi-trash"></i> Quitar
                </button>

            </div>

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Categoría *</label>

                    <select name="services[${serviceIndex}][category]"
                            class="form-select category-select"
                            required>

                        <option value="">Seleccionar categoría</option>
                        <option value="Uñas">Uñas</option>
                        <option value="Maquillaje">Maquillaje</option>
                        <option value="Peinados">Peinados</option>
                        <option value="Pestañas">Pestañas</option>

                    </select>
                </div>

                <div class="col-md-8">
                    <label class="form-label">Servicio específico</label>

                    <select name="services[${serviceIndex}][service_id]"
                            class="form-select service-select">

                        <option value="">Por definir</option>

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Precio acordado (Q)</label>

                    <input type="number"
                           name="services[${serviceIndex}][price]"
                           class="form-control"
                           min="0"
                           step="0.01"
                           placeholder="Precio pendiente">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Duración (minutos)</label>

                    <input type="number"
                           name="services[${serviceIndex}][duration_minutes]"
                           class="form-control"
                           min="1"
                           max="65535"
                           placeholder="Ej. 150">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Profesional asignada</label>

                    <select name="services[${serviceIndex}][staff_id]"
                            class="form-select staff-select">

                        <option value="">Seleccionar profesional</option>
                        ${staffOptions}

                    </select>

                    <div class="form-note">
                        Puedes modificar la sugerencia.
                    </div>
                </div>

            </div>
        `;

        container.appendChild(card);

        configureServiceCard(card);

        card.querySelector('.remove-service').addEventListener('click', () => {
            card.remove();
        });

        serviceIndex++;

    });

</script>

@endsection
