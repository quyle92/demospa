<?php
require('lib/db.php');
require('lib/ORDER_KTV.php');
require('functions/lichsuphieu.php');
$order_ktv = new ORDER_KTV();

@session_start();

date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		//setTimeout('window.location="login.php"',0);
</script>
<?php
}

$id= isset( $_SESSION['MaNV'] ) ?: "";
$tenktv = isset( $_SESSION['TenNV'] ) ?: "";
$trungtam = $_SESSION['TenTrungTam'];
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

?>
<html>
<head>
<title>Điều tour Massage</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý SPA ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<!-- <link href="css/style1.css" rel='stylesheet' type='text/css' /> -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- Search and Select plugin --> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<!-- Toggle: https://www.bootstraptoggle.com/ -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
      /**
       * boostrap toogle
      */
$(document).ready(function () {

	$("input#checkAll").change(function() {
	  if ($(this).is(":checked")) {console.log("on");
	      $('input.pic_item').bootstrapToggle('on');
	  }

	  if (!$(this).is(":checked")) {console.log("off");
	      $('input.pic_item').bootstrapToggle('off');
	  }
	});

	var first = true; 
	$(".img-thumbnail").click(function() {

		if( $(this) && first )
		{
			console.log("on");
			$(this).parent().next().next().find('input.pic_item').bootstrapToggle('on');
		}
		else
		{
			console.log("off");
  			$(this).parent().next().next().find('input.pic_item').bootstrapToggle('off');
		}

		first = !first; // Invert `first`

	});
	


});

</script>
<style>
/*basic settings */

a:focus {
	outline: none !important;
	outline-offset: none !important;
}

body {
	background: #f5f6f5;
	color: #333;
}

/* helper classses */

.margin-top-20 {
	margin-top: 20px;
}

.margin-bottom-20 {
	margin-top: 20px;
}

.no-margin {
	margin: 0px;
}

/* box component */

.box {
	border-color: #e6e6e6;
	background: #FFF;
	border-radius: 6px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
	padding: 10px;
	margin-bottom: 40px;
}

.box-center {
	margin: 20px auto;
}

/* input [type = file]
----------------------------------------------- */

input[type=file] {
	display: block !important;
	right: 1px;
	top: 1px;
	height: 34px;
	opacity: 0;
  width: 100%;
	background: none;
	position: absolute;
  overflow: hidden;
  z-index: 2;
}

.control-fileupload {
	display: block;
	border: 1px solid #d6d7d6;
	background: #FFF;
	border-radius: 4px;
	width: 100%;
	height: 36px;
	line-height: 36px;
	padding: 0px 10px 2px 10px;
  overflow: hidden;
  position: relative;
  
  &:before, input, label {
    cursor: pointer !important;
  }
  /* File upload button */
  &:before {
    /* inherit from boostrap btn styles */
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #cccccc;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    border-bottom-color: #b3b3b3;
    border-radius: 4px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    transition: color 0.2s ease;

    /* add more custom styles*/
    content: 'Browse';
    display: block;
    position: absolute;
    z-index: 1;
    top: 2px;
    right: 2px;
    line-height: 20px;
    text-align: center;
  }
  &:hover, &:focus {
    &:before {
      color: #333333;
      background-color: #e6e6e6;
      color: #333333;
      text-decoration: none;
      background-position: 0 -15px;
      transition: background-position 0.2s ease-out;
    }
  }
  
  label {
    line-height: 24px;
    color: #999999;
    font-size: 14px;
    font-weight: normal;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    position: relative;
    z-index: 1;
    margin-right: 90px;
    margin-bottom: 0px;
    cursor: text;
  }
}

/**
 * Zoom Image On Mouse Over
 */
.item {
	overflow: hidden;
	
}

.item img {
	-webkit-transition: 0.6s ease;
		transition: 0.6s ease;
		
}

.item img:hover {
	-webkit-transform: scale(1.2);
		transform: scale(1.2);

}
.img-thumbnail {
    border:0px;
    border-radius:0px;
}

.form-inline .form-control{
	width: 42%;
}
</style>

<script>
$(function() {
  $('input[type=file]').change(function(){
    var t = $(this).val();
    var labelText = 'File : ' + t.substr(12, t.length);
    $(this).prev('label').text(labelText);
  });


	//$.noConflict();
	 $('select').selectize({
	    sortField: 'text'
	 });
});

