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
            $project = DB::table('workon')->join('users', 'workon.user_id' , '=', 'users.id')
                ->join('orders', 'orders.id' , '=', 'workon.order_id')
                ->where('users.id' , '=', auth()->user()->id)
                ->get(['order_id', 'orders.name']);
            return view('Admin.dashboard', compact('project'));
        }
        if(auth()->user()->hasRole('user'))
        {
            $project = DB::table('workon')->join('users', 'workon.user_id' , '=', 'users.id')
                                        ->join('orders', 'orders.id' , '=', 'workon.order_id')
                                        ->where('users.id' , '=', auth()->user()->id)
                                        ->get(['order_id', 'orders.name']);

            return view('User.dashboard', compact('project'));
        }
    }
}
