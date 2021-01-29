<?php
class General extends DB {
    
    public function getKhu(){
       $sql="select MaKhu, MoTa from tblDMKhu a Where MaKhu in (Select MaKhu from tblDMBan)";
        try
        {   
            
            $rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $rs  ;
        }
        catch (PDOException $e) {

            //loi ket noi db -> show exception
            echo $e->getMessage();
        }
    }
    
}

//General::instance();



