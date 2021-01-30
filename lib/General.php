<?php
class General  {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
	}

	public function getKhu()
	{
		$sql="select a.* from tblDMKhu a Where MaKhu in (Select MaKhu from tblDMBan)";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

}