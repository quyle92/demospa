<?php
ini_set('mssql.charset', 'UTF-8');
class DB {

		protected $conn;

		function __construct() {
			try{
				$this->conn = new PDO("odbc:Driver={SQL Server}; Server=DELL-PC\SQLEXPRESS; Port=14330; Database=SPA_SAIGONDEP; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
				
				$this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
				$this->conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
				$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$this->conn->setAttribute( PDO::ODBC_ATTR_ASSUME_UTF8 , true );
			}
			catch(Exception $e){
                throw new Exception($e->getMessage());   
            }			
		
		}
		


}


?>