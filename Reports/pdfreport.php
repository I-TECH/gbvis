<?php

require('classes/pdfreport.class.php');

$pdf = new PDF();
// Column headings
$header = array('', 'Convicted', 'Prosecuted','Proportion %');
// Data loading




$data = $pdf->LoadMySQLData();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();


?>