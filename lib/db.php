<?php
ini_set('mssql.charset', 'UTF-8');
function DBConnect()
{
	try
	{
		$conn = new PDO("odbc:Driver={SQL Server}; Server=QDELL\SQLEXPRESS; Port=14330; Database=SPA_SAIGONDEP_BK; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
		$conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
		$conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC );
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$conn->setAttribute( PDO::ODBC_ATTR_ASSUME_UTF8 , true );
		if(!$conn) print_r($conn->errorinfo());
	}
	catch (PDOException $e) {
	  echo $e->getMessage();

	 
	 } 
	 return $conn;
}

DBConnect();
//ref: https://stackoverflow.com/a/47893680/11297747
?>