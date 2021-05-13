<?php

namespace App\Services\Admin;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService{

    public static function index()
    {
        return User::all();
    }

    public static function store($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('workon')->insert(['user_id' => $user->id, 'order_id' => 1]);
        $user->attachRole($request->role_id);
    }

    public static function show($user)
    {
        return Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as start"),
            'title',
            'hour',
        ])
            ->where('user_id', '=', $user->id)
            ->orderByRaw('start')
            ->get();
    }
}
