<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'      => ['nullable', 'string', 'max:20'],
            'nim_nip'    => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'gender'     => ['nullable', 'in:L,P'],
            'birth_date' => ['nullable', 'date'],
            'address'    => ['nullable', 'string', 'max:500'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.')
            ->with('open_modal', 'edit');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attr, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Password saat ini tidak sesuai.');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah.');
    }
}