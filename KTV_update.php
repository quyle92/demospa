<?php 
require('lib/db.php');
require('lib/ORDER_KTV.php');
require('functions/lichsuphieu.php');
@session_start();

$maktvcu = ""; $maktvmoi = ""; $tenktv = ""; $ghichu= ""; $tenhinh =""; $mavantay = ""; $ghichudichvu = "";

if(isset($_POST['maktvcu']))
{
  $maktvcu = $_POST['maktvcu'];
  $maktvmoi = $_POST['maktvmoi']; 
  $tenktv = $_POST['tenktv'];
  $ghichu = $_POST['ghichu'];
  $tenhinh = $_POST['tenhinh'];
  $mavantay = $_POST['vantay'];
  $ghichudichvu = $_POST['ghichudichvu'];

  $trungmanhanvien = 0;
  if($maktvcu != "")
  {
    if($maktvmoi != $maktvcu)
    {
      $sql = "Select * from tblDMNhanVien Where MaNV like '$maktvmoi'";
      $rs=sqlsrv_query($conn,$sql);
      if($rs != false)
      {
        while ($r=sqlsrv_fetch_array($rs))
        {
            $trungmanhanvien = 1;
        }
      }
    }
    if($trungmanhanvien == 1)
    {
?> 
    <script> 
    alert('Trùng mã nhân viên, cần chọn mã khác !');
    setTimeout('window.location="KTV_list.php"',0);
    </script>
<?php
    }
      //echo "ktv cu:".$maktvcu;
      //echo "ktv moi:".$maktvmoi;
      //echo "ten ktv:".$tenktv;
      //echo "ghi chu:".$ghichu;
      //echo "ten hinh:".$tenhinh;
    $sql = "Update tblDMNhanVien set MaNV = '$maktvmoi', TenNV = N'$tenktv', GhiChuNV = N'$ghichu',HinhAnhTemp ='$tenhinh',MaVanTay = '$mavantay',GhiChuDichVu =N'$ghichudichvu' Where MaNV like '$maktvcu'";
    $rs=sqlsrv_query($conn,$sql);
  }
  else if($maktvcu == "")
  {
    $trungmanhanvien = 0;
    $sql = "Select * from tblDMNhanVien Where MaNV like '$maktvmoi'";
    $rs=sqlsrv_query($conn,$sql);
    if($rs != false)
    {
        while ($r=sqlsrv_fetch_array($rs))
        {
            $trungmanhanvien = 1;
        }
    }
    
    if($trungmanhanvien == 1)
    {
?> 
    <script> 
    alert('Trùng mã nhân viên, cần chọn mã khác !');
    setTimeout('window.location="KTV_list.php"',0);
    </script>
<?php
    }
    else
    {
    //
    //------thêm mới
    //
    $sql = "Insert into tblDMNhanVien(MaNV, TenNV, NhomNhanVien, MaTrungTam, GhiChuNV, MaVanTay, GhiChuDichVu, HinhAnhTemp) values('$maktvmoi',N'$tenktv','KTV','01',N'$ghichu','$mavantay',N'$ghichudichvu','$tenhinh')";
    //echo $sql;
    $rs=sqlsrv_query($conn,$sql);
    }
  }
?>
  <script>
        window.onload=function(){
        setTimeout('window.location="KTV_list.php"',0);
        }
  </script>
<?php    
}
else
{
?>
<script>
  setTimeout('window.location="KTV_list.php"',0);
</script>
<?php
}
?>