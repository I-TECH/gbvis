<?php

require('classes/pdf2.class.php');


$pdf = new PDF();
// Column headings
$header = array('indicator','County', 'Aggregates');
// Data loading


$data = $pdf->LoadMySQLData("viewcasesreported");
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->CasesReport($header,$data);
$pdf->Output();


?>