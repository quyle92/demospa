<?php
require_once('lib/HangHoa.php');
$productCat = new HangHoa($conn);

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

</style>

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
include('add_cat_modal.php');
unset($_SESSION['error']);
?>
<div class="container">
    <div class="row col-md-6 col-md-offset-2 custyle">
        <h3 class="col-md-offset-3">Danh Sách Nhóm Hàng</h3>
        <table class="table table-striped custab">
        <thead>
            <tr><button class="btn btn-primary pull-left" style="margin-bottom: 5px" data-toggle="modal" data-target="#addNewCat"><b>+</b> Add</button>
                <th>Mã</th>
                <th>Tên</th>
                <th class="action"></th>
                <th class="text-center action">Action</th>
                <th class="action"></th>
                <th class="action"></th>
            </tr>
        </thead>
        <?php
        $rs = $productCat->getAllProductCats();
        foreach($rs as $r)
        { ?>
            <tr>
                <td><?=$r['Ma']?></td>
                <td nowrap="nowrap"><?=$r['Ten']?></td>
                <td class="text-center action" colspan="4"><a class="btn btn-info btn-xs " data-toggle="modal" data-target="#editCat_<?=$r['Ma']?>"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="action/delete_action.php?xoaCat=<?=$r['Ma']?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?');"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
            </tr>
         <?php //require_once('edit_cat_modal.php'); 
        } ?>
        </table>
    </div>
</div>
<?php
$cat_list = $productCat->getAllProductCats(); //var_dump($cat_list);die;
foreach ( $cat_list as $r ) 
  { ?>
                              
<!-- Modal Edit Cat -->
<?php
include('edit_cat_modal.php');

?>
  <!-- End Modal Edit Cat -->


<?php } 
unset($_SESSION['fail']);
?>
<script type="text/javascript">

var error = $('div#error');
if( error.length > 0 ){
  $('#addNewCat').modal('show');
}

var catID = '<?=isset($_SESSION['cat_id_edit'] ) ? $_SESSION['cat_id_edit']  : '';?>';
var fail = $('div#fail');
if( fail.length > 0 ){
  $('#editCat_' +  catID).modal('show');
  //$('#editCat_NN001').modal('show');
}

var admin = '<?=isset($_SESSION['MaNV']) ? $_SESSION['MaNV'] : '';?>';
if( admin !== 'HDQT' )
 {
  $('.action').remove();
 }
</script>
