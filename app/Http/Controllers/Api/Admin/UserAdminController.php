<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::with("socials")->get();

        return response()->json([
            'status' => true,
            'data' => [
                'data' => $users
            ],
        ]);
    }
}
