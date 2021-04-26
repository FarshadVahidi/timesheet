<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Services\Admin\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
        try{
            $orders = OrderService::index();
            return View::make('Admin.order.index', compact('orders'));
        }catch(Exception $e){
            Session::flash('error', 'There was a problem on database');
            return View::make('Admin.dashboard');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = OrderService::create();
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
                $order = OrderService::store($request);
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
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        if(!empty($id)){
            try{
                $order = OrderService::show($id);
                return View::make('Admin.order.show', compact('order'));
            }catch(\Exception $e){
                Session::flash('error', 'There is problem on database');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'There is problem on your request');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(!empty($id)){
            try{
                $path = OrderService::edit($id);
                return Storage::response($path);
            }catch(Exception $e){
                Session::flash('error', 'There was problem on extract data from database');
                return redirect()->back();
            }

        }else{
            Session::flash('error', 'Company id was empty');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(!empty($id) && !empty($request)){
            if(!empty($this->validateRequest())){
                $order = OrderService::update($request, $id);
                $this->storeFile($order);
                Session::flash('message', 'Order update successfully');
                return redirect()->back();
            }else{
                Session::flash('error', 'input has problem');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'Request had problem');
            return redirect()->back();
        }
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
