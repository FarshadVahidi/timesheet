<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Providers\Activiti\ActivityProvider;
use App\Providers\Pdf\PdfProvider;
use App\Services\Pdf\PdfService;
use Crabbly\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class PDFController extends Controller
{
    private $fpdf;

    public function __construct()
    {

    }

    public function update(Request $request, $id)
    {
        if(!empty($id))
        {
            PdfService::update($request, $id)->output();
            exit();
        }

    }

    public function show($id)
    {
        if(!empty($id))
        {
            PdfService::show($id)->Output();
            exit;
        }
    }

    public function index ()
    {
        PdfService::index()->Output();
        exit;
    }

    public function edit($id)
    {
        PdfService::edit($id)->Output();
        exit;
    }
}
