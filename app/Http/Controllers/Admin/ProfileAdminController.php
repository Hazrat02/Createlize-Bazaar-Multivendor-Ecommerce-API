<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ProfileAdminController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('Admin/Profile/Edit', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $data = $request->validate([
            'name' => ['required','string','max:150'],
            'email' => ['required','email','max:190','unique:users,email,'.$user->id],
            'profile_image' => ['nullable','image','max:4096'],
        ]);

        $profileImagePath = $user->profile_image;
        if (!empty($data['profile_image'])) {
            if ($profileImagePath) {
                Storage::disk('public')->delete($profileImagePath);
            }
            $profileImagePath = $data['profile_image']->store('users', 'public');
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'profile_image' => $profileImagePath,
        ]);

        return back()->with('success', 'Profile updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $data = $request->validate([
            'current_password' => ['required','string'],
            'password' => ['required','string','min:6','confirmed'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => bcrypt($data['password']),
        ]);

        return back()->with('success', 'Password updated');
    }
}
