<?php 
require('lib/db.php');
require('lib/clsKTV.php');
require('lib/General.php');
$general = new General($conn);
require('functions/lichsuphieu.php');
require('helper/custom-functions.php');

@session_start();
$ktv = new clsKTV($conn);
date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['TenSD'])) //------check session nhân viên, ko có thoát ra đăng nhập lại
{
?>
<script>
	setTimeout('window.location="login.php"',0);
</script>
<?php
}

$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
$ngay = date("d");
$thang = date("m");
$nam = date("Y");

$themmoi = 0; $chinhsua = "0"; $xoa = 0; $maktvcu = ""; $tenktv = ""; $ghichu = ""; $tenhinh = ""; $sourcehinh = ""; $mavantay = "";
if(@$_GET['chinhsua'] != null)
{
  $chinhsua = @$_GET['chinhsua'];
}
else 
{
  $chinhsua = "0";
}

if(@$_GET['themmoi'] != null)
{
  $themmoi = @$_GET['themmoi'];
}
else 
{
  $themmoi = 0;
}

if(@$_GET['xoa'] != null)
{
  $xoa = @$_GET['xoa'];
}
else 
{
  $xoa = 0;
}

if(@$_GET['maktv'] != null)
{
  $maktvcu = @$_GET['maktv'];
  //echo $maktvcu;
  if($maktvcu != "")
  {
    $l_sql="select * from tblDMNhanVien a, tblDMNhomNhanVien b Where a.NhomNhanVien = b.Ma and a.MaNV like '$maktvcu'";
    try
    {
      $rs =$conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      foreach($rs as $r)
      {
            $r['MaNV'];
            $r['TenNV'];
            $r['GhiChuNV'];
            $r['HinhAnhTemp'];
            $r['SourceHinhAnh'];
            $r['MaVanTay'];
            $r['GhiChuDichVu'];
            $r['NhomNhanVien'];

            $tenktv = $r['TenNV'];
            $ghichu = $r['GhiChuNV'];
            $tenhinh = $r['HinhAnhTemp'];
            $sourcehinh = $r['SourceHinhAnh'];
            $mavantay = $r['MaVanTay'];
            $ghichudichvu = $r['GhiChuDichVu'];
        }
      }
  
    catch (Exception $e) {
        echo $e->getMessage();
    }
  }
}
else 
{
  $maktvcu = "";
}

if($xoa == 1 && $maktvcu != "")
{
      //----xu ly chuyen ca
      $sql = "Delete from tblDMNhanVien Where MaNV like '$maktvcu'";
      $rs = $conn->query($sql);
      $xoa = 0;
}

if($themmoi == 1)
{
  $maktvcu = "";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>ZinSpa-Quản lý Điều tour Massage</title> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa-massage ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />

<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">

<!-- Font-awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet"> 

<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- DataTable plugin --> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<style> 
  /**
 * Striped table for popup
 */
.custab{
  border: 1px solid #ccc;
  padding: 5px;
  margin: 5% 0;
  box-shadow: 3px 3px 2px #ccc;
  transition: 0.5s;
  }
.custab:hover{
  box-shadow: 3px 3px 0px transparent;
  transition: 0.5s;
  }

/**
 * Striped table for popup
 */
.dataTables_wrapper #ktv_list_filter input{
  width: 21em;
}
.dataTables_wrapper #ktv_list_filter {
  width:50%;
  text-align:center;
  float: left;
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
.active {
  background-color: green;
  color: white;
}

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

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
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

.khu_active {
    background: #F9B703;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.khu {
    background: #0073aa;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.ban_dangchon {
    background: #F9B703;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 150px;
    height: 140px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.ban_cokhach {
	background: #F9B703; /*#FFFF99;  /*#DAFFC0; #DAFFC0;*/
    color: #000;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 150px;
    height: 140px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.ban_trong {
    background: #0073aa;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 150px;
    height: 140px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}
	
/*quy css*/
@media (min-width:1024px){
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 7px;
  }
}

@media (min-width:600px) and (max-width: 1024px) {
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 7px;
  }
}

@media (max-width:600px){
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 5px;
  }
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
    width: 25%;
    padding: 15px 0;
    cursor: pointer;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    position: relative;
}
aside.floating section.inside > a {
    font-size: 1em;
}

