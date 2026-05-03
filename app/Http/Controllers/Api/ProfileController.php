<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get Profile
    |--------------------------------------------------------------------------
    */

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()->load('role'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone'      => ['nullable', 'string', 'max:20'],
            'nim_nip'    => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('users')->ignore($user->id)
            ],
            'gender'     => ['nullable', 'in:L,P'],
            'birth_date' => ['nullable', 'date'],
            'address'    => ['nullable', 'string', 'max:500'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $validated['photo'] = $request
                ->file('photo')
                ->store('photos', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user->fresh()->load('role'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        $request->validate([

            'current_password' => [
                'required',
                function ($attr, $value, $fail) use ($request) {

                    if (!Hash::check(
                        $value,
                        $request->user()->password
                    )) {

                        $fail('Password saat ini tidak sesuai.');
                    }
                }
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],

        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }
}