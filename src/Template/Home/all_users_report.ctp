<?php

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$helper = new Sample();
if ($helper->isCli()) {
    $helper->log('This example should only be run from a Web Browser' . PHP_EOL);

    return;
}

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('Office 2007 XLSX Test Document')
    ->setSubject('Office 2007 XLSX Test Document')
    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Test result file');

// column spacing
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

// initializing first info row
$j = 1;

// Add some data
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . (string) $j, 'Nome Completo')
    ->setCellValue('B' . (string) $j, 'E-mail')
    ->setCellValue('C' . (string) $j, 'Tipo');

foreach ($users as $report):
  $j++;

  $name = $report->name;
  $email = $report->email;
  $type = "";

  if ($report->person_buyer) {
    $type = $report->person_buyer['type'] == "buyer" ? "Comprador" :"Vendedor";
  } else {
    if ($report->person_seller){
      $type = $report->person_seller['type'] == "seller" ? "Vendedor" :"Comprador";
    }
  }

  $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A' . (string) $j, $name)
      ->setCellValue('B' . (string) $j, $email)
      ->setCellValue('C' . (string) $j, $type);

endforeach;

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Relatório de usuários');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="relatorio_geral_de_usuarios.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('php://output');
exit;
