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
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

// initializing first info row
$j = 1;

// Add some data
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . (string) $j, 'Nome do contato')
    ->setCellValue('B' . (string) $j, 'celular')
    ->setCellValue('C' . (string) $j, 'Fixo')
    ->setCellValue('D' . (string) $j, 'E-mail')
    ->setCellValue('E' . (string) $j, 'Nome da empresa')
    ->setCellValue('F' . (string) $j, 'CNPJ')
    ->setCellValue('G' . (string) $j, 'Endereço')
    ->setCellValue('H' . (string) $j, 'Ramo de atividade')
    ->setCellValue('I' . (string) $j, 'Numero de caixas');

foreach ($users as $report):
  $j++;
  ($report->person_buyer->buyer->branch_of_activities == null) ? $branch_of_activities = "" : $branch_of_activities = $report->person_buyer->buyer->branch_of_activities;

  $name = $report->name;
  $celular = mask($report->cellphone, '(##) #####-####');
  $fixo = mask($report->person_buyer['telephone'], '(##) ####-####');
  $email = $report->email;
  $empresa = $report->person_buyer['company_name'];
  $cnpj = mask($report->person_buyer['cnpj'], '##.###.###/####-##');
  $ramoAtividade = "";
  $address = "";

  ($report->person_buyer->addresses[0]['street'] == null) ? "" : $address = $report->person_buyer->addresses[0]['street'];
  ($report->person_buyer->addresses[0]['house_number'] == null) ? "" : $address = $address . ", N° " . $report->person_buyer->addresses[0]['house_number'];
  ($report->person_buyer->addresses[0]['complement'] == null) ? "" : $address = $address . ", " . $report->person_buyer->addresses[0]['complement'];
  ($report->person_buyer->addresses[0]->district['name'] == null) ? "" : $address = $address . ", " . $report->person_buyer->addresses[0]->district['name'];
  ($report->person_buyer->addresses[0]->city['name'] == null) ? "" : $address = $address . ", " . $report->person_buyer->addresses[0]->city['name'];
  ($report->person_buyer->addresses[0]->state['initials'] == null) ? "" : $address = $address . ", " . $report->person_buyer->addresses[0]->state['initials'];
  ($report->person_buyer->addresses[0]['zip_code'] == null) ? "" : $address = $address . ", CEP: " . $report->person_buyer->addresses[0]['zip_code'];

  foreach ($branch_of_activities as $activity):

    $ramoAtividade = ($activity['name'] == null) ? "" : $ramoAtividade . $activity['name'] . ", ";

  endforeach;

  $numeroCaixas = ($report->person_buyer->buyer['number_of_boxes'] == null) ? "" : $report->person_buyer->buyer['number_of_boxes'];

  $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A' . (string) $j, $name)
      ->setCellValue('B' . (string) $j, $celular)
      ->setCellValue('C' . (string) $j, $fixo)
      ->setCellValue('D' . (string) $j, $email)
      ->setCellValue('E' . (string) $j, $empresa)
      ->setCellValue('F' . (string) $j, $cnpj)
      ->setCellValue('G' . (string) $j, $address)
      ->setCellValue('H' . (string) $j, $ramoAtividade)
      ->setCellValue('I' . (string) $j, $numeroCaixas);

endforeach;

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Relatório de compradores');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="relatorio_geral_de_usuarios_compradores.xls"');
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

function mask($val, $mask){
 $maskared = '';
 $k = 0;

 for($i = 0; $i <= strlen($mask)-1; $i++) {
   if($mask[$i] == '#') {
     if(isset($val[$k]))
     $maskared .= $val[$k++];
   } else {
     if(isset($mask[$i]))
     $maskared .= $mask[$i];
   }
 }
 return $maskared;
}
