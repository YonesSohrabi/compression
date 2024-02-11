<?php

namespace Brief\Compression\Services;

use Brief\Compression\Contracts\CompressionType;
use Illuminate\Http\UploadedFile;
use Symfony\Component\Process\Process;

class SevenZipCompressionType implements CompressionType
{

    public function compression(UploadedFile $file)
    {
        $filePath = $file->storeAs('temp', $file->getClientOriginalName());

        $process = new Process(['7z', 'a', public_path('compressed.7z'), storage_path('app/' . $filePath)]);
        $process->start();

        if (!$process->isSuccessful() && !$process->isRunning()) {
            return false;
        }

        if ($process->isRunning()){
            return 'isRunning';
        }

        echo public_path('compressed.7z');

    }
}
