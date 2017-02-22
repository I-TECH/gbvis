<?php

require('../classes/pdf.class.php');

$pdf = new PDF();
// Column headings
$header = array('Indicator','County','Aggregates');
// Data loading




$data = $pdf->LoadMySQLData("viewcasesreported");
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->CasesReport($header,$data);
$pdf->Output();


?>