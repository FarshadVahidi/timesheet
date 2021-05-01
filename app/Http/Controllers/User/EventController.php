<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Providers\Activiti\ActivityProvider;
use App\Providers\User\EventProvider;
use App\Services\Activity\ActivityService;
use App\Services\User\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use phpDocumentor\Reflection\Types\Compound;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
//        $events = Event::where('user_id', '=', auth()->user()->id)->get();
        $events = EventService::index(auth()->user()->id);
        return response()->json($events);
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
        //select sum(hour) from events where user_id = 3 and start='2021-04-30'
        $hour = Event::select([
            DB::raw("SUM(hour) as hour")
        ])->where('user_id', '=', auth()->user()->id)->where('start' , '=', $request->start)->groupBy('start')->get()->pluck('hour');

        if( empty($hour[0]) || $hour[0] < 8.0 ){
//            (new EventProvider($request))->store($request);
//            return redirect()->back();
            EventService::store($request);
            Session::flash('message', 'you hour added successfully!');
            return redirect()->back();
        }else{
            //sweet alert not working
            Session::flash('error', 'you can not enter more than 8 hour work');
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
        if(!empty($id))
        {
            $allFerie = EventService::show($id);
            return View::make('User.ferie', compact('allFerie'));
        }else{
            // put sweet alert for error
        }

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
            // mysql> select DATE_FORMAT(start, '%Y-%m') as 'month', sum(hour) from events group by month;
            $alldata = ActivityService::edit($id);
            Session::flash('message', 'edit successfully!');
            return View::make('User.edit', compact('alldata'));
        }
        Session::flash('error', 'there was a problem');
        return View::make('User.dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $event = Event::findOrFail($request->eventId);
        if($event !== null)
        {
//            (new EventProvider($request))->update($request, $event);
            EventService::update($request, $event);
            return redirect(route('dashboard'));
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

    private function validateRequest(): array
    {
        return request()->validate([
           'title' => 'required|string|max:100',
           'start' => 'required',
           'end' => 'required',
           'allDay' => 'required',
           'user_id' => 'required',
        ]);
    }
}
