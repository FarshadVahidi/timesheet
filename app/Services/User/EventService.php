<?php

namespace App\Services\User;

use App\Models\Event;
use App\Models\Order;
use Carbon\Carbon;

class EventService{

    public static function index($id)
    {
        return Event::where('user_id', '=', $id)->get();
    }

    public static function store ($request)
    {
        $event = new Event();
        $event->user_id = $request->user()->id;

        $event->start = $request->start;
        $event->allDay = $request->allDay;
        $event->hour = $request->hour;
        if ($request->has('ferie')) {
            $event->ferie = true;
            $event->order_id = null;
            $event->title = 'FERIE';
        } else {
            $event->ferie = false;
            $event->order_id = $request->selectId;
            $event->title = self::makeTitle($request);
    }
        $event->save();
    }

    public static function update($request, $event)
    {

        $event->hour = $request->UpHour;
        if(! $request->has('UpFerie')){
            $event->ferie = false;
            $event->title = self::makeTitle($request);
        }
        else{
            $event->ferie = true;
            $event->order_id = NULL;
            $event->title = 'FERIE';
        }

        $event->update();
    }

    public static function show($id)
    {
        // here i want to show just the holiday from this moment forward
        $dt = Carbon::now();
        return Event::where('ferie', '=' , true)->where('start', '>', $dt)->orderBy('start')->get();
    }

    public static function AutoFill($request, $id)
    {
        $dt = \Illuminate\Support\Carbon::create($request->monthStart);
        $de = Carbon::create($request->monthEnd);

        while($dt < $de)
        {
            $tmp = Event::where('start', '=', $dt)->select('start')->where('user_id', '=', $id)->get();

            if($tmp->isEmpty()) {
                if ($dt->englishDayOfWeek !== "Saturday" && $dt->englishDayOfWeek !== "Sunday") {

                    $event = new Event();
                    $event->start = $dt->toDate();
                    $event->order_id = null;
                    $event->hour = 8;
                    $event->title = 'Auto Fill';
                    $event->user_id = $id;
                    $event->allDay = 1;
                    $event->ferie = false;
                    $event->save();
                }else{
                    $dt->addDay();
                }
            }else{
                $dt->addDay();
            }
        }
    }

    /**
     * @param $request
     * @return string
     */
    private static function makeTitle($request): string
    {
        $s = (explode('-', $request->title));

        $p = Order::where('id', $s[0])->pluck('name');

        return $p[0] . " / " . $s[1];
    }
}
