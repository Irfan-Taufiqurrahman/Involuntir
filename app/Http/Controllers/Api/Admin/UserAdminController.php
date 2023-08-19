<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->orderBy('created_at', 'desc')->select('name', 'username', 'email', 'no_telp', 'role', DB::raw('DATE_FORMAT(users.created_at, "%d/%m/%Y %H:%i") as tanggal_dibuat'))->get();

        return response()->json(['data' => $users]);
    }
}
