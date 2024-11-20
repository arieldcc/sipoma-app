<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $users = User::all();

        return view('User.index', compact('users'));
    }

    public function create() {
        return view('User.create');
    }

    public function store(Request $request) {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' checks for 'password_confirmation'
            'level' => 'required|in:Admin,User',
        ]);

        // Create a new user and hash the password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);

        // Redirect with a success message
        return redirect('/user-manajemen')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('User.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'level' => 'required|in:Admin,User',
        ]);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;

        // Update password if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/user-manajemen')->with('success', 'User berhasil diperbarui');
    }

    public function delete($id) {
        $user = User::findOrFail($id);

        // Check if the user is an Admin and if they are the last Admin
        if ($user->level === 'admin' && User::where('level', 'admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus data. Setidaknya harus ada satu pengguna dengan hak akses Admin.');
        }

        $user->delete();

        return redirect('/user-manajemen')->with('success', 'User berhasil dihapus');
    }
}