/**
 * Fake table
 */
 .Table
{
    display: table;
}
.Heading
{
  display: table-header-group;
  font-weight: bold;
  text-align: center;
  background-color: #ddd;
}
.Row
{
  display: table-row;
}
.Cell
{
  display: table-cell;
  width: 27%;
  border: solid;
  border-width: thin;
  padding: 3px 10px;
  border: 1px solid #999999;
  text-align: center;
}
</style>
</head>
<body>
<div id="wrapper">
	 <?php include 'menukhu.php'; ?>
    <div id="page-wrapper">
      <div class="col-md-12 graphs">
	       <div class="xs">


<div  id="ktv_list_selected">
    <div class="form-group" >
       <div class="col-sm-6 col-md-2">
            <select  class="form-control">
              <option selected="true" disabled="disabled">Chọn Nhóm KTV</option>
              <option value="all">Tất cả</option>
        <?php
        $ktvGroup = $ktv->getKTVGroup();
        foreach($ktvGroup as $r)
        {
        ?>
          <option value="<?=$r['Ten']?>"><?=$r['Ten']?></option>

        <?php
        }
        ?>
           </select>
        </div>
    </div>
</div>
<div  id="ktv_list_tour_order">
    <div class="form-group">
       <div class="col-sm-6 col-md-2">
            <select  class="form-control">
              <option selected="true" disabled="disabled">Chọn thứ tự tour</option>
              <option value = 'all'>Tất cả </option>
							<option value = 1>Có </option>
              <option value = 0>Không </option>
           </select>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1>THÔNG TIN KTV</h1>
    <form action="KTV_update.php" method="post" >
      <p>Mã : </p>
      <p><input type="hidden" name="maktvcu" value="<?php echo @$maktvcu; ?>" style="width:100%;">
      <input type="text" name="maktvmoi" value="<?php echo @$maktvcu; ?>" style="width:100%;"></p>
      <p>Tên : </p>
      <p><input type="text" name="tenktv" value="<?php echo @$tenktv; ?>" style="width:100%;"></p>   
      <p>Thông tin : </p>
      <p><input type="text" name="ghichu" value="<?php echo @$ghichu; ?>" style="width:100%;"></p>     
      <p>Id vân tay : </p>
      <p><input type="text" name="vantay" value="<?php echo @$mavantay; ?>" style="width:100%;"></p>     
      <p>Ghi chú DV : </p>
      <p><input type="text" name="ghichudichvu" value="<?php echo @$ghichudichvu; ?>" style="width:100%;"></p>       
      <p>Tên Hình : </p>
      <p><input type="text" name="tenhinh" value="<?php echo @$tenhinh; ?>" style="width:100%;">
      </p>
      <p style="padding-top:20px;"></p>
      <input type="submit" name="btn_update" value="Cập nhật">
    </form>
  </div>
</div>

<?php
if($chinhsua == "1" || $themmoi == 1)  // co thong tin nhập típ
{
  $chinhsua = "0"; // tắt cờ nhập típ
  $themmoi = 1;
?>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//btn.onclick = function() {
    modal.style.display = "block";
//}

span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<?php
}//end if co danh gia -> hien modal
?>
<div class="row">
</div>
	         <div class="row">
		          <div class="col-md-12">
                <table class="table" id="ktv_list">
                <thead>
                  <tr>
                    <th>Mã</th>           
                    <th>KTV</th>    
                    <th>Nhóm</th>
                    <th>Thứ tự làm</th>
                    <th>Số tour theo lượt</th>
                    <th>Số tour yêu cầu</th>          
                    <th>Giờ vào</th>             
                    <th>Giờ ra</th>              
                    <th>Action</th>             
                  </tr>
            </thead>
            <tbody>
<?php 
$ktv_list = $ktv->getAllKTV();
$ktv_arr = array();

