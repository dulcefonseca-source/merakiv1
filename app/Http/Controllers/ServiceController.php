<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $services = Service::with('staff')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $categories = Service::whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('services.index', compact(
            'services',
            'categories',
            'search',
            'category'
        ));
    }

    public function create()
    {
        $staff = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('services.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'staff_id' => [
                'nullable',
                'integer',
                Rule::exists('staff', 'id')->where('is_active', true),
            ],
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_type' => [
                'nullable',
                Rule::in(['fixed', 'from', 'variable', 'per_unit']),
            ],
            'price_unit' => 'nullable|string|max:50',
            'duration_minutes' => 'nullable|integer|min:1|max:65535',
            'is_active' => 'required|boolean',
        ]);

        $validated['price_type'] = $validated['price_type'] ?? 'fixed';

        if ($validated['price_type'] !== 'per_unit') {
            $validated['price_unit'] = null;
        }

        $validated['staff_id'] = $this->resolveDefaultStaff(
            $validated['category'] ?? null,
            $validated['staff_id'] ?? null
        );

        Service::create($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Servicio registrado correctamente.');
    }

    public function edit(Service $service)
    {
        $staff = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('services.edit', compact('service', 'staff'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'staff_id' => [
                'nullable',
                'integer',
                Rule::exists('staff', 'id')->where('is_active', true),
            ],
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_type' => [
                'nullable',
                Rule::in(['fixed', 'from', 'variable', 'per_unit']),
            ],
            'price_unit' => 'nullable|string|max:50',
            'duration_minutes' => 'nullable|integer|min:1|max:65535',
            'is_active' => 'required|boolean',
        ]);

        $validated['price_type'] = $validated['price_type'] ?? 'fixed';

        if ($validated['price_type'] !== 'per_unit') {
            $validated['price_unit'] = null;
        }

        $validated['staff_id'] = $this->resolveDefaultStaff(
            $validated['category'] ?? null,
            $validated['staff_id'] ?? null
        );

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    private function resolveDefaultStaff(
        ?string $category,
        ?int $staffId
    ): ?int {
        if ($staffId) {
            return $staffId;
        }

        $defaultName = $category === 'Peinados' ? 'Jessy' : 'Pao';

        return Staff::where('name', $defaultName)
            ->where('is_active', true)
            ->value('id');
    }

    public function destroy(Service $service)
    {
        if ($service->appointmentServices()->exists()) {
            $service->update(['is_active' => false]);

            return redirect()
                ->route('services.index')
                ->with('success', 'El servicio fue desactivado porque tiene citas asociadas.');
        }

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
