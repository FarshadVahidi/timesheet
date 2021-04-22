<?php

namespace App\Services\Admin;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventService{

    public static function index()
    {
        return DB::table('users')
            ->join('events', 'user_id', '=', 'users.id')
            ->select('events.id','user_id', 'start', 'end', 'allDay', 'hour', 'title', 'name')->get();
    }

    public static function store($request)
    {
        $event = new Event();
        $event->user_id = $request->user()->id;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->allDay = $request->allDay;
        $event->title = $request->title;
        $event->hour = $request->hour;
        if($request->has('ferie'))
            $event->ferie = true;
        else
            $event->ferie = false;
        $event->save();
    }

    public static function show($id)
    {
        return Event::where('ferie', '=' , true)
            ->where('user_id', '=', $id)
            ->orderBy('start')
            ->get();
    }

    public static function edit($id)
    {
        $alldata = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m') as month"),
            \DB::raw('SUM(hour) as amount'),
            'user_id'
        ])
            ->where('user_id', '=', $id)
            ->groupBy('month', 'user_id')
            ->orderBy('month')
            ->get();
        $report = [];

        $alldata->each(function($item) use (&$report) {
            $report[$item->month][$item->hour] = [
                'amount' => $item->amount
            ];
        });
        return $alldata;
    }

    public static function update($request , $event)
    {
        if($request->has('UpFerie'))
        {
            $event->ferie = true;
            $event->hour = 0;
            $event->title = "FERIE";
        }else{
            $event->title = $request->uptitle;
            $event->hour = $request->UpHour;
            $event->ferie = false;
        }

        $event->update();
    }

    public static function AutoFill($request, $id)
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
                    $event->user_id = auth()->user()->id;
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
}
