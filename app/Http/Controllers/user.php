<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class user extends Controller
{
    // Show profile
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

    // Update profile
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only('name', 'phone', 'address'));
        return redirect()->back()->with('success', 'Profile updated');
    }
}

}
