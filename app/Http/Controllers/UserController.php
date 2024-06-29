<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $title = "Create New User";
        return view('users.form', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new User($validated);
        $user->password = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('user_photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $edit = User::findOrFail($id);
        $title = "Edit User";
        return view('users.form', compact('edit', 'title'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->fill($validated);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('user_photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}