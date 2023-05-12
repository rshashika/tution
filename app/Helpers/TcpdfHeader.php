<?php
namespace App\Helpers;
use App\Company;
use PDF;
class TcpdfHeader extends \TCPDF 
{
    public static  function pdf_header(){

        PDF::setHeaderCallback(function($pdf){
        if($pdf->pageNo() == 1){
        $company=company::first();
            $pdf->setY(10);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 5, $company->name,0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln();
            $pdf->setY(15);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(0, 5,$company->address."   Tel: ".$company->tel1."   Fax: ".$company->fax,0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln();
            $pdf->Cell(0, 5,"Email: ".$company->email,0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln();
            $pdf->SetFont('helvetica', 'B', 8);
        }
    });
    }
    public static  function pdf_header_for_all(){

        PDF::setHeaderCallback(function($pdf){
     
        $company=company::first();
            $pdf->setY(10);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 5, $company->name,0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln();
            $pdf->setY(15);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(0, 5,$company->address."   Tel: ".$company->tel1."   Fax: ".$company->fax,0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln();
            $pdf->Cell(0, 5,"Email: ".$company->email,0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln();
            $pdf->SetFont('helvetica', 'B', 8);
        
    });
    }
    public  static  function pdf_footer(){

        PDF::setFooterCallback(function($pdf) {
         
            $pgWdith=$pdf->getPageWidth();

			$pdf->SetY(-22);
			$y=$pdf->GetY();
			$pdf->line(10,$y,$pgWdith-15,$y);
			$pdf->SetFont('helvetica', '', 8);
			
			$pdf->Cell(40, 5, date('d-m-Y  H:i:s a'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
			$pdf->Cell(100, 5, 'Software by Soft-Master (0812-204130)', 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$pdf->Cell(0, 5, 'Page '.$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

			$count=$pdf->PageNo();
           
    });
    }

    public function HaveMorePages($pdf,$rowcount,$SetTMg=6){
        //work out the number of lines required
           $dimensions = $pdf->getPageDimensions();
           $hasBorder = false; //flag for fringe case
           $startY = $pdf->GetY();
           if ((($startY + $rowcount) + $dimensions['bm']) > ($dimensions['hk'])-10) {
               $pdf->Ln();
               $pdf->SetTopMargin($SetTMg+10);      
               $pdf->AddPage();   
           }          
       }
    //Hasitha
    
}
?>