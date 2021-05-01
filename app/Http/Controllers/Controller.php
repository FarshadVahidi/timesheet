<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        if(auth()->user()->hasRole('administrator'))
        {
            return view('Admin.dashboard');
        }
        if(auth()->user()->hasRole('user'))
        {
            $project = DB::table('workon')->join('users', 'workon.user_id' , '=', 'users.id')
                                        ->join('orders', 'orders.id' , '=', 'workon.order_id')
                                        ->where('users.id' , '=', auth()->user()->id)
                                        ->get(['order_id', 'orders.name']);

//            $project = DB::table('events')
//                ->join('users', 'users.id', '=', 'events.user_id')
////                ->join('orders', 'orders.id', '=', 'events.order_id')
////                ->select('events.id', 'user_id', 'order_id', 'title', 'events.start', 'allDay', 'hour', 'ferie', 'orders.name', 'company_id', 'aziende_id')
//                ->where('users.id', '=', auth()->user()->id)
////                ->groupBy('events.id', 'user_id', 'order_id', 'title', 'events.start', 'allDay', 'hour', 'ferie', 'orders.name', 'company_id', 'aziende_id')
//                ->get();

            return view('User.dashboard', compact('project'));
        }
    }
}
