<?php

namespace Brief\Compression\Contracts;

use Illuminate\Http\UploadedFile;

interface CompressionType
{
    public function compression(UploadedFile $file) ;
}
