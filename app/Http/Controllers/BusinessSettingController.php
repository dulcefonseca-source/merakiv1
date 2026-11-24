<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessSettingController extends Controller
{
    /**
     * Mostrar la configuración del estudio.
     */
    public function edit()
    {
        $settings = BusinessSetting::firstOrCreate(
            [],
            [
                'business_name' => 'Meraki Estudio de Belleza',
                'primary_color' => '#BD8980',
                'secondary_color' => '#654D50',
            ]
        );

        return view('business-settings.edit', compact('settings'));
    }

    /**
     * Guardar los cambios de configuración.
     */
    public function update(Request $request)
    {
        $settings = BusinessSetting::firstOrCreate(
            [],
            [
                'business_name' => 'Meraki Estudio de Belleza',
                'primary_color' => '#BD8980',
                'secondary_color' => '#654D50',
            ]
        );

        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'tagline' => ['nullable', 'string', 'max:255'],

            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:1000'],

            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],

            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],

            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'business_name.required' => 'El nombre del estudio es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'logo.image' => 'El logotipo debe ser una imagen.',
            'logo.mimes' => 'El logotipo debe estar en JPG, PNG o WEBP.',
            'logo.max' => 'El logotipo no debe superar los 2 MB.',
            'cover.image' => 'La portada debe ser una imagen.',
            'cover.mimes' => 'La portada debe estar en JPG, PNG o WEBP.',
            'cover.max' => 'La portada no debe superar los 5 MB.',
        ]);

        $settings->fill([
            'business_name' => $validated['business_name'],
            'tagline' => $validated['tagline'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
        ]);

        // Guardar el logotipo nuevo.
        if ($request->hasFile('logo')) {
            $newLogoPath = $request->file('logo')
                ->store('business-settings', 'public');

            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $settings->logo_path = $newLogoPath;
        }

        // Guardar la portada nueva.
        if ($request->hasFile('cover')) {
            $newCoverPath = $request->file('cover')
                ->store('business-settings', 'public');

            if ($settings->cover_path) {
                Storage::disk('public')->delete($settings->cover_path);
            }

            $settings->cover_path = $newCoverPath;
        }

        $settings->save();

        return redirect()
            ->route('business-settings.edit')
            ->with('success', 'La configuración de Meraki se actualizó correctamente.');
    }
}