foreach($ktv_list as $r)
{
  $ktv_arr[] = [
          'MaNV' => $r['MaNV'], 
          'TenNV' => $r['TenNV'], 
          'NhomNhanVien' => $r['NhomNhanVien'], 
          'TenNhomNV' => $r['TenNhomNV'], 
          'ThuTuDieuTour' => $r['ThuTuDieuTour'], 
          'GhiChuNV' => $r['GhiChuNV'], 
          //'HinhAnhTemp' => $r['HinhAnhTemp'], 
          'GioBatDau' => $r['GioBatDau'], 
          'GioKetThuc' => $r['GioKetThuc'], 
          'GhiChu' => $r['GhiChu'],
          'MaPhieuDieuTour' => $r['MaPhieuDieuTour'],
          'MaBanPhong' => $r['MaBanPhong'],
          'TenHangBan' => $r['TenHangBan'],
          'GioThucHien' => $r['GioThucHien'],
          'SoLanPhucVu' => $r['SoLanPhucVu'],
          'SoSaoDuocYeuCau' => $r['SoSaoDuocYeuCau']
  ];
}
//var_dump( $ktv_arr[0]['ThuTuDieuTour']);
$manvtemp = "";
$ktv_list =  customizeArrayKTV( $ktv_arr );//var_dump(sizeof($client_list));die;  
foreach( $ktv_list as $ktv )
{
  $manvtemp = $ktv->MaNV.",".$ktv->NhomNhanVien;
?>
          <tr class="success">
              <td><?php echo $ktv->MaNV;?></td>            
              <td><?php echo $ktv->TenNV;?>
              </td>      
              <td><?php echo $ktv->TenNhomNV;?></td>
              <td><?php echo $ktv->ThuTuDieuTour;?></td>
              <td><?php echo $ktv->SoLanPhucVu;?></td>
              <td><?php echo $ktv->SoSaoDuocYeuCau;?></td>
              <td><?=isset($ktv->GioBatDau) ? $ktv->GioBatDau->format('H:i:s') : ""?></td>
              <td><?=isset($ktv->GioKetThuc) ? $ktv->GioKetThuc->format('H:i:s') : ""?></td>
              <td><?php 
              if( $ktv->ThuTuDieuTour > 0 )
                  { ?>
                    <button name="raca" id="raca" style="background-color: red;color:white;width:90px" value="<?=$manvtemp?>">Ra ca</button>
                <?php } else 
                { ?>
                  <button name="vaoca" id="vaoca" style="background-color: green;color: white;width:90px"  value="<?=$manvtemp?>">Vào ca</button>  
                <?php } ?></td>
          </tr>

<div class="modal fade product_view" id="product_view_<?=$ktv->MaNV?>">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
              <h3 class="modal-title">Danh sách tour trong ngày</h3>
          </div>
          <div class="modal-body">
                <div class="container">
                    <div class="row col-md-6 custyle">
                        <div class="Table">
                            <div class="Heading">
                                <div class="Cell"><?php //$i = 0;var_dump($client->GioVao[$i]->format('d/m/Y') );die;?>
                                    <p><strong>Mã Phiếu</strong></p>
                                </div>
                                <div class="Cell">
                                    <p><strong>Giờ Làm</strong></p>
                                </div>
                                <div class="Cell">
                                    <p><strong>Mã Phòng</strong></p>
                                </div>
                                <div class="Cell">
                                    <p><strong>Tên dịch vụ</strong></p>
                                </div>
                            </div>
                            <?php
                            $i = 0;//var_dump($client->GioVao[$i]->format('d/m/Y') );die;
                            foreach( $ktv->MaPhieuDieuTour as $ma_phieu)
                            {
                            ?>
                            <div class="Row">
                                <div class="Cell">
                                    <p><?=$ma_phieu?></p>
                                </div>
                                <div class="Cell">
                                    <p><?=(isset($ktv->GioThucHien[$i])) ? $ktv->GioThucHien[$i]->format('d/m/Y') : ""?> </p>
                                </div>
                                <div class="Cell">
                                    <p> <?=$ktv->MaBanPhong[$i]?></p>
                                </div>
                                <div class="Cell">
                                    <p> <?=$ktv->TenHangBan[$i]?></p>
                                </div>
                            </div>
                            <?php $i++;
                            } ?>
                        </div>
                    </div>
                </div>                    
          </div>
      </div>
  </div>
</div>          
<?php } ?>


