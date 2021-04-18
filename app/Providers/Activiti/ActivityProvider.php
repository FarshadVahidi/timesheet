<?php

namespace App\Providers\Activiti;

use App\Models\Event;
use Illuminate\Support\ServiceProvider;

class ActivityProvider extends ServiceProvider
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

    public function edit($id)
    {
        $alldata = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m') as month"),
            \DB::raw('SUM(hour) as amount')
        ])
            ->where('user_id', '=', $id)
            ->groupBy('month')
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

    public function month($id, $dt, $de)
    {
        $alldata = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m') as month"),
            \DB::raw('SUM(hour) as amount')
        ])
            ->where('user_id', '=', $id)
            ->where('start', '>=', $dt)
            ->where('start', '<' , $de)
            ->groupBy('month')
            ->orderBy('month')
            ->get()->pluck('amount');
//        $report = [];
//
//        $alldata->each(function($item) use (&$report) {
//            $report[$item->month][$item->hour] = [
//                'amount' => $item->amount
//            ];
//        });
        return $alldata;
    }
}
