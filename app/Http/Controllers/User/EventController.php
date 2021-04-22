<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Providers\Activiti\ActivityProvider;
use App\Providers\User\EventProvider;
use App\Services\User\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $entry = Event::where('user_id', '=', $request->user()->id)->where('start', '=', $request->start)->first();
        if($entry === null){
//            (new EventProvider($request))->store($request);
//            return redirect()->back();
            EventService::store($request);
            return redirect()->back();
        }else{
            //sweet alert not working
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
// mysql> select DATE_FORMAT(start, '%Y-%m') as 'month', sum(hour) from events group by month;
        $alldata = (new ActivityProvider(\request()))->edit($id);

        return View::make('User.edit', compact('alldata'));
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
