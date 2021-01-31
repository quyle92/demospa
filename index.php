<?php 
require('lib/db.php');
session_start();
date_default_timezone_set('Asia/Bangkok'); 
//$p = $_SERVER['REQUEST_URI'];var_dump($p);
if( isset($_GET["p"]) ){
    $p = $_GET["p"];
}


?>
<!DOCTYPE HTML>
<html>
<head>
<title>Điều tour KTV</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa-Clinic ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- Custom CSS -->
<link href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/css/style1.css" rel='stylesheet' type='text/css' />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet"> 
<link href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<!-- DataTable plugin --> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<!-- Custom JavaScript -->
<script src="js/custom.js"></script>

<!-- iOS toggle -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(document).ready(function () {
    // $.noConflict();
    //   $('select').selectize({
    //       sortField: 'text'
    //   });

  });
</script>
<style> 
.form-group label[for="vip"] + div {
  left: 80px;
}
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
/*.active {
  background-color: green;
  color: white;
}*/

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 12px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/

#myDIV {
    margin: 10px; /*original: 25px */
    width: 100%; /*original: 550px */
    background: orange;
    position: relative;
    font-size: 20px; /*original: 20px */
    text-align: center;
    -webkit-animation: mymove 3s infinite; /* Chrome, Safari, Opera 4s */
    animation: mymove 3s infinite;
}

@media (min-width:768px){   
.titledieutour {
  font-size: 2em;
    }
}

/* Chrome, Safari, Opera from {top: 0px;}
    to {top: 200px;}*/
@-webkit-keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

@keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}



/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.nhomhb_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
    }

    .nhomhb {
    background: #A9FFD0; /*#0073aa;*/
    color: #000; /* #fff;*/
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
    }

.hangban_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
    }

    .hangban {
    background: #0073aa;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
    }

#page-wrapper {
    margin: 0 0 0 250px !important;
}

aside.floating {
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999999;
    background-color: #395ca3;
    -webkit-box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    -moz-box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    font-size: 1.2em;
}
.cover {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}
aside.floating section.chatus, aside.floating section.inside > a {
    float: left;
    border-right: 1px dotted #ccc;
    vertical-align: middle;
    color: #fff;
    text-align: center;
    width: 20%;
    padding: 15px 0;
    cursor: pointer;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    position: relative;
}
aside.floating section.inside > a {
    font-size: 1em;
}

/*quy css*/
@media (min-width:1024px){
  .col-md-8 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr !important;
    box-sizing: border-box;
    grid-row-gap: 7px;
  }
}

@media (min-width:600px) and (max-width: 1024px) {
   .col-md-8 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr !important;
    box-sizing: border-box;
    grid-row-gap: 7px;
  }
}

@media (max-width:600px){
   .col-md-8 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr !important;
    box-sizing: border-box;
    grid-row-gap: 5px;
  }
}

</style>
</head>
<body>
<div id="wrapper">
    <?php include 'menukhu.php'; ?>
    <div id="page-wrapper">
        <div class="col-md-12 ">
          <?php 
			require "views/" . $p . "index.php"; 
          ?>
        </div>
    </div>
</div>