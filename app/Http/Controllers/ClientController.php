<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Mostrar listado de clientes.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $clients = Client::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->withCount('appointments')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('clients.index', compact('clients', 'search'));
    }

    /**
     * Mostrar ficha individual de una clienta.
     */
    public function show(Client $client)
    {
        $client->load([
            'appointments.appointmentServices.staff',
            'appointments.appointmentServices.service',
        ]);

        $appointments = $client->appointments()
            ->with([
                'appointmentServices.staff',
                'appointmentServices.service',
            ])
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->get();

        $totalAppointments = $appointments->count();

        $completedAppointments = $appointments
            ->where('status', 'completed')
            ->count();

        $pendingAppointments = $appointments
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $cancelledAppointments = $appointments
            ->where('status', 'cancelled')
            ->count();

        return view('clients.show', compact(
            'client',
            'appointments',
            'totalAppointments',
            'completedAppointments',
            'pendingAppointments',
            'cancelledAppointments'
        ));
    }

    /**
     * Mostrar formulario de registro.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Guardar nuevo cliente.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Actualizar cliente.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Información del cliente actualizada.');
    }

    /**
     * Eliminar cliente.
     */
    public function destroy(Client $client)
    {
        if ($client->appointments()->exists()) {
            return redirect()
                ->route('clients.index')
                ->with('error', 'No se puede eliminar este cliente porque tiene citas registradas.');
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
