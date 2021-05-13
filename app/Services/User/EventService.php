<?php

namespace App\Services\User;

use App\Mail\FerieMail;
use App\Models\Event;
use App\Models\FerieAsk;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EventService{

    public static function index($id)
    {
        return Event::where('user_id', '=', $id)->get();
    }

    public static function store ($request)
    {
        $event = new Event();

        if ($request->has('ferie')) {
            $check = FerieAsk::where('name', '=', $request->user()->id)->where('day', '=', $request->start)->get();
            if(empty($check[0])){
                $ferie = new FerieAsk();
                $ferie->day = $request->start;
                $ferie->name = $request->user()->id;
                $ferie->save();


                $temp = DB::table('users')->where('id', $request->user()->id)->get();

                //send email to user
                $data = ([
                    'text' => $temp[0]->name .' Asked vacation for below Data.',
                    'data' => $request->start,
                ]);

                Mail::to('test@test.com')->send(new FerieMail($data));
                Session::flash('message', 'you will recive email for accept or denied your request');
            }else{
                Session::flash('error', 'you have asked befor for this day');
            }

        } else {
            $event->user_id = $request->user()->id;
            $event->start = $request->start;
            $event->allDay = $request->allDay;
            $event->hour = $request->hour;
            $event->ferie = false;
            $event->order_id = $request->selectId;
            $event->title = self::makeTitle($request);
            $event->save();
            Session::flash('message', 'you hour added successfully!');
        }

    }

    public static function update($request, $event)
    {

        $event->hour = $request->UpHour;
        if(! $request->has('UpFerie')){
            $event->ferie = false;
            $event->title = self::makeUpTitle($request);
            $event->order_id = $request->UpselectId;
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
                    $event->order_id = 1;
                    $event->hour = 8;
                    $event->title = 'DEFAULT PROJECT / Auto Fill';
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
//        dd($request);
        $p = Order::where('id','=', $request->selectId)->pluck('name');
//dd($p);
        return $p[0] . " / " . $request->title;
    }

    private static function makeUpTitle($request): string
    {
//        dd($request->UpTitle);
//        $s = (explode('-', $request->UpTitle));
//        dd($s);

        $p = Order::where('id','=', $request->UpselectId)->pluck('name');

        return $p[0] . " / " . $request->UpTitle;
    }
}
