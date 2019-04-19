<?php
include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
$inputFileType = 'Excel5';
// $inputFileName = 'F:/Datascience/Brownfields/';
$inputFileName=glob('F:/Datascience/Brownfields/*');
foreach ($inputFileName as $file ) { 
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcelReader = $objReader->load($file);

$loadedSheetNames = $objPHPExcelReader->getSheetNames();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcelReader, 'CSV');

foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    $objWriter->setSheetIndex($sheetIndex);
   $output = $objWriter->save($loadedSheetName.'.csv');

}
}

?>