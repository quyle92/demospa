<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();

$makhcu = ""; $makhmoi = ""; $tenkh = ""; $ghichu= ""; $dienthoai =""; $diachi = ""; $manhomkh = "";

if(isset($_POST['makhcu']))
{
  $makhcu = $_POST['makhcu'];
  $makhmoi = $_POST['makhmoi']; 
  $tenkh = $_POST['tenkh'];
  $ghichu = $_POST['ghichu'];
  $dienthoai = $_POST['dienthoai'];
  $diachi = $_POST['diachi'];
  $manhomkh = $_POST['manhomkh'];

  $trungmankh = 0;
  if($makhcu != "")
  {
    if($makhmoi != $makhcu)
    {
      $sql = "Select * from tblDMKHNCC Where MaDoiTuong like '$makhmoi'";
      $rs=sqlsrv_query($conn,$sql);
      if($rs != false)
      {
        while ($r=sqlsrv_fetch_array($rs))
        {
            $trungmakh = 1;
        }
      }
    }
    if($trungmakh == 1)
    {
?> 
    <script> 
    alert('Trùng mã khách hàng, cần chọn mã khác !');
    setTimeout('window.location="KH_list.php"',0);
    </script>
<?php
    }
      //echo "ktv cu:".$maktvcu;
      //echo "ktv moi:".$maktvmoi;
      //echo "ten ktv:".$tenktv;
      //echo "ghi chu:".$ghichu;
      //echo "ten hinh:".$tenhinh;
    $sql = "Update tblDMKHNCC set MaDoiTuong = '$makhmoi', TenDoiTuong = N'$tenkh', GhiChu = N'$ghichu',DienThoai ='$dienthoai',DiaChi = '$diachi',MaNhomKH =N'$manhomkh' Where MaDoiTuong like '$makhcu'";
    $rs=sqlsrv_query($conn,$sql);
  }
  else if($makhcu == "")
  {
    $trungmakh = 0;
    $sql = "Select * from tblDMKHNCC Where MaDoiTuong like '$makhmoi'";
    $rs=sqlsrv_query($conn,$sql);
    if($rs != false)
    {
        while ($r=sqlsrv_fetch_array($rs))
        {
            $trungmakh = 1;
        }
    }
    
    if($trungmakh == 1)
    {
?> 
    <script> 
    alert('Trùng mã khách hàng, cần chọn mã khác !');
    setTimeout('window.location="KH_list.php"',0);
    </script>
<?php
    }
    else
    {
    //
    //------thêm mới
    //
    $sql = "Insert into tblDMKHNCC(MaDoiTuong, TenDoiTuong, MaNhomKH, MaTrungTam, GhiChu, DienThoai,DiaChi) values('$makhmoi',N'$tenkh','$manhomkh','01',N'$ghichu','$dienthoai',N'$diachi')";
    //echo $sql;
    $rs=sqlsrv_query($conn,$sql);
    }
  }
?>
  <script>
        window.onload=function(){
        setTimeout('window.location="KH_list.php"',0);
        }
  </script>
<?php    
}
else
{
?>
<script>
  setTimeout('window.location="KH_list.php"',0);
</script>
<?php
}
?>