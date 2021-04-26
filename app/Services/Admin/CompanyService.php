<?php

namespace App\Services\Admin;



use App\Models\Company;

class CompanyService{

    public static function index()
    {
        return Company::where('id', '<>', 1)->get();
    }

    public static function store($request)
    {
        $request->request->add(['company_id' => 1]);
        return  Company::create($request->all());
    }

    public static function show($id)
    {
        return Company::findOrFail($id);
    }

    public static function update($request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update(['name'=> $request->name, 'p_iva' => $request->p_iva]);
        return $company;
    }
}
