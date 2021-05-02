<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Azienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AziendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $aziende = Azienda::where('id', '<>', 1)->get();
        return View::make('Admin.azienda.index', compact('aziende'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('Admin.azienda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $azienda = Azienda::create($request->all());

        if($request->hasFile('file')){
            $azienda->update([
                'file' => request()->file->store('contract', 'public'),
            ]);
        }
        Session::flash('message', 'Azienda save successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $azienda = Azienda::findOrFail($id);
            return View::make('Admin.azienda.show', compact('azienda'));
        }catch(\Exception $e){
            Session::flash('error', 'Azienda id is not valid');
            return redirect()->back();
        }
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
        try{
            $azienda = Azienda::findOrFail($id);
            $azienda->update(['name' => $request->name, 'p_iva' => $request->p_iva]);
            if($request->hasFile('file')){
                $azienda->update([
                    'file' => request()->file->store('contract', 'public'),
                ]);
            }
            Session::flash('message', 'update successfully!');
            return redirect()->back();
        }catch(\Exception $e){
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
}
