<?php

namespace App\Services\Pdf;

use App\Models\Event;
use App\Models\User;
use App\Providers\Activiti\ActivityProvider;
use Crabbly\Fpdf\Fpdf;
use Illuminate\Support\Carbon;

class PdfService{
    private $fpdf;

    public static function update($request, $id)
    {
        $month = $request->month;
        $dt = Carbon::create($month);
        $de = Carbon::create($month);
        $de->addMonth();

        $data = (new ActivityProvider($month))->monthPDF($id, $dt, $de);

        $total = (new ActivityProvider($month))->month($id, $dt, $de);


        $userToPrint = User::findOrFail($id);

        $fpdf = new FPDF('p', 'mm', 'A4');
        $fpdf->AddPage();

        $fpdf->SetFont('Arial', 'B',  14);

        // start first page
        $fpdf->Cell(189, 35, '', 0, 1);

        $fpdf->Cell(189, 5, 'Rapportino ore da convalidare dal responsabile', 0, 1, 'C');
        $fpdf->Cell(189, 20, '', 0, 1);


        $fpdf->SetFont('Arial', '', 12);
        $fpdf->Cell(32, 5 , '', 0);
        $fpdf->Cell(47, 5, 'Mese di riferimento', 0);
        $fpdf->Cell(47, 5 , '', 0);
        $fpdf->Cell(47, 5, $month, 0, 1);

        $fpdf->Cell(32, 5, '', 0, 0);
        $fpdf->Cell(47, 5, 'Risors', 0);
        $fpdf->Cell(47, 5, '', 0, 0);
        $fpdf->Cell(47, 5, $userToPrint['name'], 0, 1);

        $fpdf->Cell(189, 15, '', 0, 1);

        $fpdf->Cell(189, 5, 'Di seguito vengaono riassunte le ore dedicate per vostra approvazione, in seconda pagina segue ', 0, 1);
        $fpdf->Cell(189, 5, 'il dettaglio delle ore per giorno.', 0, 1);

        $fpdf->Cell(189, 25, '', 0, 1);

        $fpdf->Cell(32, 5, '',0);
        $fpdf->Cell(52, 5, 'Totali', 0);

        $fpdf->Cell(47, 5, 'Ore Lav.', 0);
        $fpdf->Cell(47, 5, 'Giornate Lav.', 0 , 1);
        $fpdf->Cell(32, 5, '',0);
        $fpdf->Cell(52, 5, 'Tot. Ordinario', 0);

        $fpdf->Cell(47, 5, $total[0], 0);
        $fpdf->Cell(47, 5, $total[0]/8, 0, 1);

        $fpdf->Cell(189, 25, '', 0, 1);

        $fpdf->Cell(38, 5, '', 0);
        $fpdf->Cell(38, 5, 'Data', 0);
        $fpdf->Cell(38, 5, '', 0);
        $fpdf->Cell(38, 5, 'Firma' , 0, 1);
        $fpdf->Cell(38, 15, '', 0);
        $fpdf->Cell(38, 15, '_____________', 0);
        $fpdf->Cell(38, 15, '', 0);
        $fpdf->Cell(38, 15, '_____________' , 0, 1);

        $fpdf->Cell(189, 89, '', 0, 1);
        // end of first page

        // start second page
        $fpdf->Cell(189, 5, '', 0, 1);
        $fpdf->Cell(189, 5, 'Riassunto ore lavorate per giorno', 0, 1);
        $fpdf->Cell(189, 5, '', 0, 1);
        $fpdf->Cell(189, 5, 'Leggenda: R=Reperibilita\', S=Straordinario, N=Notturno, F=Festivo', 0,1, 'C');
        $fpdf->Cell(189, 10, '', 0,1);

        $fpdf->Cell(30, 8, '', 0);
        $fpdf->Cell(40, 8, 'Mese', 1, 0, 'C');
        $fpdf->Cell(30, 8, 'Giorno', 1, 0, 'C');
        $fpdf->Cell(20, 8, 'Ore', 1, 0 , 'C');
        $fpdf->Cell(40, 8, 'Attivita\'', 1, 1, 'C');
        foreach($data as $p)
        {
//            $t = $p->title;
            $g = \Carbon\Carbon::create($p->month);
//            $len = strlen($p->title);
            $fpdf->Cell(30, 8, '', 0);

            $fpdf->Cell(40, 8, $p->month, 'LR', 0, 'C');

            $fpdf->Cell(30, 8, $g->englishDayOfWeek, 'LR', 0, 'C');

            $fpdf->Cell(20, 8, $p->hour, 'LR',0, 'C');

//            $txt = str_split($t, 20);
            $fpdf->Cell(40, 8, '', 'LR', 1, 'C');

//            if($len > 20){
//                for($i=1 ; $i< $len/20 ; $i++){
//                    $fpdf->Cell(30, 8, '', 0);
//                    $fpdf->Cell(40, 8, '', 'LR' , 0);
//                    $fpdf->Cell(30, 8, '', 'LR' , 0);
//                    $fpdf->Cell(20, 8, '', 'LR' , 0);
//                    $fpdf->Cell(40, 8, $txt[$i], 'LR', 1);
//                }
//            }
        }
        $fpdf->Cell(30, 8, '', 0,0);
        $fpdf->Cell(130, 8, '', 'T', 0);

        return $fpdf;
    }

