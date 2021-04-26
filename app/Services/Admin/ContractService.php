<?php

namespace App\Services\Admin;

use App\Models\Company;

class ContractService{

    public static function show($id)
    {
        $path = Company::select('file')->where('id', '=', $id)->get();
        return str_replace('contract','public/contract', $path->pluck('file')[0]);
    }
}
