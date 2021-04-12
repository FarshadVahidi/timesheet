<?php

namespace App\Providers\User;

use App\Models\Event;
use Illuminate\Support\ServiceProvider;

class EventProvider extends ServiceProvider
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
        $event = new Event();
        $event->user_id = $request->user()->id;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->allDay = $request->allDay;
        $event->title = $request->title;
        $event->hour = $request->hour;
        $event->save();
    }

    public function update($request, $event)
    {
        $event->title = $request->title;
        $event->hour = $request->UpHour;
        $event->update();
    }
}
