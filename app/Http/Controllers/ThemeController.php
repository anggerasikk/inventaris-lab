<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ThemeController extends Controller
{
    /**
     * Toggle dark mode preference
     */
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        // Update user's theme preference
        /** @var User $user */
        $user = Auth::user();
        if ($user instanceof User) {
            $user->theme_preference = $validated['theme'];
            $user->save();
        }

        return response()->json([
            'success' => true,
            'theme' => $validated['theme']
        ]);
    }

    /**
     * Get current user's theme preference
     */
    public function getPreference(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['theme' => 'light']);
        }

        return response()->json([
            'theme' => Auth::user()->theme_preference ?? 'light'
        ]);
    }
}
