<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class FileUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }
}
