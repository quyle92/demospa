<?php
$page_name = "BaoCaoHangHoa";
require_once('helper/security.php');
require_once('lib/HangHoa.php');
$product = new HangHoa($conn);
?>
<style type="text/css">
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

thead th{
	background-color: #fff;
}

.table thead th:not(:nth-of-type(5)):not(:nth-of-type(6)):not(:nth-of-type(7)) 
{
  border-top: 1px solid #DDDDDD!important;
  border-bottom: 1px solid #DDDDDD!important;
  border-left: 1px solid #DDDDDD;
  border-right: 1px solid #DDDDDD;
}

.table td {
  border-left: 1px solid #DDDDDD;
  border-right: 1px solid #DDDDDD;
  border-top: none!important;
}


td div { 
  width: 48vh; 
  overflow-wrap: break-word; 
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#productList').DataTable();
});
</script>

<?php
if(  isset($_SESSION['add_success']) )
{
    echo "<div class='alert alert-success'>" .
         $_SESSION['add_success']
        . "</div>";
    unset($_SESSION['add_success']); 
}

if(  isset($_SESSION['edit_success']) )
{
    echo "<div class='alert alert-success'>" .
         $_SESSION['edit_success']
        . "</div>";
    unset($_SESSION['edit_success']); 
}

if(  isset($_SESSION['del_success']) )
{
    echo "<div class='alert alert-success'>" .
         $_SESSION['del_success']
        . "</div>";
    unset($_SESSION['del_success']); 
}

if( isset($_SESSION['error']) )
{
  echo "<div id=\"error\"></div>";

}
if( isset($_SESSION['fail']) )
{
  echo "<div id=\"fail\"></div>";

}   
?>
<?php  
include('add_prod_modal.php');
unset($_SESSION['error']);
?>
<div class="container">
    <div class="row col-md-6 custyle">
        <h3>Danh Sách  Hàng Bán</h3>
        <table class="table table-striped custab" id="productList">
        <thead>
            <tr><button class="btn btn-primary pull-left" style="margin-bottom: 5px" data-toggle="modal" data-target="#addNewProd"><b>+</b> Add</button>
                <th>Mã Hàng Bán</th>
                <th>Tên Hàng Bán</th>
                <th>Nhóm Hàng Bán</th>
                <th>Mã DVT</th>
                <th class="text-center">Action</th>
<!--                 <th ></th>
                <th ></th> -->
            </tr>
        </thead>
        <?php
        $rs = $product->getAllProducts();//var_dump($rs);
        foreach($rs as $r)
        { ?>
            <tr>
                <td><?=$r['MaHangBan']?></td>
                <td><div><?=$r['TenHangBan']?></div></td>
                <td><div><?=$r['Ten']?></div></td>
                <td><?=$r['MaDVTCoBan']?></td>
                <td class="text-center" nowrap="nowrap"><a class="btn btn-info btn-xs " data-toggle="modal" data-target="#editProd_<?=( $r['MaHangBan'] =='!KM' ) ? 'khuyenMai' : ( ($r['MaHangBan'] =='!lt') ? 'dichVuKhac' :  $r['MaHangBan'] )?>"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="action/delete_action.php?xoaProd=<?=$r['MaHangBan']?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?');"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
            </tr>
         <?php 
        } ?>
        </table>
    </div>
</div>
<?php
$cat_list = $product->getAllProducts(); //var_dump($cat_list);die;
foreach ( $cat_list as $r ) 
  { ?>
                              
<!-- Modal Edit Cat -->
<?php
include('edit_prod_modal.php');

?>
  <!-- End Modal Edit Cat -->


<?php } 
unset($_SESSION['fail']);
?>
<script type="text/javascript">

var error = $('div#error');
if( error.length > 0 ){
  $('#addNewProd').modal('show');
}

var prodID = '<?=$_SESSION['prod_id_edit']?>';console.log(prodID);
var fail = $('div#fail');
if( fail.length > 0 ){
  $('#editProd_' +  prodID).modal('show');
  //$('#editCat_NN001').modal('show');
}

</script>
