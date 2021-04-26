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
}
