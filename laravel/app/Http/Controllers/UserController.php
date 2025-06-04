<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserProfile(Request $request)
    {
        try {
            $user = $request->user();  // Ambil user dari token

            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            return response()->json([
                'fullname' => $user->fullname,
                'username' => $user->username,
                'name' => $user->fullname,
                'phone' => $user->phone_number,
                'email' => $user->email,
                'image' => $user->image_path ? asset('storage/' . $user->image_path) : null
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request)
    {
        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validasi dengan memperbolehkan username yang sama kalau user-nya sama
        $validated = $request->validate([
            'email' => 'required|email',
            'fullname' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:25600',
        ]);

        // Update field
        $user->fullname = $validated['fullname'];
        $user->username = $validated['username'];
        $user->phone_number = $validated['phone_number'] ?? $user->phone_number;

        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        // Update gambar jika ada file image yang dikirim
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image_path) {
                Storage::disk('public')->delete($user->image_path);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('users', 'public');
            $user->image_path = $imagePath;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'image_url' => $user->image_path ? asset('storage/' . $user->image_path) : null
        ]);
    }
}
