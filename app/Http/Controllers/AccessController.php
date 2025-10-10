<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Module;

class AccessController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return view('pages.admin.access.index', compact('modules'));
    }

    public function create()
    {
        return view('pages.admin.access.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:modules,slug',
            'route_name' => 'required|string|max:255',
        ]);

        Module::create($request->only(['name', 'slug', 'route_name']));

        return redirect()->route('modules.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function edit(Module $module)
    {
        return view('pages.admin.access.update', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:modules,slug,' . $module->id,
        ]);

        $module->update($request->only(['name', 'slug']));

        return redirect()->route('modules.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')->with('success', 'Modul berhasil dihapus.');
    }

    public function userAccess()
    {
        $users = User::with('modules')->get();
        $modules = Module::all();

        return view('pages.admin.access.user-access', compact('users', 'modules'));
    }

    public function updateUserAccess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'modules' => 'array'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->modules()->sync($request->modules ?? []);

        return redirect()->route('access.user')->with('success', 'Hak akses user berhasil diperbarui.');
    }
}
