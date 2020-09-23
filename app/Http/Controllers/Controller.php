<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function generate_url(string $file_name, string $mimetypes)
    {
        $date_now = Carbon::now('Asia/Jakarta');
        $one_week = $date_now->add(7, 'day');

        $disk = Storage::disk('minio');
        $getAdapter = $disk->getDriver()->getAdapter();

        if ($disk->exists($file_name)) {

            $command = $getAdapter->getClient()->getCommand('GetObject', [
                'Bucket'    => Config::get('filesystems.disks.minio.bucket'),
                'Key'       => $file_name,
                // 'Key'       => $getAdapter->getPathPrefix().'/images/asd.png',
                // 'ResponseContentDisposition' => 'attachment;'//for download
            ]);

            $request = $getAdapter->getClient()->createPresignedRequest($command, '+7 days');

            $generate_url = $request->getUri();
            $url = urldecode($generate_url);

            $data_generate = [
                'expired'   => $one_week,
                'url'       => $url,
                'file_name' => $file_name,
                'mimetypes' => $mimetypes,
            ];

            return $data_generate;
        }
    }
}
