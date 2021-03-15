<?php
ini_set('mssql.charset', 'UTF-8');
//require('helper/ForceUTF8/Encoding.php');

// $dbConSMS = new PDO('odbc:Driver={SQL Server}; Server=14.161.35.228; Port=14331; Database=zSMS; TDS_Version=8.0; Client Charset=UTF-8', 'sa', 'P@ssw0rd123');
// $dbCon = new PDO('odbc:Driver={SQL Server}; Server=DELL-PC\SQLEXPRESS; Port=14330; Database=sgDep_Q3; TDS_Version=8.0; Client Charset=UTF-8', 'sa', '123', $opt);
//saigondep, Puor27_1
try
{
	$conn = new PDO("odbc:Driver={SQL Server}; Server=QDELL\SQLEXPRESS; Port=14330; Database=SPA_SAIGONDEP_BK; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
	$conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
	$conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$conn->setAttribute( PDO::ODBC_ATTR_ASSUME_UTF8 , true );
	if(!$conn) print_r($conn->errorinfo());
}
catch (PDOException $e) {
  echo $e->getMessage();

 
 } 


?>