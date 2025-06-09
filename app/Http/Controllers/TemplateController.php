<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TemplateController extends Controller
{
    public function previewFile(string $file_name)
    {
        $viewPath = 'templates.pdf.' . $file_name;

        if (!View::exists($viewPath)) {
            abort(404, "Template not found");
        }

        $data = [
            'title' => ucfirst($file_name) . ' PDF',
        ];

        $pdf = Pdf::loadView($viewPath, $data);

        return $pdf->stream($file_name . '.pdf');
    }
}
