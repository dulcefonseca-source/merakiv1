<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Mostrar calendario de citas.
     */
    public function index()
    {
        $staff = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('appointments.index', compact('staff'));
    }

    /**
     * Obtener las citas para FullCalendar con filtros y detalles.
     */
    public function events(Request $request)
    {
        $validated = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after:start'],
            'status' => [
                'nullable',
                'in:pending,confirmed,completed,cancelled,no_show',
            ],
            'staff_id' => [
                'nullable',
                'integer',
                'exists:staff,id',
            ],
        ]);

        $startDate = Carbon::parse($validated['start'])->toDateString();
        $endDate = Carbon::parse($validated['end'])->toDateString();

        $query = Appointment::with([
            'client',
            'appointmentServices.staff',
        ])
            ->whereDate('appointment_date', '>=', $startDate)
            ->whereDate('appointment_date', '<', $endDate);

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['staff_id'])) {
            $query->whereHas('appointmentServices', function ($serviceQuery) use ($validated) {
                $serviceQuery->where('staff_id', $validated['staff_id']);
            });
        }

        $appointments = $query
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        $statusColors = [
            'pending' => '#D5B69C',
            'confirmed' => '#8FAF9A',
            'completed' => '#9AA8C7',
            'cancelled' => '#D99A9A',
            'no_show' => '#B69AB8',
        ];

        $statusLabels = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmada',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            'no_show' => 'No asistió',
        ];

        $events = $appointments->map(function ($appointment) use (
            $statusColors,
            $statusLabels
        ) {
            $services = $appointment->appointmentServices->map(function ($item) {
                return [
                    'name' => $item->service_name ?? 'Por definir',
                    'category' => $item->category ?? 'Sin categoría',
                    'price' => $item->price !== null
                        ? (float) $item->price
                        : null,
                    'duration' => $item->duration_minutes,
                    'staff' => $item->staff?->name ?? 'Sin asignar',
                ];
            })->values();

            $serviceNames = $services
                ->pluck('name')
                ->filter()
                ->unique()
                ->implode(', ');

            $total = $services->sum(function ($service) {
                return $service['price'] ?? 0;
            });

            $hasUnpricedServices = $services->contains(function ($service) {
                return $service['price'] === null;
            });

            $color = $statusColors[$appointment->status] ?? '#BD8980';

            return [
                'id' => $appointment->id,

                'title' => $appointment->client->name
                    . ($serviceNames ? ' · ' . $serviceNames : ''),

                'start' => Carbon::parse(
                    $appointment->appointment_date->format('Y-m-d')
                    . ' ' . $appointment->start_time
                )->toIso8601String(),

                'end' => $appointment->end_time
                    ? Carbon::parse(
                        $appointment->appointment_date->format('Y-m-d')
                        . ' ' . $appointment->end_time
                    )->toIso8601String()
                    : null,

                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#FFFFFF',

                'extendedProps' => [
                    'client' => $appointment->client->name,
                    'phone' => $appointment->client->phone,
                    'date' => $appointment->appointment_date->format('d/m/Y'),
                    'start_time' => Carbon::parse($appointment->start_time)->format('h:i A'),
                    'end_time' => $appointment->end_time
                        ? Carbon::parse($appointment->end_time)->format('h:i A')
                        : null,
                    'location' => $appointment->location,
                    'address' => $appointment->address,
                    'notes' => $appointment->notes,
                    'status' => $appointment->status,
                    'status_label' => $statusLabels[$appointment->status]
                        ?? $appointment->status,
                    'services' => $services,
                    'total' => $total,
                    'has_unpriced_services' => $hasUnpricedServices,
                ],
            ];
        });

        return response()->json($events);
    }

    /**
     * Mostrar formulario de nueva cita.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        $services = Service::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $staff = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        $servicesForJs = $services->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'category' => $service->category,
                'price' => $service->price,
                'price_type' => $service->price_type,
                'price_unit' => $service->price_unit,
                'duration' => $service->duration_minutes,
                'staff_id' => $service->staff_id,
            ];
        })->values();

        return view('appointments.create', compact(
            'clients',
            'services',
            'staff',
            'servicesForJs'
        ));
    }

    /**
     * Guardar una nueva cita.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'appointment_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => [
                'required',
                'in:pending,confirmed,completed,cancelled,no_show',
            ],

            'services' => ['required', 'array', 'min:1'],
            'services.*.category' => [
                'required',
                'in:Uñas,Maquillaje,Peinados,Pestañas,Adicionales,Otros',
            ],
            'services.*.service_id' => [
                'nullable',
                'exists:services,id',
            ],
            'services.*.price' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'services.*.duration_minutes' => [
                'nullable',
                'integer',
                'min:1',
                'max:65535',
            ],
            'services.*.staff_id' => [
                'nullable',
                'exists:staff,id',
            ],
        ]);

        // Comprobar disponibilidad de Pao antes de guardar.
        $this->checkPaoAvailability($validated);

        DB::transaction(function () use ($validated) {

            $appointment = Appointment::create([
                'client_id' => $validated['client_id'],
                'appointment_date' => $validated['appointment_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'] ?? null,
                'location' => $validated['location'] ?? null,
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['status'],
            ]);

            foreach ($validated['services'] as $item) {

                $service = !empty($item['service_id'])
                    ? Service::findOrFail($item['service_id'])
                    : null;

                $price = isset($item['price']) && $item['price'] !== ''
                    ? $item['price']
                    : $service?->price;

                $duration = isset($item['duration_minutes'])
                    && $item['duration_minutes'] !== ''
                    ? $item['duration_minutes']
                    : $service?->duration_minutes;

                $staffId = !empty($item['staff_id'])
                    ? $item['staff_id']
                    : $service?->staff_id;

                $serviceStart = $validated['start_time'];
                $serviceEnd = null;

                if ($duration) {
                    $serviceEnd = Carbon::parse(
                        $validated['appointment_date'] . ' ' . $serviceStart
                    )
                        ->addMinutes((int) $duration)
                        ->format('H:i:s');
                }

                $appointment->appointmentServices()->create([
                    'service_id' => $service?->id,
                    'staff_id' => $staffId,
                    'category' => $item['category'],
                    'service_name' => $service?->name ?? 'Por definir',
                    'price' => $price,
                    'duration_minutes' => $duration,
                    'start_time' => $serviceStart,
                    'end_time' => $serviceEnd,
                ]);
            }
        });

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita se registró correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Appointment $appointment)
    {
        $appointment->load([
            'client',
            'appointmentServices.service',
            'appointmentServices.staff',
        ]);

        $clients = Client::orderBy('name')->get();

        $services = Service::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $staff = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('appointments.edit', compact(
            'appointment',
            'clients',
            'services',
            'staff'
        ));
    }

    /**
     * Actualizar rápidamente el estado de una cita.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,completed,cancelled,no_show',
            ],
        ]);

        $appointment->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'El estado de la cita se actualizó correctamente.',
            'status' => $appointment->status,
        ]);
    }

    /**
     * Actualizar una cita existente.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'appointment_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => [
                'required',
                'in:pending,confirmed,completed,cancelled,no_show',
            ],

            'services' => ['required', 'array', 'min:1'],
            'services.*.id' => ['nullable', 'integer'],
            'services.*.category' => [
                'required',
                'in:Uñas,Maquillaje,Peinados,Pestañas,Adicionales,Otros',
            ],
            'services.*.service_id' => [
                'nullable',
                'exists:services,id',
            ],
            'services.*.price' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'services.*.duration_minutes' => [
                'nullable',
                'integer',
                'min:1',
                'max:65535',
            ],
            'services.*.staff_id' => [
                'nullable',
                'exists:staff,id',
            ],
        ]);

        // Excluir la cita actual de la comprobación de conflictos.
        $this->checkPaoAvailability($validated, $appointment->id);

        DB::transaction(function () use ($validated, $appointment) {

            $appointment->update([
                'client_id' => $validated['client_id'],
                'appointment_date' => $validated['appointment_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'] ?? null,
                'location' => $validated['location'] ?? null,
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['status'],
            ]);

            $existingServices = $appointment->appointmentServices()
                ->get()
                ->keyBy('id');

            $keptIds = [];

            foreach ($validated['services'] as $item) {

                $service = !empty($item['service_id'])
                    ? Service::findOrFail($item['service_id'])
                    : null;

                $price = isset($item['price']) && $item['price'] !== ''
                    ? $item['price']
                    : $service?->price;

                $duration = isset($item['duration_minutes'])
                    && $item['duration_minutes'] !== ''
                    ? $item['duration_minutes']
                    : $service?->duration_minutes;

                $staffId = !empty($item['staff_id'])
                    ? $item['staff_id']
                    : $service?->staff_id;

                $serviceStart = $validated['start_time'];
                $serviceEnd = null;

                if ($duration) {
                    $serviceEnd = Carbon::parse(
                        $validated['appointment_date'] . ' ' . $serviceStart
                    )
                        ->addMinutes((int) $duration)
                        ->format('H:i:s');
                }

                $data = [
                    'service_id' => $service?->id,
                    'staff_id' => $staffId,
                    'category' => $item['category'],
                    'service_name' => $service?->name ?? 'Por definir',
                    'price' => $price,
                    'duration_minutes' => $duration,
                    'start_time' => $serviceStart,
                    'end_time' => $serviceEnd,
                ];

                $serviceId = $item['id'] ?? null;

                if ($serviceId) {

                    $appointmentService = $existingServices->get($serviceId);

                    if (!$appointmentService) {
                        abort(422, 'El servicio indicado no pertenece a esta cita.');
                    }

                    $appointmentService->update($data);

                    $keptIds[] = $appointmentService->id;

                } else {

                    $newService = $appointment->appointmentServices()
                        ->create($data);

                    $keptIds[] = $newService->id;
                }
            }

            $appointment->appointmentServices()
                ->whereNotIn('id', $keptIds)
                ->delete();
        });

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita se actualizó correctamente.');
    }

    /**
     * Comprobar que Pao no tenga servicios en horarios superpuestos.
     * Jessy queda excluida porque trabaja de manera independiente.
     */
    private function checkPaoAvailability(
        array $validated,
        ?int $ignoreAppointmentId = null
    ): void {
        $pao = Staff::where('name', 'Pao')->first();

        if (!$pao) {
            return;
        }

        $requestedIntervals = [];

        foreach ($validated['services'] as $item) {

            $service = !empty($item['service_id'])
                ? Service::find($item['service_id'])
                : null;

            $staffId = !empty($item['staff_id'])
                ? (int) $item['staff_id']
                : (int) ($service?->staff_id ?? 0);

            // Solo verificamos los servicios asignados a Pao.
            if ($staffId !== (int) $pao->id) {
                continue;
            }

            $duration = isset($item['duration_minutes'])
                && $item['duration_minutes'] !== ''
                ? (int) $item['duration_minutes']
                : $service?->duration_minutes;

            $start = Carbon::parse(
                $validated['appointment_date'] . ' ' . $validated['start_time']
            );

            if ($duration) {
                $end = $start->copy()->addMinutes((int) $duration);
            } elseif (!empty($validated['end_time'])) {
                $end = Carbon::parse(
                    $validated['appointment_date'] . ' ' . $validated['end_time']
                );
            } else {
                throw ValidationException::withMessages([
                    'services' => 'Debes indicar la duración del servicio asignado a Pao para comprobar su disponibilidad.',
                ]);
            }

            if ($end->lessThanOrEqualTo($start)) {
                throw ValidationException::withMessages([
                    'services' => 'El horario de finalización debe ser posterior al de inicio.',
                ]);
            }

            // Evitar que dos servicios de Pao se crucen
            // dentro de la misma reserva que se está registrando.
            foreach ($requestedIntervals as $interval) {
                if (
                    $start->lt($interval['end'])
                    && $end->gt($interval['start'])
                ) {
                    throw ValidationException::withMessages([
                        'services' => 'Pao tiene dos servicios asignados en horarios que se cruzan dentro de esta misma cita.',
                    ]);
                }
            }

            $requestedIntervals[] = [
                'start' => $start,
                'end' => $end,
            ];

            // Buscar otras citas pendientes o confirmadas de Pao.
            $conflict = DB::table('appointment_services')
                ->join(
                    'appointments',
                    'appointments.id',
                    '=',
                    'appointment_services.appointment_id'
                )
                ->whereDate(
                    'appointments.appointment_date',
                    $validated['appointment_date']
                )
                ->whereIn('appointments.status', ['pending', 'confirmed'])
                ->where('appointment_services.staff_id', $pao->id)
                ->whereRaw(
                    'appointment_services.start_time < ?',
                    [$end->format('H:i:s')]
                )
                ->whereRaw(
                    'COALESCE(appointment_services.end_time, appointments.end_time) > ?',
                    [$start->format('H:i:s')]
                )
                ->when($ignoreAppointmentId, function ($query) use ($ignoreAppointmentId) {
                    $query->where(
                        'appointments.id',
                        '!=',
                        $ignoreAppointmentId
                    );
                })
                ->select('appointments.id')
                ->first();

            if ($conflict) {
                throw ValidationException::withMessages([
                    'services' => 'Pao ya tiene una cita reservada en ese horario. Revisa la agenda antes de guardar.',
                ]);
            }
        }
    }

    /**
     * Eliminar una cita.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita se eliminó correctamente.');
    }
}
