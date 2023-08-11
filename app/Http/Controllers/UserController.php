<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Delete a user by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself or an admin
        if ($user->id === auth()->user()->id || $user->isAdmin()) {
            return response()->json(['error' => 'Cannot delete this user'], 403);
        }
        
        $user->delete();
        
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}

