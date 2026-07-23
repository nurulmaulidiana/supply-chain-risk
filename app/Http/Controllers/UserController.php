<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan semua user
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User berhasil ditambahkan.');
    }

    // Detail user
    public function show(string $id)
    {
        //
    }

    // Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'role'=>'required'
        ]);

        $user = User::findOrFail($id);

        // Proteksi: admin tidak boleh menurunkan role dirinya sendiri
        if ($user->id == Auth::id() && $request->role != 'admin') {
            return redirect()->route('users.index')
                    ->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if($request->password != null){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
                ->with('success','User berhasil diubah');
    }

    // Hapus user
    public function destroy($id)
    {
        // Proteksi: admin tidak boleh menghapus akunnya sendiri
        if ($id == Auth::id()) {
            return redirect()->route('users.index')
                    ->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('users.index')
                ->with('success','User berhasil dihapus');
    }

    // Aktifkan / nonaktifkan user
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: admin tidak boleh menonaktifkan akunnya sendiri
        if ($user->id == Auth::id()) {
            return redirect()->route('users.index')
                    ->with('error', 'Kamu tidak bisa menonaktifkan akunmu sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('users.index')
                ->with('success', 'Status user berhasil diubah.');
    }
}