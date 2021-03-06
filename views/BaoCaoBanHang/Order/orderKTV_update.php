<?php 
@session_start();

$malichsuphieu = ""; $page = "";

if(isset($_GET['page']))
{
  if(isset($_GET['lsp']))
  {
  	$malichsuphieu = $_GET['lsp'];
  	 if($malichsuphieu != "")
  	 {
          if($page == "orderKTV")
          {
?>
<script>
  setTimeout('window.location="orderKTV.php"',0);
</script>
<?php            
          }
	   }
  }
  else
  {
?>
      <script>
        window.onload=function(){
        alert("Cần chọn phòng đang mở để sử dụng chức năng này");
        setTimeout('window.location="home.php"',0);
        }
      </script>
<?php    
  }
}
else
{
?>
<script>
  setTimeout('window.location="home.php"',0);
</script>
<?php
}
?>