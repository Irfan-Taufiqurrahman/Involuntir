<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::with('socials')->paginate();

        return response()->json([
            'status' => true,
            'data' => [
                'data' => $users,
            ],
        ]);
    }
}
