<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::where('id', '<>', 1)->get();
        return View::make('Admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('Admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($this->validateRequest())) {
            try {
                $request->request->add(['company_id' => 1]);
                $company = Company::create($request->all());
                $this->storeFile($company);
                Session::flash('message', 'Company saved in database successfully!');
                return redirect()->back();
            } catch (Exception $d) {
                Session::flash('error', 'There was on store method');
                return redirect()->back();
            }
        }
        Session::flash('error', 'Validation problem check input');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!empty($id)) {
            try {
                $company = Company::findOrFail($id);
                return View::make('Admin.company.show', compact('company'));
            } catch (Exception $e) {
                Session::flash('error', 'company Id is not valid');
                return redirect()->back();
            }

        } else {
            Session::flash('error', 'Company Id was undefined');
            return redirect()->back();
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
        if (!empty($id) && !empty($request)) {
            if (!empty($this->validateRequest())) {

                try {

                    $company = Company::findOrFail($id);
                    $company->update(['name'=> $request->name, 'p_iva' => $request->p_iva]);
                    $this->storeFile($company);
                    Session::flash('message', 'Company saved in database successfully!');
                    return redirect()->back();
                } catch (Exception $d) {
                    Session::flash('error', 'There was problem on store method');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Validation problem check input');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'Request not valid');
            return redirect()->back();
        }

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

    private function validateRequest()
    {
        return tap(request()->validate([
            'name' => 'required|string|max:50',
            'p_iva' => 'required|string',
        ]), function () {
            if (request()->hasFile('file')) {
                request()->validate([
                    'file' => 'file',
                ]);
            }
        });
    }

    private function storeFile($company)
    {
        if (request()->hasFile('file')) {
            $company->update([
                'file' => request()->file->store('contract', 'public'),
            ]);
        }
    }
}
