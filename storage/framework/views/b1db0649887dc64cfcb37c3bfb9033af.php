


<?php $__env->startSection('content'); ?>

<style>
    .agenda-page { color: var(--meraki-text); }

    .agenda-heading {
        display:flex; justify-content:space-between; align-items:center;
        flex-wrap:wrap; gap:15px; margin-bottom:25px;
    }

    .agenda-heading h2 {
        font-family:'Playfair Display',serif;
        font-size:28px; margin-bottom:5px;
    }

    .agenda-heading p {
        color:var(--meraki-muted); font-size:14px; margin:0;
    }

    .agenda-button {
        background:var(--meraki-primary); color:white; border:0;
        border-radius:9px; padding:11px 17px; font-size:13px;
        text-decoration:none; display:inline-flex;
        align-items:center; gap:7px;
    }

    .agenda-button:hover {
        background:var(--meraki-primary-dark); color:white;
    }

    .agenda-card {
        background:white; border:1px solid var(--meraki-border);
        border-radius:15px; padding:22px;
    }

    .agenda-card-heading h5 {
        font-family:'Playfair Display',serif; margin-bottom:5px;
    }

    .agenda-card-heading p {
        font-size:12px; color:var(--meraki-muted); margin-bottom:20px;
    }

    .agenda-filters {
        display:flex; align-items:end; flex-wrap:wrap; gap:15px;
        padding:16px; background:#FBF9F7;
        border:1px solid var(--meraki-border);
        border-radius:11px; margin-bottom:22px;
    }

    .agenda-filter { flex:1; min-width:190px; }

    .agenda-filter label {
        display:block; font-size:11px; font-weight:600;
        color:var(--meraki-muted); margin-bottom:7px;
        text-transform:uppercase; letter-spacing:.5px;
    }

    .agenda-filter select {
        width:100%; border:1px solid var(--meraki-border);
        border-radius:8px; padding:10px 12px;
        background:white; color:var(--meraki-text);
        font-size:13px; outline:none;
    }

    .agenda-filter select:focus {
        border-color:var(--meraki-primary);
        box-shadow:0 0 0 3px rgba(189,137,128,.12);
    }

    .agenda-reset {
        border:1px solid var(--meraki-primary); background:white;
        color:var(--meraki-primary-dark); border-radius:8px;
        padding:10px 14px; font-size:12px; cursor:pointer; height:39px;
    }

    .agenda-reset:hover { background:var(--meraki-rose); }

    #calendar { font-size:13px; }

    #calendar .fc-toolbar-title {
        font-family:'Playfair Display',serif; font-size:21px;
        color:var(--meraki-text); text-transform:capitalize;
    }

    #calendar .fc-button {
        background:var(--meraki-primary);
        border-color:var(--meraki-primary);
        border-radius:7px; font-size:12px;
        box-shadow:none; text-transform:capitalize;
    }

    #calendar .fc-button:hover,
    #calendar .fc-button:focus,
    #calendar .fc-button-active {
        background:var(--meraki-primary-dark)!important;
        border-color:var(--meraki-primary-dark)!important;
        box-shadow:none!important;
    }

    #calendar .fc-day-today { background:#FBF4F2!important; }
    #calendar .fc-col-header-cell { background:#FBF9F7; padding:10px 0; }

    #calendar .fc-col-header-cell-cushion {
        color:var(--meraki-muted); text-decoration:none;
        font-size:11px; text-transform:uppercase; letter-spacing:.5px;
    }

    #calendar .fc-daygrid-day-number {
        color:var(--meraki-text); text-decoration:none; padding:9px;
    }

    #calendar .fc-event {
        border-radius:5px; border:none;
        padding:3px 5px; font-size:11px; cursor:pointer;
    }

    #calendar .fc-timegrid-event { padding:3px; }

    #calendar .fc-daygrid-more-link {
        color:var(--meraki-primary-dark); font-size:11px;
    }

    .agenda-legend {
        display:flex; flex-wrap:wrap; gap:18px;
        margin-top:20px; padding-top:17px;
        border-top:1px solid var(--meraki-border);
    }

    .legend-item {
        display:flex; align-items:center; gap:7px;
        color:var(--meraki-muted); font-size:11px;
    }

    .legend-dot { width:9px; height:9px; border-radius:50%; }

    .agenda-note {
        font-size:12px; color:var(--meraki-muted);
        margin-top:15px; margin-bottom:0;
    }

    /* Ventana de detalle */
    .appointment-modal .modal-content {
        border:0; border-radius:18px; overflow:hidden;
    }

    .appointment-modal .modal-header {
        background:#FBF4F2;
        border-bottom:1px solid var(--meraki-border);
        padding:22px 25px;
    }

    .appointment-modal .modal-title {
        font-family:'Playfair Display',serif;
        font-size:22px; color:var(--meraki-text);
    }

    .appointment-modal .modal-body { padding:24px; }

    .detail-label {
        color:var(--meraki-muted); font-size:10px;
        text-transform:uppercase; letter-spacing:.7px;
        font-weight:700; margin-bottom:5px;
    }

    .detail-value {
        font-size:13px; font-weight:600;
        color:var(--meraki-text);
    }

    .detail-block {
        background:#FBF9F7;
        border:1px solid var(--meraki-border);
        border-radius:11px; padding:13px; height:100%;
    }

    .detail-service {
        display:flex; justify-content:space-between;
        align-items:flex-start; gap:12px;
        padding:13px 0; border-bottom:1px solid #F1E9E7;
    }

    .detail-service:last-child { border-bottom:0; }

    .detail-service-name { font-size:13px; font-weight:600; }

    .detail-service-meta {
        color:var(--meraki-muted); font-size:11px; margin-top:4px;
    }

    .detail-service-price {
        font-size:13px; font-weight:700; white-space:nowrap;
    }

    .detail-total {
        background:#FBF4F2; border-radius:11px;
        padding:15px; margin-top:12px;
    }

    .detail-total strong {
        font-family:'Playfair Display',serif;
        font-size:23px; color:var(--meraki-primary-dark);
    }

    .detail-status {
        display:inline-block; padding:6px 12px;
        border-radius:20px; font-size:11px; font-weight:700;
    }

    .detail-status.pending { background:#FFF3DD; color:#A87520; }
    .detail-status.confirmed { background:#E6F3EC; color:#387653; }
    .detail-status.completed { background:#E9EDF8; color:#536A9C; }
    .detail-status.cancelled { background:#FCE9E9; color:#B85D5D; }
    .detail-status.no_show { background:#F0E9F0; color:#805D80; }

    .appointment-modal .modal-footer {
        border-top:1px solid var(--meraki-border);
        padding:16px 24px;
    }

    #quickStatus {
        border:1px solid var(--meraki-border);
        border-radius:8px;
        color:var(--meraki-text);
        font-size:12px;
        min-width:145px;
    }

    #quickStatus:focus {
        border-color:var(--meraki-primary);
        box-shadow:0 0 0 3px rgba(189,137,128,.12);
    }

    @media(max-width:768px) {
        .agenda-card { padding:12px; }

        #calendar .fc-toolbar {
            display:flex; flex-direction:column; gap:12px;
        }

        #calendar .fc-toolbar-title { font-size:18px; }

        #calendar .fc-toolbar-chunk {
            display:flex; justify-content:center;
        }

        .agenda-filters { align-items:stretch; }

        .appointment-modal .modal-body { padding:17px; }
    }
</style>

<div class="agenda-page">

    <div class="agenda-heading">
        <div>
            <h2>Agenda</h2>
            <p>Organiza tus citas y mantén cada reserva bajo control.</p>
        </div>

        <a href="<?php echo e(route('appointments.create')); ?>" class="agenda-button">
            <i class="bi bi-plus-lg"></i>
            Nueva cita
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success border-0 rounded-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="agenda-card">

        <div class="agenda-card-heading">
            <h5>Calendario de citas</h5>
            <p>Consulta y organiza las reservas por día, semana o mes.</p>
        </div>

        <!-- Filtros -->
        <div class="agenda-filters">

            <div class="agenda-filter">
                <label for="filterStatus">Estado de la cita</label>
                <select id="filterStatus">
                    <option value="">Todos los estados</option>
                    <option value="pending">Pendientes</option>
                    <option value="confirmed">Confirmadas</option>
                    <option value="completed">Completadas</option>
                    <option value="cancelled">Canceladas</option>
                    <option value="no_show">No asistió</option>
                </select>
            </div>

            <div class="agenda-filter">
                <label for="filterStaff">Profesional</label>
                <select id="filterStaff">
                    <option value="">Todas las profesionales</option>

                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($person->id); ?>">
                            <?php echo e($person->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <button type="button" class="agenda-reset" id="resetFilters">
                <i class="bi bi-arrow-counterclockwise"></i>
                Limpiar filtros
            </button>

        </div>

        <div id="calendar"></div>

        <!-- Leyenda -->
        <div class="agenda-legend">
            <div class="legend-item">
                <span class="legend-dot" style="background:#D5B69C;"></span>
                Pendiente
            </div>

            <div class="legend-item">
                <span class="legend-dot" style="background:#8FAF9A;"></span>
                Confirmada
            </div>

            <div class="legend-item">
                <span class="legend-dot" style="background:#9AA8C7;"></span>
                Completada
            </div>

            <div class="legend-item">
                <span class="legend-dot" style="background:#D99A9A;"></span>
                Cancelada
            </div>

            <div class="legend-item">
                <span class="legend-dot" style="background:#B69AB8;"></span>
                No asistió
            </div>
        </div>

        <p class="agenda-note">
            <i class="bi bi-info-circle"></i>
            Selecciona una cita para consultar sus detalles.
        </p>

    </div>
</div>

<!-- Ventana emergente -->
<div class="modal fade appointment-modal" id="appointmentModal"
     tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <div class="detail-label">Meraki Estudio de Belleza</div>
                    <h5 class="modal-title">Detalle de la reserva</h5>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">

                <!-- Clienta y estado -->
                <div class="row align-items-start g-3 mb-4">

                    <div class="col-md-7">
                        <div class="detail-label">Clienta</div>
                        <h4 id="detailClient" class="mb-1"
                            style="font-family:'Playfair Display',serif;"></h4>
                        <div class="detail-value" id="detailPhone"></div>
                    </div>

                    <div class="col-md-5">

                        <div class="mb-3">
                            <span id="detailStatus" class="detail-status"></span>
                        </div>

                        <label for="quickStatus" class="detail-label">
                            Actualizar estado de la cita
                        </label>

                        <div class="d-flex gap-2">
                            <select id="quickStatus" class="form-select form-select-sm">
                                <option value="pending">Pendiente</option>
                                <option value="confirmed">Confirmada</option>
                                <option value="completed">Completada</option>
                                <option value="cancelled">Cancelada</option>
                                <option value="no_show">No asistió</option>
                            </select>

                            <button type="button" id="saveQuickStatus"
                                    class="agenda-button"
                                    style="padding:7px 12px; white-space:nowrap;">
                                Guardar
                            </button>
                        </div>

                        <small id="statusFeedback" class="d-block mt-2"></small>
                    </div>

                </div>

                <!-- Información general -->
                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <div class="detail-block">
                            <div class="detail-label">Fecha</div>
                            <div class="detail-value" id="detailDate"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-block">
                            <div class="detail-label">Horario</div>
                            <div class="detail-value" id="detailTime"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-block">
                            <div class="detail-label">Lugar</div>
                            <div class="detail-value" id="detailLocation"></div>
                        </div>
                    </div>

                </div>

                <!-- Servicios -->
                <div class="detail-label mb-2">Servicios solicitados</div>
                <div id="detailServices"></div>

                <div class="detail-total d-flex justify-content-between align-items-center">
                    <div>
                        <div class="detail-label mb-1">Total de servicios</div>
                        <small id="detailTotalNote" class="text-muted"></small>
                    </div>

                    <strong id="detailTotal"></strong>
                </div>

                <!-- Dirección y observaciones -->
                <div class="row g-3 mt-2">

                    <div class="col-md-6">
                        <div class="detail-block">
                            <div class="detail-label">Dirección</div>
                            <div class="detail-value" id="detailAddress"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-block">
                            <div class="detail-label">Observaciones</div>
                            <div class="detail-value" id="detailNotes"></div>
                        </div>
                    </div>

                </div>

                <!-- Pagos: pendiente de implementar -->
                <div class="row g-3 mt-2">

                    <div class="col-6">
                        <div class="detail-block">
                            <div class="detail-label">Anticipo</div>
                            <div class="detail-value text-muted">No registrado</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="detail-block">
                            <div class="detail-label">Saldo pendiente</div>
                            <div class="detail-value text-muted">Por calcular</div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">
                    Cerrar
                </button>

                <a href="#" id="editAppointmentButton" class="agenda-button">
                    <i class="bi bi-pencil-square"></i>
                    Editar reserva
                </a>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/locales/es.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarElement = document.getElementById('calendar');
    const statusFilter = document.getElementById('filterStatus');
    const staffFilter = document.getElementById('filterStaff');
    const resetButton = document.getElementById('resetFilters');

    const modalElement = document.getElementById('appointmentModal');
    const appointmentModal = new bootstrap.Modal(modalElement);

    const quickStatus = document.getElementById('quickStatus');
    const saveQuickStatus = document.getElementById('saveQuickStatus');
    const statusFeedback = document.getElementById('statusFeedback');

    let selectedAppointment = null;

    const editBaseUrl = <?php echo json_encode(route(
        'appointments.edit', ['appointment' => '__ID__']
    ), 512) ?>;

    const updateStatusBaseUrl = <?php echo json_encode(route(
        'appointments.updateStatus', ['appointment' => '__ID__']
    ), 512) ?>;

    const statusColors = {
        pending: '#D5B69C',
        confirmed: '#8FAF9A',
        completed: '#9AA8C7',
        cancelled: '#D99A9A',
        no_show: '#B69AB8'
    };

    const statusLabels = {
        pending: 'Pendiente',
        confirmed: 'Confirmada',
        completed: 'Completada',
        cancelled: 'Cancelada',
        no_show: 'No asistió'
    };

    function setText(id, value) {
        document.getElementById(id).textContent =
            value || 'No especificado';
    }

    function formatMoney(value) {
        return value === null || value === undefined
            ? 'Por definir'
            : 'Q' + Number(value).toLocaleString('es-GT', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    }

    // Mostrar los detalles de una cita.
    function showAppointment(event) {

        const data = event.extendedProps;
        selectedAppointment = event;

        setText('detailClient', data.client);
        setText('detailPhone', data.phone || 'Sin teléfono registrado');
        setText('detailDate', data.date);

        setText(
            'detailTime',
            data.start_time + (data.end_time ? ' – ' + data.end_time : '')
        );

        setText('detailLocation', data.location);
        setText('detailAddress', data.address);
        setText('detailNotes', data.notes);

        const status = document.getElementById('detailStatus');

        status.textContent = data.status_label || 'Sin estado';
        status.className = 'detail-status ' + data.status;

        quickStatus.value = data.status;
        statusFeedback.textContent = '';
        saveQuickStatus.disabled = false;

        const servicesContainer = document.getElementById('detailServices');
        servicesContainer.replaceChildren();

        (data.services || []).forEach(function (service) {

            const row = document.createElement('div');
            row.className = 'detail-service';

            const info = document.createElement('div');

            const name = document.createElement('div');
            name.className = 'detail-service-name';
            name.textContent = service.name;

            const meta = document.createElement('div');
            meta.className = 'detail-service-meta';

            meta.textContent = service.category + ' · ' + service.staff
                + (service.duration ? ' · ' + service.duration + ' min' : '');

            info.append(name, meta);

            const price = document.createElement('div');
            price.className = 'detail-service-price';
            price.textContent = formatMoney(service.price);

            row.append(info, price);
            servicesContainer.appendChild(row);
        });

        if (!data.services || data.services.length === 0) {
            setText('detailServices', 'No hay servicios registrados.');
        }

        setText('detailTotal', formatMoney(data.total));

        setText(
            'detailTotalNote',
            data.has_unpriced_services
                ? 'Hay servicios pendientes de cotización.'
                : 'Importe registrado de los servicios.'
        );

        document.getElementById('editAppointmentButton').href =
            editBaseUrl.replace('__ID__', event.id);

        appointmentModal.show();
    }

    // Crear calendario.
    const calendar = new FullCalendar.Calendar(calendarElement, {

        locale: 'es',
        initialView: 'dayGridMonth',
        height: 'auto',
        firstDay: 1,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },

        allDaySlot: false,
        slotMinTime: '07:00:00',
        slotMaxTime: '22:00:00',
        slotDuration: '00:30:00',
        nowIndicator: true,
        dayMaxEvents: true,

        events: {
            url: '<?php echo e(route('appointments.events')); ?>',
            method: 'GET',

            extraParams: function () {
                return {
                    status: statusFilter.value,
                    staff_id: staffFilter.value
                };
            },

            failure: function () {
                alert('No fue posible cargar las citas del calendario.');
            }
        },

        eventClick: function (info) {
            info.jsEvent.preventDefault();
            showAppointment(info.event);
        },

        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        }

    });

    calendar.render();

    // Actualizar filtros.
    statusFilter.addEventListener('change', function () {
        calendar.refetchEvents();
    });

    staffFilter.addEventListener('change', function () {
        calendar.refetchEvents();
    });

    resetButton.addEventListener('click', function () {
        statusFilter.value = '';
        staffFilter.value = '';
        calendar.refetchEvents();
    });

    // Guardar cambio rápido de estado.
    saveQuickStatus.addEventListener('click', async function () {

        if (!selectedAppointment) {
            return;
        }

        const appointmentId = selectedAppointment.id;
        const newStatus = quickStatus.value;
        const previousStatus = selectedAppointment.extendedProps.status;

        if (newStatus === previousStatus) {
            statusFeedback.textContent = 'La cita ya tiene ese estado.';
            statusFeedback.className = 'd-block mt-2 text-muted';
            return;
        }

        saveQuickStatus.disabled = true;

        statusFeedback.textContent = 'Guardando cambios...';
        statusFeedback.className = 'd-block mt-2 text-muted';

        try {

            const response = await fetch(
                updateStatusBaseUrl.replace('__ID__', appointmentId),
                {
                    method: 'PATCH',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': <?php echo json_encode(csrf_token(), 15, 512) ?>
                    },

                    body: JSON.stringify({
                        status: newStatus
                    })
                }
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'No fue posible actualizar el estado.'
                );
            }

            // Actualizar la información del evento.
            selectedAppointment.setProp(
                'backgroundColor',
                statusColors[newStatus]
            );

            selectedAppointment.setProp(
                'borderColor',
                statusColors[newStatus]
            );

            selectedAppointment.setExtendedProp('status', newStatus);
            selectedAppointment.setExtendedProp(
                'status_label',
                statusLabels[newStatus]
            );

            // Actualizar la etiqueta de la ventana.
            const badge = document.getElementById('detailStatus');

            badge.textContent = statusLabels[newStatus];
            badge.className = 'detail-status ' + newStatus;

            statusFeedback.textContent = result.message;
            statusFeedback.className = 'd-block mt-2 text-success';

            // Refrescar el calendario respetando los filtros.
            calendar.refetchEvents();

        } catch (error) {

            statusFeedback.textContent = error.message;
            statusFeedback.className = 'd-block mt-2 text-danger';

            quickStatus.value = previousStatus;

        } finally {

            saveQuickStatus.disabled = false;

        }

    });

});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\meraki-signature\resources\views/appointments/index.blade.php ENDPATH**/ ?>