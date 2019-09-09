<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::orderBy('created_at', 'DESC')->paginate(10);
        return view('Role.index', compact('role'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:50',
        ]);

        $role = Role::firstOrCreate(['name' => $request->name]);
        return redirect()->back()->with(['success' => 'Role: <strong>' . $role->name . '</strong> Added']);
    }

    public function destroy()
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with(['success' => 'Role: <strong>' . $role->name . '</strong> Deleted']);
    }
}
