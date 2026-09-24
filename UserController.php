<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // １ページあたり20件のデータを取得
        $users = User::latest()->paginate(20);

        //ビューにデータを渡す
        return view('users.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        // バリデーションの実行
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        // ユーザーの作成(バリデーション済みのデータを使用)
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/users');
    }
}