</script>
</head>
<body>
<div id="wrapper">
<!-- Navigation -->
	<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand"> <?php echo $trungtam; ?></a>
				</div>

	 </nav>
 <!-- End Navigation -->
 	<div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
		<?php //var_dump($_SESSION['img_response_err'] );
	        if(  !empty( $_SESSION['img_response_err'] )  )
	        {
		        echo "<div class='alert alert-danger'>
		              <strong>{$_SESSION['img_response_err']}
		            </div>";
		        unset($_SESSION['img_response_err']); 
	        }
	        if( !empty( $_SESSION['img_response_success'] ) )
	        {
	        	echo "<div class='alert alert-success'>
		              <strong>{$_SESSION['img_response_success']}
		            </div>";
		        unset($_SESSION['img_response_success']); 
	        }
        ?>
		
<article id="main-content" role="main">  
    <section class="container">
       <div class="row">
	        <div class="col-md-4">
	            <header>
	              <h1>Thêm hình ảnh KTV vào phần bên phải</h1>
	            </header>
	    
	        </div>
		    <div class="col-md-8">
		        <p>&nbsp;</p>
		        <h3 class="text-info">Upload hình KTV</h3>
		        <form action="img-upload/process.php" method="post" enctype="multipart/form-data" class="form form-inline"  role="form">
		        	<div class="row">
		        		<div class="form-group col-md-5">
			        		<label for="select-state">Chọn KTV:</label>
				        	<select id="select-state " placeholder="KTV..." name="ktv" required  class="form-control">
				        		<option disabled selected></option>
				    <?php
				    $sql = "SELECT MaNV,TenNV,SourceHinhAnh FROM tblDMNhanVien Where SourceHinhAnh <> '' and SourceHinhAnh is not null order by MaNV DESC";
				    $rs_h=sqlsrv_query($conn,$sql); 
					while($r=sqlsrv_fetch_array($rs_h))	//-----duyet danh sach ban
					{
					?>
								<option value="<?=$r['MaNV']?>"><?=$r['TenNV']?></option>
					<?php
					}
					?>
							</select>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn-sm btn btn-info" formaction="img-upload/get-current-img.php">Select</button>
						</div>
						<br>
					</div>

					<br>
			        <!--file input example -->
			        <div class="row">
			        	<div class="col-md-9">
			        		 <label for="file">Chọn ảnh:</label>
					        <span class="control-fileupload" class="form-control">
					         	 <label for="file">Chọn ảnh từ máy tính:</label>
					          <input type="file" id="file" name="files[]" multiple  placeholder="Chọn Hình KTV..." >
					        </span>
				   		</div>
				   	</div>
			        <br>
			        <button type="submit" class="btn btn-info" value="UPLOAD" name="submit">Upload</button>
			        <!--./file input example -->
			    </form>
		  	</div>
   		</div>

   	<form action="img-upload/pics-delete.php" method="post">
	    <h2 class="text-center">Hình Ảnh KTV</h2>
	    <!-- <div class="col-md-5"> -->
	    <button type="submit" class="btn btn-danger btn-lg"  name="delete_pics" onclick="return confirm('Bạn có muốn xóa ko?');">
			<i class="fa fa-trash-o"></i>
			<input type="hidden" name="maban" value="<?=$maban;?>" />
		</button>
		<!-- </div> -->
	    <div class="col-md-6">
	    	<input type="checkbox" id="checkAll" data-toggle="toggle" data-size="medium"  data-onstyle="warning"/></div>
	    <hr>
	    <div class="row">
	    	<?php 
	    	if( isset( $_SESSION['maktv'] ) )
	    	{ 
	 			$maktv = $_SESSION['maktv'];
		    	$hinh_ktv = unserialize( $order_ktv->getKTVPicsByID( $maktv ) );//var_dump($hinh_ktv);
		    	?>
		    	<input type="hidden" name="maktv"  value="<?=$maktv?>" />
		    	<?php
		    	foreach( $hinh_ktv as $k => $v )
		    	{ 
		    	?>
			    <div class="col-sm-4">
			        <div class="item"><img src="<?=$v?>" class="img-thumbnail"></div>
			        <figcaption class="figure-caption"><?=basename($v)?></figcaption>
			        <input type="checkbox" class="pic_item" data-toggle="toggle" data-size="medium" name=pic_item[] value="<?=$k?>" data-onstyle="warning" />
				</div>
			<?php }
			}
			?>
	    </div>
	</form>

  </section>
</article>



	</div>   
	<!-- /div class="xs" -->
  	</div>
	<!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>
</html>