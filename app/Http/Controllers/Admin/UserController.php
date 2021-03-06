<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use App\Providers\Admin\UserProvider;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\VarDumper\Cloner\Data;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = UserService::index();
        return View::make('Admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('Admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Request $request): \Illuminate\Contracts\View\View
    {
        if (!empty($request)) {
                UserService::store($request);
                Session::flash('message', 'User add to Data base');
                return View::make('Admin.create');
        }
        Session::flash('error', 'There was problem!');
        return View::make('Admin.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        if(!empty($user) && !empty($user->id)){

            $orderWork = DB::table('workon')->join('orders', 'order_id' , '=' , 'orders.id')
                ->join('aziende', 'aziende.id' , '=', 'orders.aziende_id')
                ->join('users', 'user_id', '=', 'users.id')
                ->where('workon.user_id','=', $user->id)
                ->select('user_id', 'order_id', 'orders.name', 'aziende.name as aziendaName', 'users.name as user_name')
                ->get();
//dd($orderWork);
            $allOrders = Order::select('orders.id as order_id', 'orders.name as order_name', 'aziende.name as aziendeName')->whereNotIn('orders.id', function($query) use ($user) {
                $query->select('order_id')->from('workon')
                    ->where('workon.user_id','=', $user->id);
            })->join('aziende' , 'aziende.id' , '=', 'orders.aziende_id')
//                ->join('workon', 'workon.order_id', '=', 'orders.id')
                ->get();
$user_id = $user->id;
            return View::make('Admin.user.dedicateOrder', compact('orderWork', 'allOrders', 'user_id'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validateRequest(): bool
    {
        request()->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required|string'
        ]);
        return true;
    }
}
