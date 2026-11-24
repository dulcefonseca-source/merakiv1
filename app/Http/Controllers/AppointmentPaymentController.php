<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppointmentPaymentController extends Controller
{
    /**
     * Registrar un pago o abono de una cita.
     */
    public function store(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'payment_date' => [
                'required',
                'date',
            ],
            'payment_method' => [
                'required',
                'in:efectivo,transferencia,tarjeta',
            ],
            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use ($validated, $appointment) {

            $lockedAppointment = Appointment::whereKey($appointment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $total = (float) $lockedAppointment
                ->appointmentServices()
                ->sum('price');

            $paid = (float) $lockedAppointment
                ->payments()
                ->sum('amount');

            $remaining = round($total - $paid, 2);

            if ($remaining <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Esta reserva ya está completamente pagada.',
                ]);
            }

            if ((float) $validated['amount'] > $remaining) {
                throw ValidationException::withMessages([
                    'amount' => 'El pago supera el saldo pendiente de la cita.',
                ]);
            }

            $lockedAppointment->payments()->create($validated);
        });

        return back()->with(
            'success',
            'El pago se registró correctamente.'
        );
    }

    /**
     * Eliminar un registro de pago.
     */
    public function destroy(AppointmentPayment $payment)
    {
        DB::transaction(function () use ($payment) {

            $lockedAppointment = Appointment::whereKey(
                $payment->appointment_id
            )->lockForUpdate()->firstOrFail();

            $paymentToDelete = AppointmentPayment::whereKey($payment->id)
                ->where('appointment_id', $lockedAppointment->id)
                ->firstOrFail();

            $paymentToDelete->delete();
        });

        return back()->with(
            'success',
            'El registro de pago fue eliminado correctamente.'
        );
    }

    /**
     * Mostrar el comprobante final de una reserva.
     * Solo está disponible cuando el saldo es cero.
     */
    public function receipt(AppointmentPayment $payment)
    {
        $payment->load([
            'appointment.client',
            'appointment.appointmentServices.staff',
        ]);

        $appointment = $payment->appointment;

        if (!$appointment) {
            throw (new ModelNotFoundException())
                ->setModel(Appointment::class);
        }

        $total = (float) $appointment
            ->appointmentServices
            ->sum('price');

        $paid = (float) $appointment
            ->payments()
            ->sum('amount');

        $balance = max(0, round($total - $paid, 2));

        // Bloquear comprobantes si la reserva no está completamente pagada.
        if ($total <= 0 || $paid + 0.009 < $total) {
            return redirect()
                ->route('appointments.edit', $appointment)
                ->with(
                    'error',
                    'El comprobante final estará disponible cuando la reserva esté completamente pagada.'
                );
        }

        // Mostrar el comprobante únicamente cuando esté pagada.
        return view(
            'appointments.payments.receipt',
            compact(
                'payment',
                'appointment',
                'total',
                'paid',
                'balance'
            )
        );
    }
}
