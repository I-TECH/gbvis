<?php

/*
  An Example PDF Report Using FPDF
  by Matt Doyle

  From "Create Nice-Looking PDFs with PHP and FPDF"
  http://www.elated.com/articles/create-nice-looking-pdfs-php-fpdf/
*/

require_once( "fpdf/fpdf.php" );

require('DB/db.class.php');



// Begin configuration

$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array( 125, 152, 179 );
$tableHeaderTopProductTextColour = array( 0, 0, 0 );
$tableHeaderTopProductFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 213, 170, 170 );
$reportName = "Sample Dashboard Summary";
$reportNameYPos = 160;
$logoFile = "images/negc_logo.jpg";
$logoXPos = 50;
$logoYPos = 108;
$logoWidth = 110;

//$logoFile = "images/negc_logo.jpg";
//$logoXPos = 50;
//$logoYPos = 108;
//$logoWidth = 110;
//$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth,70,'JPG' );




$columnLabels = array( "Milimani","Nakuru","Kisumu");
$rowLabels = array( "No of judges trained in SGBV", "Proportion of convicted cases(%)","Proportion of withdrawn cases(%)", "Average time to resolve(wks)" );
$chartXPos = 20;
$chartYPos = 250;
$chartWidth = 160;
$chartHeight = 80;
$chartXLabel = "Product";
$chartYLabel = "2009 Sales";
$chartYStep = 20000;

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );
				

$result = $conn->fetchrow('SELECT Milimani,Nakuru,Kisumu from sampledata2');


		
$data=$result;

// End configuration


/**
  Create the title page
**/

$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddPage();

// Logo
$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth,70,'JPG' );

// Report Name
$pdf->SetFont( 'Arial', 'B', 24 );
$pdf->Ln( $reportNameYPos );
//$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );


/**
  Create the page header, main heading, and intro text
**/

//$pdf->AddPage();
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'Arial', '', 17 );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 20 );
$pdf->Write( 19, "Background" );
$pdf->Ln( 16 );
$pdf->SetFont( 'Arial', '', 12 );
$pdf->Write( 6, "Currently, one of the greatest obstacles to effective policy-making and monitoring of Gender Based Violence is the fact that relevant information is difficult to obtain and often unavailable at a central point.The cross-sectoral linkages (health, legal, security and psychosocial) are not adequately addressed in the existing data on GBV" );
$pdf->Ln( 12 );
$pdf->Write( 6, "The GBV Is will be used to manage aggregate data at national level. The GBV IS taskforce has identified a set of indicators that can be reported through the GBV " );

$pdf->AddPage();


/**
  Create the table
**/

$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
$pdf->Ln( 15 );

// Create the table header row
$pdf->SetFont( 'Arial', 'B', 15 );

// "PRODUCT" cell
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 90, 12, "INDICATOR", 1, 0, 'L', true );

// Remaining header cells
$pdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );

for ( $i=0; $i<count($columnLabels); $i++ ) {
  $pdf->Cell( 30, 12, $columnLabels[$i], 1, 0, 'C', true );
}

$pdf->Ln( 12 );

// Create the table data rows

$fill = false;
$row = 0;

foreach ( $data as $dataRow ) {

  // Create the left header cell
  $pdf->SetFont( 'Arial', 'B', 15 );
  $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
  $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
  $pdf->Cell( 90, 12, " " . $rowLabels[$row], 1, 0, 'L', $fill );

  // Create the data cells
  $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
  $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
  $pdf->SetFont( 'Arial', '', 15 );

  for ( $i=0; $i<count($columnLabels); $i++ ) {
  
  if( $row==1 ||  $row==2)
  {
      //$pdf->Cell( 30, 12, ($dataRow[$i] ."%" ), 1, 0, 'C', $fill );
	  $pdf->Cell( 30, 12, ($dataRow[$i]), 1, 0, 'C', $fill );
  }
  
  else if( $row==3)
  {
      //$pdf->Cell( 30, 12, ($dataRow[$i] ."wks" ), 1, 0, 'C', $fill );
	   $pdf->Cell( 30, 12, ($dataRow[$i]), 1, 0, 'C', $fill );
  }
    else
	{
    $pdf->Cell( 30, 12, (number_format( $dataRow[$i] ) ), 1, 0, 'C', $fill );
	}
	
  }

  $row++;
  $fill = !$fill;
  $pdf->Ln( 12 );
}



/***
  Serve the PDF
***/

$pdf->Output( "report.pdf", "I" );

?>
