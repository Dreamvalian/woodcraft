<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UnsubscribeController extends Controller
{
    public function show(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');

        if (!$email) {
            return view('unsubscribe');
        }

        // In a real application, you would validate the token and fetch preferences from the database
        // For this example, we'll use dummy data
        $preferences = [
            'newsletter' => true,
            'promotions' => true,
            'order_updates' => true,
            'product_updates' => true,
        ];

        return view('unsubscribe', compact('email', 'token', 'preferences'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'preferences' => 'required|array',
            'preferences.*' => 'boolean',
        ]);

        // In a real application, you would:
        // 1. Validate the token
        // 2. Update the user's preferences in the database
        // 3. Send a confirmation email

        return redirect()->route('unsubscribe')
            ->with('success', 'Your email preferences have been updated successfully.');
    }

    public function unsubscribeAll(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
        ]);

        // In a real application, you would:
        // 1. Validate the token
        // 2. Update the user's preferences to unsubscribe from all emails
        // 3. Send a confirmation email

        return redirect()->route('unsubscribe')
            ->with('success', 'You have been unsubscribed from all emails.');
    }
} 