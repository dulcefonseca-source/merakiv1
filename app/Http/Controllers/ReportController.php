<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentPayment;
use App\Models\Client;
use App\Models\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Página principal de reportes.
     */
    public function index(): View
{
    return view('reports.index');
}
    /**
     * REPORTE DE INGRESOS
     */
    public function income(Request $request): View
    {
        [$startDate, $endDate] = $this->getDateRange($request);

        $paymentsQuery = AppointmentPayment::with([
            'appointment.client',
        ])->whereBetween('payment_date', [
            $startDate->copy()->startOfDay(),
            $endDate->copy()->endOfDay(),
        ]);

        $totalIncome = (clone $paymentsQuery)->sum('amount');

        $totalPayments = (clone $paymentsQuery)->count();

        $paymentsByMethod = (clone $paymentsQuery)
            ->selectRaw('payment_method, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        $payments = (clone $paymentsQuery)
            ->orderByDesc('payment_date')
            ->paginate(15)
            ->withQueryString();

        // Saldos pendientes de citas cuya fecha está dentro del período.
        // Se excluyen las citas canceladas.
        $pendingBalance = Appointment::with([
            'appointmentServices',
            'payments',
        ])
            ->whereNotIn('status', ['cancelled'])
            ->whereBetween('appointment_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->get()
            ->sum(function ($appointment) {
                $total = $appointment->appointmentServices->sum('price');
                $paid = $appointment->payments->sum('amount');

                return max(0, (float) $total - (float) $paid);
            });

        return view('reports.income', compact(
            'startDate',
            'endDate',
            'totalIncome',
            'totalPayments',
            'paymentsByMethod',
            'payments',
            'pendingBalance'
        ));
    }

    /**
     * REPORTE DE CITAS
     */
    public function appointments(Request $request): View
    {
        [$startDate, $endDate] = $this->getDateRange($request);

        $appointmentsQuery = Appointment::with([
            'client',
            'appointmentServices',
            'payments',
        ])->whereBetween('appointment_date', [
            $startDate->toDateString(),
            $endDate->toDateString(),
        ]);

        $appointments = (clone $appointmentsQuery)
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->paginate(15)
            ->withQueryString();

        $appointmentsByStatus = (clone $appointmentsQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $totalAppointments = (clone $appointmentsQuery)->count();

        $completedAppointments = (clone $appointmentsQuery)
            ->where('status', 'completed')
            ->count();

        $cancelledAppointments = (clone $appointmentsQuery)
            ->where('status', 'cancelled')
            ->count();

        $pendingAppointments = (clone $appointmentsQuery)
            ->where('status', 'pending')
            ->count();

        $confirmedAppointments = (clone $appointmentsQuery)
            ->where('status', 'confirmed')
            ->count();

        $noShowAppointments = (clone $appointmentsQuery)
            ->where('status', 'no_show')
            ->count();

        return view('reports.appointments', compact(
            'startDate',
            'endDate',
            'appointments',
            'appointmentsByStatus',
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'noShowAppointments'
        ));
    }

    /**
     * REPORTE DE SERVICIOS
     */
    public function services(Request $request): View
    {
        [$startDate, $endDate] = $this->getDateRange($request);

        $servicesQuery = AppointmentService::query()
            ->join(
                'appointments',
                'appointment_services.appointment_id',
                '=',
                'appointments.id'
            )
            ->whereBetween('appointments.appointment_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->where('appointments.status', 'completed');

        $services = (clone $servicesQuery)
            ->selectRaw('
                appointment_services.service_name,
                COUNT(*) as total_sold,
                SUM(appointment_services.price) as total_income
            ')
            ->groupBy('appointment_services.service_name')
            ->orderByDesc('total_sold')
            ->paginate(15)
            ->withQueryString();

        $totalServicesPerformed = (clone $servicesQuery)->count();

        $totalServicesIncome = (clone $servicesQuery)
            ->sum('appointment_services.price');

        return view('reports.services', compact(
            'startDate',
            'endDate',
            'services',
            'totalServicesPerformed',
            'totalServicesIncome'
        ));
    }

    /**
     * REPORTE DE CLIENTAS
     */
    public function clients(Request $request): View
    {
        [$startDate, $endDate] = $this->getDateRange($request);

        $newClients = Client::whereBetween('created_at', [
            $startDate->copy()->startOfDay(),
            $endDate->copy()->endOfDay(),
        ])->count();

        $totalClients = Client::count();

        $activeClients = Client::whereHas('appointments', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('appointment_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ]);
        })->count();

        $clients = Client::withCount([
            'appointments' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('appointment_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]);
            },
        ])
            ->orderByDesc('appointments_count')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('reports.clients', compact(
            'startDate',
            'endDate',
            'newClients',
            'totalClients',
            'activeClients',
            'clients'
        ));
    }

    /**
     * Obtener y validar el período seleccionado.
     */
    private function getDateRange(Request $request): array
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = isset($validated['start_date'])
            ? Carbon::parse($validated['start_date'])
            : now()->startOfMonth();

        $endDate = isset($validated['end_date'])
            ? Carbon::parse($validated['end_date'])
            : now();

        return [$startDate, $endDate];
    }
}
