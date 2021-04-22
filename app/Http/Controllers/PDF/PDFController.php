<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Providers\Activiti\ActivityProvider;
use App\Providers\Pdf\PdfProvider;
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
        $month = $request->month;
        $dt = Carbon::create($month);
        $de = Carbon::create($month);
        $de->addMonth();

        $data = (new ActivityProvider($month))->monthPDF($id, $dt, $de);

        $total = (new ActivityProvider($month))->month($id, $dt, $de);


        $userToPrint = User::findOrFail($id);

        $this->fpdf = new FPDF('p', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->SetFont('Arial', 'B',  14);

        // start first page
        $this->fpdf->Cell(189, 35, '', 0, 1);

        $this->fpdf->Cell(189, 5, 'Rapportino ore da convalidare dal responsabile', 0, 1, 'C');
        $this->fpdf->Cell(189, 20, '', 0, 1);


        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(32, 5 , '', 0);
        $this->fpdf->Cell(47, 5, 'Mese di riferimento', 0);
        $this->fpdf->Cell(47, 5 , '', 0);
        $this->fpdf->Cell(47, 5, $month, 0, 1);

        $this->fpdf->Cell(32, 5, '', 0, 0);
        $this->fpdf->Cell(47, 5, 'Risors', 0);
        $this->fpdf->Cell(47, 5, '', 0, 0);
        $this->fpdf->Cell(47, 5, $userToPrint['name'], 0, 1);

        $this->fpdf->Cell(189, 15, '', 0, 1);

        $this->fpdf->Cell(189, 5, 'Di seguito vengaono riassunte le ore dedicate per vostra approvazione, in seconda pagina segue ', 0, 1);
        $this->fpdf->Cell(189, 5, 'il dettaglio delle ore per giorno.', 0, 1);

        $this->fpdf->Cell(189, 25, '', 0, 1);

        $this->fpdf->Cell(32, 5, '',0);
        $this->fpdf->Cell(52, 5, 'Totali', 0);

        $this->fpdf->Cell(47, 5, 'Ore Lav.', 0);
        $this->fpdf->Cell(47, 5, 'Giornate Lav.', 0 , 1);
        $this->fpdf->Cell(32, 5, '',0);
        $this->fpdf->Cell(52, 5, 'Tot. Ordinario', 0);

        $this->fpdf->Cell(47, 5, $total[0], 0);
        $this->fpdf->Cell(47, 5, $total[0]/8, 0, 1);

        $this->fpdf->Cell(189, 25, '', 0, 1);

        $this->fpdf->Cell(38, 5, '', 0);
        $this->fpdf->Cell(38, 5, 'Data', 0);
        $this->fpdf->Cell(38, 5, '', 0);
        $this->fpdf->Cell(38, 5, 'Firma' , 0, 1);
        $this->fpdf->Cell(38, 15, '', 0);
        $this->fpdf->Cell(38, 15, '_____________', 0);
        $this->fpdf->Cell(38, 15, '', 0);
        $this->fpdf->Cell(38, 15, '_____________' , 0, 1);

        $this->fpdf->Cell(189, 89, '', 0, 1);
        // end of first page

        // start second page
        $this->fpdf->Cell(189, 5, '', 0, 1);
        $this->fpdf->Cell(189, 5, 'Riassunto ore lavorate per giorno', 0, 1);
        $this->fpdf->Cell(189, 5, '', 0, 1);
        $this->fpdf->Cell(189, 5, 'Leggenda: R=Reperibilita\', S=Straordinario, N=Notturno, F=Festivo', 0,1, 'C');
        $this->fpdf->Cell(189, 10, '', 0,1);

        $this->fpdf->Cell(30, 8, '', 0);
        $this->fpdf->Cell(40, 8, 'Mese', 1, 0, 'C');
        $this->fpdf->Cell(30, 8, 'Giorno', 1, 0, 'C');
        $this->fpdf->Cell(20, 8, 'Ore', 1, 0 , 'C');
        $this->fpdf->Cell(40, 8, 'Attivita\'', 1, 1, 'C');
        foreach($data as $p)
        {
            $t = $p->title;
            $g = \Carbon\Carbon::create($p->month);
            $len = strlen($p->title);
            $this->fpdf->Cell(30, 8, '', 0);

            $this->fpdf->Cell(40, 8, $p->month, 'LR', 0, 'C');

            $this->fpdf->Cell(30, 8, $g->englishDayOfWeek, 'LR', 0, 'C');

            $this->fpdf->Cell(20, 8, $p->hour, 'LR',0, 'C');

            $txt = str_split($t, 20);
            $this->fpdf->Cell(40, 8, $txt[0], 'LR', 1, 'C');

            if($len > 20){
                for($i=1 ; $i< $len/20 ; $i++){
                    $this->fpdf->Cell(30, 8, '', 1);
                    $this->fpdf->Cell(40, 8, '', 'LR' , 0);
                    $this->fpdf->Cell(30, 8, '', 'LR' , 0);
                    $this->fpdf->Cell(20, 8, '', 'LR' , 0);
                    $this->fpdf->Cell(40, 8, $txt[$i], 'LR', 1);
                }
            }
        }
        $this->fpdf->Cell(30, 8, '', 0,0);
        $this->fpdf->Cell(130, 8, '', 'T', 0);

        $this->fpdf->Output();
        exit;
    }

    public function show($id)
    {
        $dt = \Carbon\Carbon::now();
        $allFerie = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as month"),
        ])->where('ferie', '=' , true)->where('user_id' , '=', $id)->orderBy('start')->get();

        $user = User::findOrFail($id);

        $this->fpdf = new FPDF('p', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->SetFont('Arial', 'B',  14);

        // start page
        $this->fpdf->Cell(189, 35, '', 0, 1);

        $this->fpdf->Cell(189, 5, 'Rapporto dei prossimi Ferie', 0, 1, 'C');
        $this->fpdf->Cell(189, 20, '', 0, 1);


        $this->fpdf->Cell(28, 5, '',0);
        $this->fpdf->Cell(52, 5, 'Date di domanda', 0);

        $this->fpdf->Cell(47, 5, '', 0);
        $this->fpdf->Cell(47, 5, $dt, 0 , 1);

        $this->fpdf->Cell(28, 5, '',0);
        $this->fpdf->Cell(52, 5, 'Staff', 0);

        $this->fpdf->Cell(47, 5, '', 0);
        $this->fpdf->Cell(47, 5, $user->name, 0 , 1);
        $this->fpdf->Cell(189, 35, '',0, 1);

        $this->fpdf->Cell(50, 8, '', 0);
        $this->fpdf->Cell(40, 8, 'Mese', 1, 0, 'C');
        $this->fpdf->Cell(30, 8, 'Giorno', 1, 1, 'C');

        foreach($allFerie as $p)
        {

            $g = \Carbon\Carbon::create($p->month);

            $this->fpdf->Cell(50, 8, '', 0);

            $this->fpdf->Cell(40, 8, $p->month, 'LR', 0, 'C');

            $this->fpdf->Cell(30, 8, $g->englishDayOfWeek, 'LR', 1, 'C');

        }
        $this->fpdf->Cell(50, 8, '', 0,0);
        $this->fpdf->Cell(70, 30, '', 'T', 1);

        $this->fpdf->Cell(38, 5, '', 0);
        $this->fpdf->Cell(38, 5, 'Data', 0);
        $this->fpdf->Cell(38, 5, '', 0);
        $this->fpdf->Cell(38, 5, 'Firma' , 0, 1);
        $this->fpdf->Cell(38, 15, '', 0);
        $this->fpdf->Cell(38, 15, '_____________', 0);
        $this->fpdf->Cell(38, 15, '', 0);
        $this->fpdf->Cell(38, 15, '_____________' , 0, 1);


        $this->fpdf->Output();
        exit;
    }

    public function index ()
    {
        $dt = \Carbon\Carbon::now();
        $allFerie = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as month"),
        ])->where('ferie', '=' , true)->where('start', '>', $dt)->orderBy('start')->get();

        $this->fpdf = new FPDF('p', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->SetFont('Arial', 'B',  14);

        $this->fpdf->Cell(189, 35, '', 0, 1);

        $this->fpdf->Cell(189, 5, 'Rapporto dei prossimi Ferie', 0, 1, 'C');
        $this->fpdf->Cell(189, 20, '', 0, 1);


        $this->fpdf->Cell(28, 5, '',0);
        $this->fpdf->Cell(52, 5, 'Date di domanda', 0);

        $this->fpdf->Cell(47, 5, '', 0);
        $this->fpdf->Cell(47, 5, $dt, 0 , 1);
        $this->fpdf->Cell(189, 35, '',0, 1);

        $this->fpdf->Cell(50, 8, '', 0);
        $this->fpdf->Cell(40, 8, 'Mese', 1, 0, 'C');
        $this->fpdf->Cell(30, 8, 'Giorno', 1, 1, 'C');

        foreach($allFerie as $p)
        {

            $g = \Carbon\Carbon::create($p->month);

            $this->fpdf->Cell(50, 8, '', 0);

            $this->fpdf->Cell(40, 8, $p->month, 'LR', 0, 'C');

            $this->fpdf->Cell(30, 8, $g->englishDayOfWeek, 'LR', 1, 'C');

        }
        $this->fpdf->Cell(50, 8, '', 0,0);
        $this->fpdf->Cell(70, 30, '', 'T', 1);

        $this->fpdf->Cell(38, 5, '', 0);
        $this->fpdf->Cell(38, 5, 'Data', 0);
        $this->fpdf->Cell(38, 5, '', 0);
        $this->fpdf->Cell(38, 5, 'Firma' , 0, 1);
        $this->fpdf->Cell(38, 15, '', 0);
        $this->fpdf->Cell(38, 15, '_____________', 0);
        $this->fpdf->Cell(38, 15, '', 0);
        $this->fpdf->Cell(38, 15, '_____________' , 0, 1);


        $this->fpdf->Output();
        exit;
    }
}
