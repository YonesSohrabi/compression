<?php

namespace Brief\Compression\Services;

use Brief\Compression\Contracts\CompressionType;
use Illuminate\Http\UploadedFile;
use Symfony\Component\Process\Process;

class ZipCompressionType implements CompressionType
{

    public function compression(UploadedFile $file)
    {

        // methood 1 with ZipArchive

//        $zip = new \ZipArchive();
//        $zipFileName = $file->getClientOriginalName() . '.zip';
//        $zip->open(public_path($zipFileName), \ZipArchive::CREATE);
//        $zip->addFile($file->getPathname(), $file->getClientOriginalName());
//        $zip->close();

        $filePath = $file->storeAs('temp', $file->getClientOriginalName());

        $process = new Process(['zip', '-r', public_path('compressed.zip'), basename($filePath)], storage_path('app/' . dirname($filePath)));
        $process->start();

        if (!$process->isSuccessful() && !$process->isRunning()) {
            return false;
        }

        if ($process->isRunning()){
            return 'isRunning';
        }

        return public_path('compressed.zip');

    }
}
