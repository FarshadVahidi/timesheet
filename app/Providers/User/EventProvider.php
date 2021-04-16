<?php

namespace App\Providers\User;

use App\Models\Event;
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

    public function AutoFill($request, $id)
    {
        $dt = Carbon::create($request->monthStart);
        $de = Carbon::create($request->monthEnd);

        while($dt < $de)
        {
            $tmp = Event::where('start', '=', $dt)->select('start')->where('user_id', '=', $id)->get();

            if($tmp->isEmpty()) {
                if ($dt->englishDayOfWeek !== "Saturday" && $dt->englishDayOfWeek !== "Sunday") {

                    $event = new Event();
                    $event->start = $dt->toDate();
                    $event->end = $dt->addDay()->toDate();
                    $event->hour = 8;
                    $event->title = 'Auto Fill';
                    $event->user_id = $id;
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
