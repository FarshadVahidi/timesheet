<?php

namespace App\Services\Admin;

use App\Models\Company;
use App\Models\Order;

class OrderService{

    public static function index()
    {
        return Order::join('companies', 'companies.id' , '=', 'orders.customer_id')
            ->select([
                'orders.start',
                'orders.end',
                'orders.id',
                'companies.name',
                'orders.cost',
                'orders.customer_id'])
            ->get();
    }

    public static function create()
    {
        return Company::where('id', '<>', 1)->get();
    }

    public static function store($request)
    {
        $request->request->add(['company_id' => 1]);
        return Order::create($request->all());
    }

    public static function show($id)
    {
        return Order::join('companies', 'companies.id', '=', 'orders.customer_id')
            ->select('orders.id as order_id', 'customer_id', 'start', 'end', 'days', 'cost', 'companies.name as name')
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
