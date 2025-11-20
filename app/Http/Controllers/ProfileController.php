<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        // require login (simple session check)
        if (!session('user')) {
            return redirect('/login');
        }

        $user = null;
        if (session('user_id')) {
            $user = User::find(session('user_id'));
        }

        return view('auth.profile', compact('user'));
    }

    public function uploadPhoto(Request $request)
    {
        if (!session('user')) {
            return redirect('/login');
        }

        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        $file = $request->file('photo');
        $filename = time() . '_' . preg_replace('/[^a-z0-9_.-]/i', '', $file->getClientOriginalName());
        $dest = public_path('uploads/profile');
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
        $file->move($dest, $filename);

        $url = '/uploads/profile/' . $filename;

        // if logged in user exists in DB, save path to profile_photo column if present
        if (session('user_id')) {
            $user = User::find(session('user_id'));
            if ($user) {
                if (in_array('profile_photo', $user->getFillable())) {
                    $user->profile_photo = $url;
                    $user->save();
                }
            }
        }

        // store in session for immediate use
        session(['user_photo' => $url]);

        return back()->with('success', 'Foto profil berhasil diunggah');
    }
}
