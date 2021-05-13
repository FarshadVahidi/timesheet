<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categori;
use App\Models\Cespito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use function PHPUnit\Framework\isNull;

class CespitiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('cespiti')
            ->join('categoris', 'categoris_id', '=', 'categoris.id')
            ->join('statuses', 'status_id' , '=', 'statuses.id')
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->select('cespiti.id', 'categoris.name', 'marco', 'status', 'users.name as userName')
            ->get();

        return View::make('Admin.cespiti.index', compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('cespiti')
            ->join('categoris', 'categoris_id', '=', 'categoris.id')
            ->join('statuses', 'status_id' , '=', 'statuses.id')
            ->leftJoin('users', 'users.id' , '=', 'cespiti.user_id')
            ->select('cespiti.id as id', 'serialnumber', 'marco', 'modello', 'statuses.id as status_id' , 'statuses.status as status', 'costo', 'acquisto' ,'categoris.name', 'cespiti.user_id as user_id', 'users.id as userId', 'users.name as userName')
            ->where('cespiti.id' , $id)
            ->get();
        $status = DB::table('statuses')->get();
        $user = User::all();
        return View::make('Admin.cespiti.show', compact('data', 'status', 'user'));
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
        $data = Cespito::findOrFail($id);
//dd($request);
        if(!empty($request->status))
            $data->update(['status_id' => $request->status]);
        if($request->user == -1)
            $data->update(['user_id' => null]);
        else
            $data->update(['user_id' => $request->user]);

        Session::flash('message', 'database update!');
        return redirect()->back();
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
