<?php

namespace App\Services\Admin;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EventService{

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
        $user->attachRole($request->role_id);
    }

    public static function show($user)
    {
        return Event::where('user_id', '=', $user->id)->orderByRaw('start')->get();
    }
}
