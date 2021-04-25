<?php

namespace App\Providers;

use App\Services\Pdf\PdfService;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Google_Client;
use Google_service_Drive;

class GoogleDriveServiceProvider extends ServiceProvider
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
        \Storage::extend("google", function($app, $config){
            $client = new \Google_client;
            $client->setAccessType('offline');
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $service = new \Google_Service_Drive($client);

//            $pdf = PdfService::index()->output();
//            $file = new \Google_Service_Drive_DriveFile();
//            $file->setName('timesheet.pdf');
//            $file->setMimeType('application/pdf');
//            $file->setDescription('a test document');
//
//            $data = file_get_contents('timesheet.pdf');
//            $createdFile = $service->files->create($file, array('data'=> $data, 'mimeType' => 'application/pdf', 'uploadType' => 'multipart'));
//            print_r($createdFile);


            $adapter = new GoogleDriveAdapter($service , $config['folderId']);
            return new Filesystem($adapter);
        });
    }
}
