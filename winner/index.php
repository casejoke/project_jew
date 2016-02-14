<?php
error_reporting(E_ALL ^ E_NOTICE);
require __DIR__."/src/PHPExcelReader/SpreadsheetReader.php"; //better use autoloading
use \PHPExcelReader\SpreadsheetReader as Reader;        

$data = new Reader(__DIR__ . "/list_.xls");
$rows = $data->rowcount();
// loop through all rows
for ($i=1; $i <= $rows; $i++) {
  if($data->val($i, 1) == 1){
     print_r('<pre>');
     //print_r("INSERT INTO `oc_contest_winner`(`request_id`, `project_id`, `contest_id`, `contest_type_id`, `customer_id`, `place_id`) VALUES ('0','".$data->val($i, 4)."', '4','3', '".$data->val($i, 8)."',' 1') ; ");
     print_r("INSERT INTO `oc_contest_adaptor`(`project_id`, `contest_id`, `customer_id`, `date_added`) VALUES ('".$data->val($i, 4)."','0','".$data->val($i, 8)."',date_added = NOW()); ");

     
  /*
  print_r($data->val($i, 1).' || ');
  print_r($data->val($i, 2).' || ');
  print_r($data->val($i, 3).' || ');
  print_r($data->val($i, 4).' || ');
  print_r($data->val($i, 5).' || ');
  print_r($data->val($i, 6).' || ');
  print_r($data->val($i, 7).' || ');
  print_r($data->val($i, 8).' || ');*/
  print_r('</pre>');
  }
 
}
?>
