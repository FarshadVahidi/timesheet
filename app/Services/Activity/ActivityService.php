<?php

namespace App\Services\Activity;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class ActivityService{

    public static function edit($id)
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

    public static function month($id, $dt, $de)
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

    public static function monthPDF($id, $dt, $de){
        $data = DB::table('events')
            ->select([
                \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as month"),
                'hour',
                'title'
            ])
            ->where('start', '>=' , $dt)
            ->where('start', '<', $de)
            ->where('user_id', '=' , $id)
            ->orderBy('start')
            ->get();
        return $data;
    }
}
