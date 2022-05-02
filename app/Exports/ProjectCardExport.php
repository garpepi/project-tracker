<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Tax_project_cost;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use function PHPUnit\Framework\isEmpty;

class ProjectCardExport implements FromView, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;

    function __construct($id) {
            $this->id = $id;
    }

    public function view(): View
    {
        $project = Project::where('id',$this->id)->first();

        $projectcarddetail = Project::with('contract')->withCount(['actual_payment as actualPay' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->withCount(['project_cost as totalcost' =>
        function($query)
        {
            $query->select(DB::raw('SUM(budget_of_quantity)'));
        }])->where('id',$this->id)->first();

        $invoice = Invoice::with('progress_item.project_cost.suplier','progress_item.project_cost.tax_project_cost','tax_proof','actual_payment')->withCount(['actual_payment as actualPay' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->withCount(['tax_proof as percentagetax' =>
        function($query)
        {
            $query->select(DB::raw('SUM(percentage)'));
        }])->where('project_id',$this->id)->get();


        $taxCost = Tax_project_cost::with('tax')->get();

        return view('projectcard.exports.v_excel', [
            'projects' => $project,
            'invoices' => $invoice,
            'taxCosts' => $taxCost,
            'projectcarddetails' => $projectcarddetail,
        ]);
    }
    public function styles(Worksheet $sheet)
    {

        $invoice = Invoice::with('progress_item.project_cost.suplier','progress_item.project_cost.tax_project_cost','tax_proof','actual_payment')->withCount(['actual_payment as actualPay' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->withCount(['tax_proof as percentagetax' =>
        function($query)
        {
            $query->select(DB::raw('SUM(percentage)'));
        }])->where('project_id',$this->id)->get();

        $count = [];
        // dd($invoice);
        foreach ($invoice as $key => $value) {
            $check = count($value->progress_item->project_cost);
            if ($check != 0) {
                array_push($count, count($value->progress_item->project_cost));
            }else{
                array_push($count, 1);
            }
        }
        $length = array_sum($count) + 1;
        // dd($count);

        for ($i=0; $i < 100; $i++) {
            $sheet->getStyle($i)->getFont()->setSize(10);
        }
        for ($i=0; $i < 100; $i++) {
            $sheet->getStyle($i)->getFont()->setName('arial narrow');
        }
        $sheet->getStyle('A7:U7')->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A8:U8')->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A7:U8')
        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('A7:U8')
        // ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('A7:U8')
        // ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('A7:U8')
        // ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('A7:U8')
        // ->getFill()->getStartColor()->setARGB('0000FF');

        $serBorder = $length + 8;
        for ($i=8; $i < $serBorder; $i++) {
            $sheet->getStyle('C'.$i.':D'.$i)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFADD8E6');
            $sheet->getStyle('C'.$i)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('C'.$i)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('D'.$i)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('D'.$i)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle('N'.$i.':O'.$i)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFADD8E6');
            $sheet->getStyle('N'.$i)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('N'.$i)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('O'.$i)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('O'.$i)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle('U'.$i)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        $sheet->getStyle('A'.$serBorder.':U'.$serBorder)
        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$serBorder.':U'.$serBorder)
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$serBorder.':U'.$serBorder)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        $sheet->getSheetView()->setZoomScale(90);
        // $sheet->getStyle('B7',function($cell){
        //     $cell->setAlignment('center');
        //     });
        // $sheet->getStyle('A8:D8',function($cell){
        //     $cell->setAlignment('center');
        //     $cell->setFontWeight('bold');
        //     });
    }
}

