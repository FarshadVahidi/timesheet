<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Providers\Admin\EventProvider;
use App\Services\Admin\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\VarDumper\Cloner\Data;
use function PHPUnit\Framework\isEmpty;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $events = EventService::index();
//        $events = Event::all();
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $entry = Event::where('user_id', '=', $request->user()->id)->where('start', '=', $request->start)->first();
        if($entry === null){
            EventService::store($request);
            Session::flash('message', 'stored successfuly');
            return redirect(route('dashboard'));
        }else{
            //sweet alert not working
            Session::flash('error', 'There was problem');
            return redirect(route('dashboard'));
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
        if(!empty($id))
        {
            $allFerie = EventService::show($id);
            if(!empty($allFerie[0])) {
                return View::make('Admin.ferie', compact('allFerie'));
            }else
                return View::make('Admin.ferieEmpty');
        }
        return redirect(route('dashboard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        if(!empty($id))
        {
            $alldata = EventService::edit($id);
            Session::flash('message', 'edit Successfully');
            return View::make('Admin.user.edit', compact('alldata'));
        }
        Session::flash('error', 'there was problem on edit');
        return redirect(route('dashboard'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $event = Event::findOrFail($request->eventId);
        if($event !== null)
        {
            EventService::update($request, $event);
            Session::flash('message', 'update successfully!');
            return redirect(route('dashboard'));
        }
        Session::flash('error', 'there was a problem');
        return redirect(route('dashboard'));

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
