<?php

namespace App\Providers\Admin;

use App\Models\Event;
use App\Models\User;
use http\Env\Request;
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
}
