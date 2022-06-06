<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __invoke(Request $request)
    {
        foreach ($request->allFiles() as $file) {
            $filePath = "files";
            Storage::putFileAs($filePath, $file, 'booking_report.csv');
        }
    }
}
