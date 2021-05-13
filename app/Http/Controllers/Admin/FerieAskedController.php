<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FerieMail;
use App\Models\Event;
use App\Models\FerieAsk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class FerieAskedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asked = FerieAsk::join('users', 'users.id', '=', 'ferie_asks.name')->select('users.name as name', 'ferie_asks.day as day', 'ferie_asks.id as id')->get();
//        dd($asked);
        return View::make('Admin.ferie.index', compact('asked'));
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
        $e = FerieAsk::findOrFail($id);

        $event = new Event();
        $event->user_id = $e->name;
        $event->start = $e->day;
        $event->allDay = 1;
        $event->hour = 0;
        $event->ferie = true;
        $event->order_id = null;
        $event->title = 'FERIE';
        $event->save();

        FerieAsk::destroy($id);
        $data = ([
            'text' => 'Dear Colleague you request for vacations on data below was accepted',
            'data' => $e->day,
        ]);

        //send email to user
        Mail::to('test@test.com')->send(new FerieMail($data));  // test@test.com is just dummy email
        return redirect()->back();

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

        $e = FerieAsk::findOrFail($id);
        //send email to user
        $data = ([
            'text' => 'Dear Colleague you request for vacations on data below was NOT accepted',
            'data' => $e->day,
            'end' => 'Have nice day.'
        ]);
        FerieAsk::destroy($id);
        //send email to user
        Mail::to('test@test.com')->send(new FerieMail($data));  // test@test.com is just dummy email
        return redirect()->back();
    }
}
