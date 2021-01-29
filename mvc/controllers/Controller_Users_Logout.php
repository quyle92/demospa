<?php

// http://localhost/live/Home/Show/1/2

class Controller_Users_Logout extends Controller{

    public function getAllData() 
    {

	    session_start();
        unset($_SESSION['TenSD']);
        unset($_SESSION['MaTrungTam']);
        unset($_SESSION['TenTrungTam']);
        unset($_SESSION['MaKhu']);
        unset($_SESSION['MaLichSuPhieu']);
        unset($_SESSION['MaNhomNhanVien']);
        unset($_SESSION['MaNV']);
        header('location:' .  ( isset($_SERVER['HTTPS']) ? "https://" : "http://" ) . $_SERVER['HTTP_HOST']  . ( ( $_SERVER['SERVER_NAME'] !== 'localhost' ) ? "" : "/demospa" ) .  '/Users/Login/'); 

    }






}
?>