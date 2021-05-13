<?php

namespace App\Providers\Activiti;

use App\Models\Event;
use Illuminate\Support\Facades\DB;
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
            \DB::raw('SUM(hour) as amount'),
            'user_id',
        ])
            ->where('user_id', '=', $id)
            ->groupBy('month', 'user_id')
            ->orderBy('month')
            ->get();
        $report = [];

        $alldata->each(function ($item) use (&$report) {
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
            ->where('start', '<', $de)
            ->groupBy('month')
            ->orderBy('month')
            ->get()->pluck('amount');

        return $alldata;
    }

    public function monthPDF($id, $dt, $de)
    {
        $data = DB::table('events')
            ->select([
                \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as month"),
                \DB::raw("SUM(hour) as hour"),
//                'title'
            ])
            ->where('start', '>=' , $dt)
            ->where('start', '<', $de)
            ->where('user_id', '=' , $id)
            ->groupBy('start')
            ->orderBy('start')
            ->get();
        return $data;
    }
}
