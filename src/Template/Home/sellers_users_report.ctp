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

// initializing first info row
$j = 1;

// Add some data
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . (string) $j, 'Nome do contato')
    ->setCellValue('B' . (string) $j, 'celular')
    ->setCellValue('C' . (string) $j, 'E-mail')
    ->setCellValue('D' . (string) $j, 'Nome da empresa')
    ->setCellValue('E' . (string) $j, 'CNPJ')
    ->setCellValue('F' . (string) $j, 'Região de atuação')
    ->setCellValue('G' . (string) $j, 'Categorias de produtos')
    ->setCellValue('H' . (string) $j, 'Marcas ou produtos');

foreach ($users as $report):
  $j++;
  //($report->person_seller->seller->product_categories[0]['name'] == null) ? $product_categories = "" : $product_categories = $report->person_seller->seller->product_categories[0]['name'];

  $name = $report->name;
  $celular = mask($report->cellphone, '(##) #####-####');
  $email = $report->email;
  $empresa = $report->person_seller['company_name'];
  $cnpj = mask($report->person_seller['cnpj'], '##.###.###/####-##');
  $regiaoAtuacao = "";
  $categoriasProduto = "";
  $marcasProdutos = "";

  ($report->person_seller->addresses[0]->district['name'] == null) ? "" : $regiaoAtuacao = $report->person_seller->addresses[0]->district['name'];
  ($report->person_seller->addresses[0]->city['name'] == null) ? "" : $regiaoAtuacao = $regiaoAtuacao . ", " . $report->person_seller->addresses[0]->city['name'];
  ($report->person_seller->addresses[0]->state['initials'] == null) ? "" : $regiaoAtuacao = $regiaoAtuacao . ", " . $report->person_seller->addresses[0]->state['initials'];
  ($report->person_seller->addresses[0]->city['name'] == null) ? "" : $regiaoAtuacao = $regiaoAtuacao . ", " . $report->person_seller->addresses[0]->city['name'];

  foreach ($report->person_seller->seller->product_categories as $category):

    $categoriasProduto = ($category['name'] == null) ? "" : $categoriasProduto . $category['name'] . ", ";

  endforeach;

  foreach ($report->person_seller->seller->brands as $brand):

    $marcasProdutos = ($brand['name'] == null) ? "" : $marcasProdutos . $brand['name'] . ", ";

  endforeach;

  $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A' . (string) $j, $name)
      ->setCellValue('B' . (string) $j, $celular)
      ->setCellValue('C' . (string) $j, $email)
      ->setCellValue('D' . (string) $j, $empresa)
      ->setCellValue('E' . (string) $j, $cnpj)
      ->setCellValue('F' . (string) $j, $regiaoAtuacao)
      ->setCellValue('G' . (string) $j, $categoriasProduto)
      ->setCellValue('H' . (string) $j, $marcasProdutos);

endforeach;

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Relatório de vendedores');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="relatorio_usuarios_vendedores.xls"');
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