<script>
$(document).ready(function() {

  var selectedKTV = $('#ktv_list_selected');
 $('#ktv_list_selected').remove();

 var orderTour = $('#ktv_list_tour_order');
 $('#ktv_list_tour_order').remove();

  $.noConflict();
  function createTable () { 
      $('#ktv_list').DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
         "pageLength": 10,
        "drawCallback": function( settings ) {
           $('#ktv_list_filter').after(selectedKTV);
           $('#ktv_list_selected').after(orderTour);

        } 
      });
  }
  
  createTable();

      $('#ktv_list_selected select').change(function(){

            let selected = $(this);
            var ktv = selected.val();

            let table = $('#ktv_list').DataTable();
            
            if(ktv !== "all")
            {
              table.column(2).search( ktv ).draw();//(1)
              table.on( 'search.dt', function () {//(2)
                 // console.log('Currently applied global search: '+table.search() );
               });
            } 

            if (ktv === "all") 
            {
             
              if ( $('#ktv_list_tour_order select option:selected').val() == 'all')
              {
                  table.destroy();
                  createTable ();
              }
              else
              {   
                  let selectedOrderTour =  $('#ktv_list_tour_order select option:selected').val();
                 
                  if(selectedOrderTour == 0)
                  {
                    let regExSearch  = '^$|^0$' ;//match empty or 0
                      table.columns().search( '' ).columns( 3 ).search( regExSearch, true, false ).order( [ 1, 'desc' ] ).draw();
                  }
                  else if (selectedOrderTour == 1)
                  {
                     let regExSearch  = '[1-9]';
                      table.columns().search( '' ).columns( 3 ).search( regExSearch, true, false ).order( [ 3, 'asc' ] ).draw();
                  }    

              }
            }

        });

       $('#ktv_list_tour_order select').change(function(){//alert($(this).val());

            let selected = $(this);
            let orderTour = parseInt( selected.val() );
            let table = $('#ktv_list').DataTable();

            switch (orderTour){
              case 0:{
                let regExSearch  = '^$|^0$' ;//match empty or 0
                table.column( 3 ).search( regExSearch, true, false ).order( [ 1, 'desc' ] ).draw();
                 break;
              }
              case 1:{
                let regExSearch  = '[1-9]';
                table.column( 3 ).search( regExSearch, true, false ).order( [ 3, 'asc' ] ).draw();
                 break;
              }
              default: {
                
                if ( $('#ktv_list_selected select option:selected').val() == 'all')
                {
                  table.destroy();
                  createTable ();
                }
                else
                {  
                
                  table.columns().search( '' ).columns( 2 ).search( $('#ktv_list_selected select option:selected').val() ).draw();
                }

             }

            }

        });



} );
</script>
              </tbody>
              </table> 
		          </div>
		          <!-- /#col-md-12 -->
	         </div>
	       </div>   
	       <!-- /div class="xs" -->
  	 </div>
	   <!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Nav CSS -->
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" /> 
<script>
var first = true; 

$(document).on("click","#raca", function () {

    if(first)
    {
      $(this).css({"background":"green"});
      $(this).html('Vào ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':0}; 
        $.post(ajaxurl, data, function (response) {
        });
      setTimeout('window.location="KTV_list.php"',0);
    }
    else
    {
      $(this).css({"background":"red"});
      $(this).html('Ra ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':1};
        $.post(ajaxurl, data, function (response) {
        });
        setTimeout('window.location="KTV_list.php"',0);
    }

    first = !first; // Invert `first`
});
</script>
<script>
var first1 = true; 

$(document).on("click","#vaoca", function () {

    if(!first1)
    {
      $(this).css({"background":"green"});
      $(this).html('Vào ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':0};
        $.post(ajaxurl, data, function (response) {
        });

      setTimeout('window.location="KTV_list.php"',0);
    }
    else
    {
      $(this).css({"background":"red"});
      $(this).html('Ra ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':1};
        $.post(ajaxurl, data, function (response) {
        });
      setTimeout('window.location="KTV_list.php"',0);
    }

    first1 = !first1; // Invert `first`
});
</script>
<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */

</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
});
</script>
</body>
</html>

<?php
/**
 * Note
 */
//(1): https://datatables.net/reference/api/draw()
//(2): https://datatables.net/reference/event/search