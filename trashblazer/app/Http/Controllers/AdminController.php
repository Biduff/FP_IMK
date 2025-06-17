<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\TipsnTricks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_logged_in' => true, 'admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id']);
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $tipsntricks = TipsnTricks::all();
        return view('admin.admin', compact('tipsntricks'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alat_dan_bahan' => 'required|string',
            'langkah_langkah' => 'required|string',
        ]);

        $imagePath = $request->file('gambar')->store('tipsntricks', 'public');

        TipsnTricks::create([
            'judul' => $request->judul,
            'gambar' => $imagePath,
            'alat_dan_bahan' => $request->alat_dan_bahan,
            'langkah_langkah' => $request->langkah_langkah,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Tips & Tricks created successfully!');
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alat_dan_bahan' => 'required|string',
            'langkah_langkah' => 'required|string',
        ]);

        $tipsnTricks = TipsnTricks::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'alat_dan_bahan' => $request->alat_dan_bahan,
            'langkah_langkah' => $request->langkah_langkah,
        ];

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($tipsnTricks->gambar) {
                Storage::disk('public')->delete($tipsnTricks->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tipsntricks', 'public');
        }

        $tipsnTricks->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Tips & Tricks updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $tipsnTricks = TipsnTricks::findOrFail($id);

        // Delete image file
        if ($tipsnTricks->gambar) {
            Storage::disk('public')->delete($tipsnTricks->gambar);
        }

        $tipsnTricks->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Tips & Tricks deleted successfully!');
    }
}