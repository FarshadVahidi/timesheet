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
                    $event->save();
                }else{
                    $dt->addDay();
                }
            }else{
                $dt->addDay();
            }

        }
    }

    public function edit($id)
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
    public function update($request, $event)
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

    public function store($request)
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
}
