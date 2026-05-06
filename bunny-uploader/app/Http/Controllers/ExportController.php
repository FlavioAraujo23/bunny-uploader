<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct(private ExportService  $exports) {}
    public function index()
    {
        $videosExporteds = $this->exports->generate();

        return view('export.index', ['videosExported' => $videosExporteds]);
    }
}