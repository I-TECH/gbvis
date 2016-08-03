<?php

require('../classes/pdf.class.php');

$pdf = new PDF();
// Column headings
$header = array('Indicator','Aggregates');
// Data loading



$data = $pdf->LoadMySQLData("viewprosecutionsummary");
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();


?>