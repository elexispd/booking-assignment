<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function myProfile() {
        $user = auth()->user();
        return response()->json($user);
    }

}
