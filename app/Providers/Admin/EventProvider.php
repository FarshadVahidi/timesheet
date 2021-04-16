<?php

namespace App\Providers\Admin;

use App\Models\Event;
use http\Env\Request;
use Illuminate\Support\Carbon;
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

    public function AutoFill($request, $id)
    {
        $dt = Carbon::create($request->monthStart);
        $de = Carbon::create($request->monthEnd);

        while($dt < $de)
        {
            $tmp = Event::where('start', '=', $dt)->select('start')->get()->where('user_id', '=', $id);

            if($tmp->isEmpty()) {
                if ($dt->englishDayOfWeek !== "Saturday" && $dt->englishDayOfWeek !== "Sunday") {

                    $event = new Event();
                    $event->start = $dt->toDate();
                    $event->end = $dt->addDay()->toDate();
                    $event->hour = 8;
                    $event->title = 'Auto Fill';
                    $event->user_id = auth()->user()->id;
                    $event->allDay = 1;
                    $event->save();
                }else{
                    $dt->addDay();
                }
            }else{
                $dt->addDay();
            }

        }
    }
}
