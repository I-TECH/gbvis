<?php

require('classes/pdf2.class.php');


$pdf = new PDF();
// Column headings
$header = array('County','County Aggregate','nationalAggregate','countyPercentage');
// Data loading


$data = $pdf->LoadMySQLData();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();


?>