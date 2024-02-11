<?php

namespace Brief\Compression\Http\Controller;

use App\Http\Controllers\Controller;
use Brief\Compression\Contracts\CompressionType;
use Illuminate\Http\Request;


class CompressionController extends Controller
{
    public function store(Request $request, CompressionType $compression)
    {

        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                    'status' => 'false',
                    'data' => null,
                    'message' => 'Invalid file.'
                ]
                , 400);
        }
        $compressionResult = $compression->compression($file);

        if (!$compressionResult){
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'compression faild'
            ], 500);
        }

        if ($compressionResult == 'isRunning'){
            return response()->json([
                'status' => true,
                'data' => null,
                'message' => 'compression is running'
            ], 202);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'link' => $compressionResult
            ],
            'message' => 'compression done'
        ],200);
    }
}
