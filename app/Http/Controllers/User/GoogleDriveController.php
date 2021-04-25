<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Providers\GoogleDriveServiceProvider;
use App\Services\Pdf\PdfService;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Google_Client;
use Google_service_Drive;

class GoogleDriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     */
    public function index()
    {
//        Storage::disk('google')->put('test.txt', 'hello world'); // THIS ONE IS WORKING

        $pdf = PdfService::index()->output();

        try{
            Storage::disk('google')->put('timesheet.pdf', $pdf);
            Session::flash('message', 'file uploaded to you google drive');
            return redirect()->back();
        }catch(\Exception $e){
            Session::flash('error', 'There was problem try later');
            return redirect()->back();
        }
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
}
