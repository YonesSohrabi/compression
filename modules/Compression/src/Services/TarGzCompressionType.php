<?php

namespace Brief\Compression\Services;

use Brief\Compression\Contracts\CompressionType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class TarGzCompressionType implements CompressionType
{

    public function compression(UploadedFile $file)
    {
        // Store the file temporarily
        $filePath = $file->storeAs('temp', $file->getClientOriginalName());

        $process = new Process(['tar', 'czf', public_path('compressed.tar.gz'), '-C', storage_path('app/' . dirname($filePath)), basename($filePath)]);
        $process->start();

        if (!$process->isSuccessful() && !$process->isRunning()) {
            return false;
        }

        if ($process->isRunning()){
            return 'isRunning';
        }

        return public_path('compressed.tar.gz');

    }
}
