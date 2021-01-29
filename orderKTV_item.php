<?php 
@session_start();

if(isset($_POST['danhsachhangban']))
{
  	 $danhsachhangban = $_POST['danhsachhangban'];
  	 $_SESSION['MaHangBan'] = $danhsachhangban[0];
  	 //echo implode(", ", $danhsachhangban);

  	 //if(isset($_SESSION['ThemMonSetMenu']))
  	 //{
  	 //  $_SESSION['ThemMonSetMenu']=$themsetmenu;  //ok
	 //  }
}
?>