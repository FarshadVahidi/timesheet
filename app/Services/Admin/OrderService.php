<?php

namespace App\Services\Admin;

use App\Models\Azienda;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService{

    public static function index()
    {
        return Order::join('aziende', 'aziende.id' , '=', 'orders.aziende_id')
            ->select(
                'orders.start',
                'orders.end',
                'orders.id',
                'aziende.name',
                'orders.cost',
                'orders.aziende_id')
            ->where('orders.id', '<>', 1)
            ->get();
    }

    public static function create()
    {
        return Azienda::where('id', '<>', 1)->get();
    }

    public static function store($request)
    {
        $request->request->add(['company_id' => 1]);
        return Order::create($request->all());
    }

    public static function show($id)
    {
        return Order::join('aziende', 'aziende.id', '=', 'orders.aziende_id')
            ->select('orders.id as order_id', 'aziende_id', 'start', 'end', 'days', 'cost', 'aziende.name as name', 'orders.name as orderName')
            ->where('orders.id', '=', $id)
            ->get();
    }

    public static function edit($id)
    {
        $path = Order::select('file')->where('id', '=', $id)->get();
        return str_replace('orders','public/orders', $path->pluck('file')[0]);
    }

    public static function update($request, $id)
    {
        $order = Order::findOrfail($id);
        $order->update($request->all());
        return $order;
    }
}
