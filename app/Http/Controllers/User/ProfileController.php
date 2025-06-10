<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
  /**
   * Display the user's profile.
   */
  public function show()
  {
    return view('user.profile');
  }

  /**
   * Show the form for editing the user's profile.
   */
  public function edit()
  {
    return view('user.profile-edit');
  }

  /**
   * Update the user's profile information.
   */
  public function update(Request $request)
  {
    $user = auth()->user();

    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'phone' => ['nullable', 'string', 'max:20'],
      'address' => ['nullable', 'string', 'max:255'],
      'current_password' => ['nullable', 'required_with:password', 'current_password'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);

    // Update basic information
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->phone = $validated['phone'];
    $user->address = $validated['address'];

    // Update password if provided
    if (isset($validated['password'])) {
      $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'Profile updated successfully.');
  }
}