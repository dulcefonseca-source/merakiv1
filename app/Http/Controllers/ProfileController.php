<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Actualizar información personal.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Los nombres de usuario se guardan siempre en minúsculas.
        $request->merge([
            'username' => Str::lower(trim((string) $request->input('username'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'username.required' => 'Debes elegir un nombre de usuario.',
            'username.min' => 'El nombre de usuario debe tener al menos 3 caracteres.',
            'username.max' => 'El nombre de usuario no puede superar los 50 caracteres.',
            'username.alpha_dash' => 'Usa únicamente letras, números, guiones o guiones bajos.',
            'username.unique' => 'Ese nombre de usuario ya está en uso.',
        ]);

        $user->update($validated);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Tu información personal se actualizó correctamente.');
    }

    /**
     * Actualizar contraseña de la cuenta.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers(),
                'confirmed',
            ],
        ], [
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'new_password.confirmed' => 'La confirmación no coincide con la nueva contraseña.',
        ]);

        $user = Auth::user();

        $user->forceFill([
            'password' => Hash::make($validated['new_password']),
        ])->save();

        return redirect()
            ->route('profile.edit')
            ->with('password_success', 'Tu contraseña se actualizó correctamente.');
    }

    /**
     * Guardar la preferencia visual de la cuenta.
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme_preference' => ['required', 'in:light,dark'],
        ]);

        $user = Auth::user();

        $user->forceFill([
            'theme_preference' => $validated['theme_preference'],
        ])->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'La apariencia de Meraki Signature se actualizó correctamente.');
    }

    /**
     * Subir o cambiar fotografía de perfil.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $request->file('profile_photo')
            ->store('profile-photos', 'public');

        $user->update([
            'profile_photo_path' => $path,
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Tu fotografía de perfil se actualizó correctamente.');
    }

    /**
     * Eliminar fotografía de perfil.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);

            $user->update([
                'profile_photo_path' => null,
            ]);
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Tu fotografía de perfil se eliminó correctamente.');
    }
}
