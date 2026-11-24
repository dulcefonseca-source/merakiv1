<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\AppointmentPayment;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Fecha y período actual
        $today = today();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = now()->endOfWeek(Carbon::SUNDAY);

        // Citas de hoy
        $appointmentsToday = Appointment::with([
            'client',
            'appointmentServices.service',
            'appointmentServices.staff',
        ])
            ->whereDate('appointment_date', $today)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get();

        // Total de clientas registradas
        $totalClients = Client::count();

        // Total de servicios activos
        $totalServices = Service::where('is_active', true)->count();

        // Citas pendientes de confirmación
        $pendingAppointments = Appointment::where('status', 'pending')
            ->whereDate('appointment_date', '>=', $today)
            ->count();

        // Citas completadas durante el mes
        $completedAppointmentsMonth = Appointment::where('status', 'completed')
            ->whereBetween('appointment_date', [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString(),
            ])
            ->count();

        // Nuevas clientas durante el mes
        $newClientsMonth = Client::whereBetween('created_at', [
            $startOfMonth,
            $endOfMonth,
        ])->count();

        // Servicios realizados durante el mes
        $servicesCompletedMonth = Appointment::where('status', 'completed')
            ->whereBetween('appointment_date', [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString(),
            ])
            ->withCount('appointmentServices')
            ->get()
            ->sum('appointment_services_count');

        // Próximas citas
        $upcomingAppointments = Appointment::with([
            'client',
            'appointmentServices.staff',
        ])
            ->whereDate('appointment_date', '>', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Ingresos reales: se contabilizan según la fecha en que se recibió cada pago.
        $incomeToday = AppointmentPayment::whereDate('payment_date', $today)->sum('amount');

        $incomeWeek = AppointmentPayment::whereBetween('payment_date', [
            $startOfWeek,
            $endOfWeek,
        ])->sum('amount');

        $incomeMonth = AppointmentPayment::whereBetween('payment_date', [
            $startOfMonth,
            $endOfMonth,
        ])->sum('amount');

        // Saldo pendiente de citas no canceladas.
        $appointmentsWithBalances = Appointment::where('status', '!=', 'cancelled')
            ->withSum('appointmentServices as appointment_total', 'price')
            ->withSum('payments as amount_paid', 'amount')
            ->get();

        $outstandingBalance = $appointmentsWithBalances->sum(function ($appointment) {
            $total = (float) ($appointment->appointment_total ?? 0);
            $paid = (float) ($appointment->amount_paid ?? 0);

            return max(0, $total - $paid);
        });

        // Últimos movimientos de dinero registrados.
        $recentPayments = AppointmentPayment::with('appointment.client')
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Saludo según la hora de Guatemala
        $hour = now()->hour;

        $greeting = match (true) {
            $hour >= 5 && $hour < 12 => 'Buenos días',
            $hour >= 12 && $hour < 19 => 'Buenas tardes',
            default => 'Buenas noches',
        };

        return view('dashboard.index', compact(
            'appointmentsToday',
            'totalClients',
            'totalServices',
            'pendingAppointments',
            'completedAppointmentsMonth',
            'newClientsMonth',
            'servicesCompletedMonth',
            'upcomingAppointments',
            'incomeToday',
            'incomeWeek',
            'incomeMonth',
            'outstandingBalance',
            'recentPayments',
            'greeting'
        ));
    }
}