    public static function show($id)
    {
        $dt = \Carbon\Carbon::now();
        $allFerie = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as month"),
        ])->where('ferie', '=' , true)->where('user_id' , '=', $id)->orderBy('start')->get();

        $user = User::findOrFail($id);

        $fpdf = new FPDF('p', 'mm', 'A4');
        $fpdf->AddPage();

        $fpdf->SetFont('Arial', 'B',  14);

        // start page
        $fpdf->Cell(189, 35, '', 0, 1);

        $fpdf->Cell(189, 5, 'Rapporto dei prossimi Ferie', 0, 1, 'C');
        $fpdf->Cell(189, 20, '', 0, 1);


        $fpdf->Cell(28, 5, '',0);
        $fpdf->Cell(52, 5, 'Date di domanda', 0);

        $fpdf->Cell(47, 5, '', 0);
        $fpdf->Cell(47, 5, $dt, 0 , 1);

        $fpdf->Cell(28, 5, '',0);
        $fpdf->Cell(52, 5, 'Staff', 0);

        $fpdf->Cell(47, 5, '', 0);
        $fpdf->Cell(47, 5, $user->name, 0 , 1);
        $fpdf->Cell(189, 35, '',0, 1);

        $fpdf->Cell(50, 8, '', 0);
        $fpdf->Cell(40, 8, 'Mese', 1, 0, 'C');
        $fpdf->Cell(30, 8, 'Giorno', 1, 1, 'C');

        foreach($allFerie as $p)
        {

            $g = \Carbon\Carbon::create($p->month);

            $fpdf->Cell(50, 8, '', 0);

            $fpdf->Cell(40, 8, $p->month, 'LR', 0, 'C');

            $fpdf->Cell(30, 8, $g->englishDayOfWeek, 'LR', 1, 'C');

        }
        $fpdf->Cell(50, 8, '', 0,0);
        $fpdf->Cell(70, 30, '', 'T', 1);

        $fpdf->Cell(38, 5, '', 0);
        $fpdf->Cell(38, 5, 'Data', 0);
        $fpdf->Cell(38, 5, '', 0);
        $fpdf->Cell(38, 5, 'Firma' , 0, 1);
        $fpdf->Cell(38, 15, '', 0);
        $fpdf->Cell(38, 15, '_____________', 0);
        $fpdf->Cell(38, 15, '', 0);
        $fpdf->Cell(38, 15, '_____________' , 0, 1);

        return $fpdf;
    }

    public static function index()
    {
        $dt = \Carbon\Carbon::now();
        $allFerie = Event::select([
            \DB::raw("DATE_FORMAT(start, '%Y-%m-%d') as month"),
        ])->where('ferie', '=' , true)->where('start', '>', $dt)->orderBy('start')->get();

        $fpdf = new FPDF('p', 'mm', 'A4');
        $fpdf->AddPage();

        $fpdf->SetFont('Arial', 'B',  14);

        $fpdf->Cell(189, 35, '', 0, 1);

        $fpdf->Cell(189, 5, 'Rapporto dei prossimi Ferie', 0, 1, 'C');
        $fpdf->Cell(189, 20, '', 0, 1);


        $fpdf->Cell(28, 5, '',0);
        $fpdf->Cell(52, 5, 'Date di domanda', 0);

        $fpdf->Cell(47, 5, '', 0);
        $fpdf->Cell(47, 5, $dt, 0 , 1);
        $fpdf->Cell(189, 35, '',0, 1);

        $fpdf->Cell(50, 8, '', 0);
        $fpdf->Cell(40, 8, 'Mese', 1, 0, 'C');
        $fpdf->Cell(30, 8, 'Giorno', 1, 1, 'C');

        foreach($allFerie as $p)
        {

            $g = \Carbon\Carbon::create($p->month);

            $fpdf->Cell(50, 8, '', 0);

            $fpdf->Cell(40, 8, $p->month, 'LR', 0, 'C');

            $fpdf->Cell(30, 8, $g->englishDayOfWeek, 'LR', 1, 'C');

        }
        $fpdf->Cell(50, 8, '', 0,0);
        $fpdf->Cell(70, 30, '', 'T', 1);

        $fpdf->Cell(38, 5, '', 0);
        $fpdf->Cell(38, 5, 'Data', 0);
        $fpdf->Cell(38, 5, '', 0);
        $fpdf->Cell(38, 5, 'Firma' , 0, 1);
        $fpdf->Cell(38, 15, '', 0);
        $fpdf->Cell(38, 15, '_____________', 0);
        $fpdf->Cell(38, 15, '', 0);
        $fpdf->Cell(38, 15, '_____________' , 0, 1);

        return $fpdf;
    }

    public static function edit($id)
    {
        $dt = \Carbon\Carbon::now();
        $dt->month = 1;
        $dt->day = 1;

        $de = \Carbon\Carbon::now();
        $de->month = 12;
        $de->day = 31;


        $allFerie = Event::select('start')->where('ferie', 1)->where('start', '>=', $dt)->where('user_id', $id)->orderBy('start')->get();

        $len = Event::where('ferie', 1)->where('start', '>=', $dt)->where('user_id', $id)->count('start');
        $name = User::findOrFail($id);

        $fpdf = new FPDF('l', 'mm', 'A4');
        $fpdf->AddPage();

        $fpdf->SetFont('Arial', 'B',  14);

        $fpdf->Cell(275, 15, '', 0,1);
        $fpdf->Cell(275, 20, $name->name , 0, 1, 'C');
        $fpdf->Cell(150, 10, 'ALL FERIE FOR ', 0, 0, 'R');
        $fpdf->Cell(125.5, 10, $dt->year, 0, 1, 'L');
        $fpdf->Cell(275, 10, '', 0, 1);


        $fpdf->SetFont('Arial', '',  14);
        $fpdf->SetFillColor(180,180,255);
        $fpdf->SetDrawColor(50,50,50);
        $month = 1;
        $countFerie = 0;

        while($dt <= $de) {
            $fpdf->Cell(27, 10, $dt->englishMonth, 1, 0, 'C');

                while ($month == $dt->month) {

                    if($len > $countFerie && $allFerie[$countFerie]->start == $dt->toDateString()){

                        $fpdf->Cell(8, 10, $dt->day, 1, 0, 'C', true);
                        $countFerie++;
                    }else{
                        $fpdf->Cell(8, 10, $dt->day, 1, 0, 'C');
                    }
                    $dt->addDay();
                }
                $month++;
                $fpdf->Cell(8, 10, '', 0, 1);
        }
        return $fpdf;
    }
}
