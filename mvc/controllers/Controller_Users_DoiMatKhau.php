<?php

// http://localhost/live/Home/Show/1/2

class Controller_Users_DoiMatKhau extends Controller{

    public function getAllData() 
    {
        $this->view("index", [
            "Page"=> $_SESSION['page'],
        ]); 
    }

    public function process($user_info){
        $users = $this->model("Model");
        $users->doiMatKhau($user_info);die;
        $this->view("index", [
            "Page"=> $_SESSION['page'],
        ]); 
    }






}
?>