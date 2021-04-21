<?php

namespace App\Providers\Pdf;

use App\Models\Event;
use App\Models\User;
use Crabbly\Fpdf\Fpdf;
use Illuminate\Support\ServiceProvider;

class PdfProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function makePdf($data, $total)
    {

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


        return $this->fpdf->Output();
    }
}
