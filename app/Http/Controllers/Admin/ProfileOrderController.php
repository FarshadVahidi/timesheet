<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Azienda;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ProfileOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
//        $order_user = User::join('workon', 'user_id', '=', 'users.id')
//            ->get();
//        dd($order_user);

        $aziende = Azienda::where('id', '<>', 1)->get();

        return View::make('Admin.profile.index' , compact('aziende'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orders = Order::where('aziende_id', '=', request()->azienda)->get(['id','name', 'start', 'days', 'cost']);

        return View::make('Admin.profile.show', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $workon = DB::table('users')->join('events', 'users.id', '=', 'events.user_id')
            ->join('orders', 'orders.id' , '=', 'events.order_id')
            ->where('order_id' , '=', $id)
            ->whereNotNull('order_id')
            ->select('order_id', 'user_id', 'users.name as name', 'orders.name as orderName')
            ->groupBy('order_id', 'user_id')
            ->selectRaw('sum(hour) as hours')
            ->selectRaw('count(events.start) as days')
            ->get();
        return View::make('Admin.profile.worker', compact('workon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
