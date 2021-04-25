<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $orders = Order::all();
        return View::make('Admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = Company::where('id', '<>', 1)->get();
        return View::make('Admin.order.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request)){
            if(!empty($this->validateRequest())){
                $request->request->add(['company_id' => 1]);
                $order = Order::create($request->all());
                $this->storeFile($order);
                Session::flash('message', 'Order successfully saved!');
                return redirect()->back();
            }else{
                Session::flash('error','please check input there is problem on input');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'There is a problem on Request');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    private function validateRequest(){
        return tap(request()->validate([
            'customer_id' => 'required|numeric',
            'start' => 'required|date',
            'end' => 'required|date',
            'days' => 'required|numeric',
            'cost' => 'required|numeric',
        ]), function(){
           if(request()->hasFile('file')){
               request()->validate([
                   'file' => 'file'
               ]);
           }
        });
    }


    private function storeFile($order)
    {
        if (request()->hasFile('file')) {
            $order->update([
                'file' => request()->file->store('orders', 'public'),
            ]);
        }
    }
}
