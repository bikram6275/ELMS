<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\EnumeratorAssign\EnumeratorAssign;

class EnumeratorOrganization implements FromView
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;

    }
    public function view(): View
    {
        return view('backend.report.export.enumeratororgexport', [
            'enumerators' => $this->data
        ]);
    }
}
