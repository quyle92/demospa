<?php

// http://localhost/live/Home/Show/1/2

class Controller_BanHang_Khu2 extends Controller{

    public function getAllData() {

        $this->view("index", [
            "Page"=>$_SESSION['page'],

        ]); 

      
    }


}
?>