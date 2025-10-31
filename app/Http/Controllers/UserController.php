<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // List semua user
    public function index()
    {
        $users = User::all();
        return view('pages.admin.user.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $roles = User::ROLES;
        $departemens = User::DEPARTEMEN;
        return view('pages.admin.user.add', compact('roles','departemens'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nik'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:' . implode(',', User::ROLES),
            'departemen'     => 'required|in:' . implode(',', User::DEPARTEMEN),
        ]);

        User::create([
            'name'     => $request->name,
            'nik'     => $request->nik,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
            'departemen'     => $request->departemen,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // Form edit user
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = User::ROLES;
        $departemens = User::DEPARTEMEN;
        return view('pages.admin.user.update', compact('user', 'roles', 'departemens'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'nik'     => 'required|string|max:255',
            'email'      => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:' . implode(',', User::ROLES),
            'departemen'     => 'required|in:' . implode(',', User::DEPARTEMEN),
        ]);

        $user->name  = $request->name;
        $user->nik  = $request->nik;
        $user->departemen  = $request->departemen;
        $user->email = $request->email;
        $user->role  = $request->role;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
