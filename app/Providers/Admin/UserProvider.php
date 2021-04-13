<?php

namespace App\Providers\Admin;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function store($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->attachRole($request->role_id);
    }

    public function show(User $user)
    {
        return Event::where('user_id', '=', $user->id)->orderByRaw('start')->get();
    }
}
