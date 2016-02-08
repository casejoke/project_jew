<?php
error_reporting(E_ALL ^ E_NOTICE);
require __DIR__."/src/PHPExcelReader/SpreadsheetReader.php"; //better use autoloading
use \PHPExcelReader\SpreadsheetReader as Reader;        

$data = new Reader(__DIR__ . "/list.xls");
$rows = $data->rowcount();
 print_r('expression');
// loop through all rows
for ($i=1; $i <= $rows; $i++) {
  
  print_r('<pre>');
  //print_r("INSERT INTO `Data` (`id`, `parent`, `type`, `value`, `target`) VALUES ('".$data->val($i, 1)."', '".$data->val($i, 2)."', '".$data->val($i, 3)."', '".$data->val($i, 4)."', '".$data->val($i, 5)."');");
  print_r($data->val($i, 1).' || ');
  print_r($data->val($i, 2).' || ');
  print_r($data->val($i, 3).' || ');
  print_r($data->val($i, 4).' || ');
  print_r($data->val($i, 5).' || ');
  print_r($data->val($i, 6).' || ');
  print_r('</pre>');
}
?>
