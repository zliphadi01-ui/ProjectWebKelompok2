<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users, ordered by newest first
        $users = User::orderBy('created_at', 'desc')->get();
        return view('master.pegawai', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'role' => 'required|string|in:admin,dokter,perawat,pendaftaran,apotek,kasir,pasien',
            'nip' => 'nullable|string|max:50', // Optional NIP
            'profesi' => 'nullable|string|max:100', // Optional Profesi
            'unit' => 'nullable|string|max:100', // Optional Unit
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            // Add other fields if your User model supports them, otherwise they are ignored or need migration
            // Assuming User model might not have nip/profesi/unit yet, but we can add them if needed.
            // For now, we'll stick to basic User fields + role.
        ]);

        return redirect()->route('master-data.pegawai')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,dokter,perawat,pendaftaran,apotek,kasir,pasien',
            'password' => 'nullable|string|min:5', // Password optional on update
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('master-data.pegawai')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting self
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('master-data.pegawai')->with('success', 'Pegawai berhasil dihapus.');
    }
}
