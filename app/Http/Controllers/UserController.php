<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        return view('admin.pages.user')->with([
            'users' => $users
        ]);
    }

    public function destroy(User $id)
    {
        User::destroy($id->id);
        return redirect('/users')->with('success', 'User berhasil dihapus');
    }
}
