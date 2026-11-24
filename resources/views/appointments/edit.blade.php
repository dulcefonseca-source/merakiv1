



@extends('layouts.app')







@section('content')







@php



    $availableServicesData = $services->map(function ($service) {



        return [



            'id' => $service->id,



            'name' => $service->name,



            'category' => $service->category,



            'price' => $service->price,



            'duration' => $service->duration_minutes,



            'staff_id' => $service->staff_id,



        ];



    })->values();







    $availableStaffData = $staff->map(function ($member) {



        return [



            'id' => $member->id,



            'name' => $member->name,



        ];



    })->values();



@endphp







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







    <!-- ENCABEZADO -->



    <div class="appointment-heading">







        <a href="{{ route('appointments.index') }}"



           class="text-decoration-none small"



           style="color: var(--meraki-primary-dark);">



            <i class="bi bi-arrow-left"></i> Volver a agenda



        </a>







        <h2 class="mt-3">Editar cita</h2>







        <p>Actualiza la información de la reserva.</p>







    </div>







    <!-- ERRORES -->



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







    <form action="{{ route('appointments.update', $appointment) }}"



          method="POST">







        @csrf



        @method('PUT')







        <!-- INFORMACIÓN GENERAL -->



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



                                {{ old('client_id', $appointment->client_id) == $client->id ? 'selected' : '' }}>







                                {{ $client->name }}







                            </option>







                        @endforeach







                    </select>







                </div>







                <div class="col-md-3">







                    <label class="form-label">



                        Fecha <span class="required-mark">*</span>



                    </label>







                    <input type="date"



                           name="appointment_date"



                           class="form-control"



                           value="{{ old('appointment_date', \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('Y-m-d')) }}"



                           required>







                </div>







                <div class="col-md-3">







                    <label class="form-label">Estado</label>







                    <select name="status" class="form-select" required>







                        @foreach([



                            'pending' => 'Pendiente de confirmación',



                            'confirmed' => 'Confirmada',



                            'completed' => 'Completada',



                            'cancelled' => 'Cancelada',



                            'no_show' => 'No asistió'



                        ] as $value => $label)







                            <option value="{{ $value }}"



                                {{ old('status', $appointment->status) == $value ? 'selected' : '' }}>







                                {{ $label }}







                            </option>







                        @endforeach







                    </select>







                </div>







                <div class="col-md-3">







                    <label class="form-label">



                        Hora de inicio <span class="required-mark">*</span>



                    </label>







                    <input type="time"



                           name="start_time"



                           class="form-control"



                           value="{{ old('start_time', substr((string)$appointment->start_time, 0, 5)) }}"



                           required>







                </div>







                <div class="col-md-3">







                    <label class="form-label">Hora de finalización</label>







                    <input type="time"



                           name="end_time"



                           class="form-control"



                           value="{{ old('end_time', $appointment->end_time ? substr((string)$appointment->end_time, 0, 5) : '') }}">







                </div>







                <div class="col-md-6">







                    <label class="form-label">Lugar de la cita</label>







                    <select name="location" class="form-select">







                        <option value="">Seleccionar lugar</option>







                        <option value="Estudio"



                            {{ old('location', $appointment->location) == 'Estudio' ? 'selected' : '' }}>



                            En el estudio



                        </option>







                        <option value="Domicilio"



                            {{ old('location', $appointment->location) == 'Domicilio' ? 'selected' : '' }}>



                            A domicilio



                        </option>







                    </select>







                </div>







                <div class="col-12">







                    <label class="form-label">Dirección de domicilio</label>







                    <textarea name="address"



                              class="form-control"



                              rows="2"



                              placeholder="Dirección si el servicio es a domicilio">{{ old('address', $appointment->address) }}</textarea>







                </div>







            </div>







        </div>







        <!-- SERVICIOS -->



        <div class="appointment-card">







            <h5 class="appointment-section-title">



                Servicios solicitados



            </h5>







            <p class="appointment-section-description">



                Modifica los servicios, precios, duraciones y profesionales.



            </p>







            <div id="services-container">







                @foreach($appointment->appointmentServices as $index => $item)







                    <div class="service-item">







                        <!-- ID DEL SERVICIO EXISTENTE -->



                        <input type="hidden"



                               name="services[{{ $index }}][id]"



                               value="{{ $item->id }}">







                        <div class="d-flex justify-content-between align-items-center mb-3">







                            <strong style="font-size:13px;">



                                Servicio {{ $index + 1 }}



                            </strong>







                            <button type="button" class="remove-service">



                                <i class="bi bi-trash"></i> Quitar



                            </button>







                        </div>







                        <div class="row g-3">







                            <div class="col-md-4">







                                <label class="form-label">Categoría *</label>







                                <select name="services[{{ $index }}][category]"



                                        class="form-select category-select"



                                        required>







                                    <option value="">Seleccionar categoría</option>







                                    @foreach(['Uñas', 'Maquillaje', 'Peinados', 'Pestañas', 'Adicionales', 'Otros'] as $category)







                                        <option value="{{ $category }}"



                                            {{ $item->category == $category ? 'selected' : '' }}>







                                            {{ $category }}







                                        </option>







                                    @endforeach







                                </select>







                            </div>







                            <div class="col-md-8">







                                <label class="form-label">Servicio específico</label>







                                <select name="services[{{ $index }}][service_id]"



                                        class="form-select service-select">







                                    <option value="">Por definir</option>







                                    @foreach($services->where('category', $item->category) as $service)







                                        <option value="{{ $service->id }}"



                                            {{ $item->service_id == $service->id ? 'selected' : '' }}>







                                            {{ $service->name }}







                                        </option>







                                    @endforeach







                                </select>







                            </div>







                            <div class="col-md-4">







                                <label class="form-label">Precio acordado (Q)</label>







                                <input type="number"



                                       name="services[{{ $index }}][price]"



                                       class="form-control"



                                       min="0"



                                       step="0.01"



                                       value="{{ $item->price }}">







                            </div>







                            <div class="col-md-4">







                                <label class="form-label">Duración (minutos)</label>







                                <input type="number"



                                       name="services[{{ $index }}][duration_minutes]"



                                       class="form-control"



                                       min="1"



                                       max="65535"



                                       value="{{ $item->duration_minutes }}">







                            </div>







                            <div class="col-md-4">







                                <label class="form-label">Profesional asignada</label>







                                <select name="services[{{ $index }}][staff_id]"



                                        class="form-select staff-select">







                                    <option value="">Seleccionar profesional</option>







                                    @foreach($staff as $member)







                                        <option value="{{ $member->id }}"



                                            {{ $item->staff_id == $member->id ? 'selected' : '' }}>







                                            {{ $member->name }}







                                        </option>







                                    @endforeach







                                </select>







                            </div>







                        </div>







                    </div>







                @endforeach







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



                      placeholder="Observaciones de la cita...">{{ old('notes', $appointment->notes) }}</textarea>







        </div>







        <!-- ACCIONES -->



        <div class="d-flex justify-content-end gap-2 mb-4">







            <a href="{{ route('appointments.index') }}"



               class="btn btn-light border rounded-3 px-4"



               style="font-size:13px;">



                Cancelar



            </a>







            <button type="submit" class="btn-meraki">



                <i class="bi bi-check-circle me-1"></i>



                Guardar cambios



            </button>







        </div>







    </form>





    {{-- PAGOS Y ANTICIPOS --}}

    @php

        $totalAppointment = $appointment->appointmentServices->sum('price');

        $totalPaid = $appointment->payments->sum('amount');

        $balance = max(0, $totalAppointment - $totalPaid);



        $paymentPercentage = $totalAppointment > 0

            ? min(100, ($totalPaid / $totalAppointment) * 100)

            : 0;



        $categories = $appointment->appointmentServices

            ->pluck('category')

            ->filter()

            ->unique();



        $hasNails = $categories->contains('Uñas');

        $hasMakeup = $categories->contains('Maquillaje');

        $hasHair = $categories->contains('Peinados');



        if ($hasNails || $hasMakeup) {

            $depositPercentage = max(

                $hasNails ? config('meraki.deposits.nails_percentage', 50) : 0,

                $hasMakeup ? config('meraki.deposits.makeup_percentage', 50) : 0

            );

        } elseif ($hasHair) {

            $depositPercentage = config('meraki.deposits.hair_percentage', 50);

        } else {

            $depositPercentage = 0;

        }



        $suggestedAdvance = round($totalAppointment * $depositPercentage / 100, 2);



        if ($totalAppointment <= 0) {

            $paymentStatus = 'Sin precio definido';

            $paymentStatusColor = 'secondary';

        } elseif ($balance <= 0) {

            $paymentStatus = 'Pagada';

            $paymentStatusColor = 'success';

        } elseif ($totalPaid > 0) {

            $paymentStatus = 'Pago parcial';

            $paymentStatusColor = 'warning';

        } else {

            $paymentStatus = 'Pendiente de pago';

            $paymentStatusColor = 'danger';

        }

    @endphp



    <div class="appointment-card">



        <h5 class="appointment-section-title">Pagos y anticipos</h5>



        <p class="appointment-section-description">

            Consulta los pagos recibidos y el saldo pendiente de esta reserva.

        </p>



        <div class="mb-3">

            <span class="badge bg-{{ $paymentStatusColor }}">

                {{ $paymentStatus }}

            </span>



            <span class="small text-muted ms-2">

                Anticipo sugerido: {{ $depositPercentage }} %

                (Q{{ number_format($suggestedAdvance, 2) }})

            </span>

        </div>



        <div class="row g-3 mb-4">



            <div class="col-md-4">

                <div class="p-3 rounded-3" style="background:var(--meraki-ivory);">

                    <small class="text-muted">Total de la cita</small>

                    <h4 class="mt-2 mb-0">

                        Q{{ number_format($totalAppointment, 2) }}

                    </h4>

                </div>

            </div>



            <div class="col-md-4">

                <div class="p-3 rounded-3" style="background:#edf6ef;">

                    <small class="text-muted">Total pagado</small>

                    <h4 class="mt-2 mb-0 text-success">

                        Q{{ number_format($totalPaid, 2) }}

                    </h4>

                </div>

            </div>



            <div class="col-md-4">

                <div class="p-3 rounded-3" style="background:#fbf0ed;">

                    <small class="text-muted">Saldo pendiente</small>

                    <h4 class="mt-2 mb-0" style="color:#B85D5D;">

                        Q{{ number_format($balance, 2) }}

                    </h4>

                </div>

            </div>



        </div>



        <div class="progress mb-4" style="height:8px;">

            <div class="progress-bar"

                 role="progressbar"

                 aria-valuenow="{{ $paymentPercentage }}"

                 aria-valuemin="0"

                 aria-valuemax="100"

                 style="width:{{ $paymentPercentage }}%; background:var(--meraki-primary);">

            </div>

        </div>



        @if($balance > 0)



            <div class="p-3 rounded-3 mb-4"

                 style="background:var(--meraki-ivory); border:1px solid var(--meraki-border);">



                <h6 class="mb-3">Registrar un pago</h6>



                <form action="{{ route('appointments.payments.store', $appointment) }}"

                      method="POST">



                    @csrf



                    <div class="row g-3">



                        <div class="col-md-4">

                            <label class="form-label">Monto (Q)</label>

                            <input type="number"

                                   name="amount"

                                   class="form-control"

                                   min="0.01"

                                   max="{{ $balance }}"

                                   step="0.01"

                                   value="{{ old('amount', $totalPaid == 0 && $suggestedAdvance > 0 ? min($suggestedAdvance, $balance) : '') }}"

                                   placeholder="0.00"

                                   required>

                            <small class="form-note">

                                Puedes modificar el anticipo sugerido.

                            </small>

                        </div>



                        <div class="col-md-4">

                            <label class="form-label">Fecha y hora</label>

                            <input type="datetime-local"

                                   name="payment_date"

                                   class="form-control"

                                   value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}"

                                   required>

                        </div>



                        <div class="col-md-4">

                            <label class="form-label">Método de pago</label>

                            <select name="payment_method" class="form-select" required>

                                <option value="">Seleccionar</option>

                                <option value="efectivo" {{ old('payment_method') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>

                                <option value="transferencia" {{ old('payment_method') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>

                                <option value="tarjeta" {{ old('payment_method') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>

                            </select>

                        </div>



                        <div class="col-md-6">

                            <label class="form-label">Referencia</label>

                            <input type="text"

                                   name="reference"

                                   class="form-control"

                                   value="{{ old('reference') }}"

                                   placeholder="Número de transferencia, si aplica">

                        </div>



                        <div class="col-md-6">

                            <label class="form-label">Observaciones</label>

                            <input type="text"

                                   name="notes"

                                   class="form-control"

                                   value="{{ old('notes') }}"

                                   placeholder="Ej. Anticipo de la reserva">

                        </div>



                        <div class="col-12">

                            <button type="submit" class="btn-meraki">

                                <i class="bi bi-plus-circle me-1"></i>

                                Registrar pago

                            </button>

                        </div>



                    </div>

                </form>

            </div>



        @else



            <div class="alert alert-success border-0 rounded-3">

                <i class="bi bi-check-circle me-2"></i>

                Esta cita se encuentra pagada en su totalidad.

            </div>



        @endif



        @if($totalAppointment > 0 && $balance <= 0 && $appointment->payments->isNotEmpty())
            @php
                $finalPayment = $appointment->payments->sortByDesc('payment_date')->first();
            @endphp

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('appointments.payments.receipt', $finalPayment) }}"
                   target="_blank"
                   class="btn-meraki text-decoration-none">
                    <i class="bi bi-receipt me-1"></i>
                    Ver comprobante final
                </a>
            </div>
        @endif

        <h6 class="mb-3">Historial de pagos</h6>



        @forelse($appointment->payments->sortByDesc('payment_date') as $payment)



            <div class="d-flex justify-content-between align-items-center border-bottom py-3">



                <div>

                    <strong>Q{{ number_format($payment->amount, 2) }}</strong>



                    <div class="small text-muted mt-1">

                        {{ $payment->payment_date->format('d/m/Y h:i A') }}

                        · {{ ucfirst($payment->payment_method) }}

                    </div>



                    @if($payment->reference)

                        <div class="small text-muted">

                            Referencia: {{ $payment->reference }}

                        </div>

                    @endif



                    @if($payment->notes)

                        <div class="small text-muted">

                            {{ $payment->notes }}

                        </div>

                    @endif

                </div>



                <div class="d-flex align-items-center">







                    <form action="{{ route('appointments.payments.destroy', $payment) }}"

                          method="POST"

                          onsubmit="return confirm('¿Deseas eliminar este registro de pago?')">



                        @csrf

                        @method('DELETE')



                        <button type="submit"

                                class="btn btn-sm btn-outline-danger"

                                title="Eliminar pago">

                            <i class="bi bi-trash"></i>

                        </button>



                    </form>

                </div>



            </div>



        @empty



            <p class="text-muted small mb-0">

                Todavía no se han registrado pagos para esta cita.

            </p>



        @endforelse



    </div>



</div>



<script>



    const availableServices = @json($availableServicesData);



    const availableStaff = @json($availableStaffData);







    let serviceIndex = {{ $appointment->appointmentServices->count() }};







    // SUGERIR PROFESIONAL



    function suggestProfessional(card) {







        const category = card.querySelector('.category-select').value;



        const staffSelect = card.querySelector('.staff-select');







        if (!staffSelect) return;







        const suggested = category === 'Peinados' ? 'Jessy' : 'Pao';







        const option = Array.from(staffSelect.options).find(item =>



            item.textContent.trim().toLowerCase() === suggested.toLowerCase()



        );







        if (option) {



            staffSelect.value = option.value;



        }



    }







    // CARGAR SERVICIOS SEGÚN CATEGORÍA



    function updateServiceOptions(card) {







        const category = card.querySelector('.category-select').value;



        const serviceSelect = card.querySelector('.service-select');







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







        card.querySelector('[name$="[price]"]').value = '';



        card.querySelector('[name$="[duration_minutes]"]').value = '';



    }







    // CARGAR DATOS DEL SERVICIO SELECCIONADO



    function updateServiceDetails(card) {







        const serviceSelect = card.querySelector('.service-select');



        const selectedOption = serviceSelect.selectedOptions[0];







        const priceInput = card.querySelector('[name$="[price]"]');



        const durationInput = card.querySelector('[name$="[duration_minutes]"]');







        if (!serviceSelect.value) {



            priceInput.value = '';



            durationInput.value = '';



            return;



        }







        priceInput.value = selectedOption.dataset.price || '';



        durationInput.value = selectedOption.dataset.duration || '';







        const staffSelect = card.querySelector('.staff-select');







        if (staffSelect && selectedOption.dataset.staff) {



            staffSelect.value = selectedOption.dataset.staff;



        }



    }







    // CONFIGURAR TARJETA



    function configureServiceCard(card) {







        card.querySelector('.category-select').addEventListener('change', () => {







            updateServiceOptions(card);



            suggestProfessional(card);







        });







        card.querySelector('.service-select').addEventListener('change', () => {







            updateServiceDetails(card);







        });







        const removeButton = card.querySelector('.remove-service');







        if (removeButton) {



            removeButton.addEventListener('click', () => {



                card.remove();



            });



        }



    }







    // CONFIGURAR SERVICIOS EXISTENTES



    document.querySelectorAll('.service-item').forEach(card => {



        configureServiceCard(card);



    });







    // AGREGAR SERVICIOS NUEVOS



    document.getElementById('add-service').addEventListener('click', () => {







        const container = document.getElementById('services-container');



        const card = document.createElement('div');







        card.className = 'service-item';







        const staffOptions = availableStaff.map(member => {



            return \`<option value="${member.id}">${member.name}</option>\`;



        }).join('');







        card.innerHTML = \`







            <div class="d-flex justify-content-between align-items-center mb-3">







                <strong style="font-size:13px;">



                    Servicio ${serviceIndex + 1}



                </strong>







                <button type="button" class="remove-service">



                    <i class="bi bi-trash"></i> Quitar



                </button>







            </div>







            <input type="hidden"



                   name="services[${serviceIndex}][id]"



                   value="">







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



                        <option value="Adicionales">Adicionales</option>



                        <option value="Otros">Otros</option>







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



                           step="0.01">







                </div>







                <div class="col-md-4">







                    <label class="form-label">Duración (minutos)</label>







                    <input type="number"



                           name="services[${serviceIndex}][duration_minutes]"



                           class="form-control"



                           min="1"



                           max="65535">







                </div>







                <div class="col-md-4">







                    <label class="form-label">Profesional asignada</label>







                    <select name="services[${serviceIndex}][staff_id]"



                            class="form-select staff-select">







                        <option value="">Seleccionar profesional</option>







                        ${staffOptions}







                    </select>







                </div>







            </div>



        \`;







        container.appendChild(card);







        configureServiceCard(card);







        serviceIndex++;







    });







</script>







@endsection
