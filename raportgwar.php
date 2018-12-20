<?php
////

require_once('view/plugins/config/lang/pol.php');
//require_once('/view/plugins/tcpdf_config.php');
//define("K_TCPDF_EXTERNAL_CONFIG", true);
require_once('view/plugins/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.$_GET['podkladka'];
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'iso-8859-2', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paweł Fabjańczyk');
$pdf->SetTitle('Protokół serwisowy');
$pdf->SetSubject('Naprawa Gwarancyjna');
$pdf->SetKeywords('TCPDF');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(30);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('couriernew', '', 10, '', false);

// add a page
$pdf->AddPage();

// Print a text
//$pdf->writeHTMLCell(80, '', '72', '47', $_GET['Reqes_D'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(125, '', '40', '93', $_GET['nazwa2'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(125, '', '40', '98', $_GET['adrr2'].'  '.$_GET['adrr3'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '40', '102', $_GET['adrr'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '112', '102', $_GET['kod_poczt'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '60', '107', $_GET['nazwa'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '50', '111', $_GET['Cons_Tel1'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '40', '126', $_GET['model'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '126', '126', $_GET['nr_ser'], 0, 0, 0, true, 'J', true);
if($_GET['CRT_Ser'] <> 0){$pdf->writeHTMLCell(80, '', '58', '131', $_GET['CRT_Ser'], 0, 0, 0, true, 'J', true);}
$pdf->writeHTMLCell(125, '', '58', '147', $_GET['Def_Desc'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '71', '220', $_GET['serwisant_name'], 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(80, '', '165', '220', $_GET['id_repair'].'.', 0, 0, 0, true, 'J', true);

//var_dump($_GET);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('raport_gwar.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
