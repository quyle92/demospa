<?php
//require_once('helper/security.php');
require_once('lib/HangHoa.php');
$productCat = new HangHoa($conn);
if ( isset($_POST['cat_add_new']) )
{
	$newCat = $productCat->addNewCat($_POST);
}



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



<h3 class="title">Danh Sách Nhóm Hàng</h3>
<?php
if(  isset($_SESSION['delete_success']) && $_SESSION['delete_success'] == 1 ) 
    {
     echo "<div class='alert alert-success'>
          <strong>Success!</strong> Category name deleted successfully...
    </div>";unset($_SESSION['delete_success']);  var_dump($_SESSION['delete_success']);
    }
elseif(  isset($_SESSION['duplicate_cat_name']) && $_SESSION['duplicate_cat_name'] == -1 ) 
    {
     echo "<div class='alert alert-danger'>
          <strong>Alert!</strong> Something went wrong! Category name could not be deleted...
    </div>";unset($_SESSION['duplicate_cat_name']);
    }

if(  isset($_SESSION['duplicate_cat_id']) && $_SESSION['duplicate_cat_id'] == -1 ) 
    {
     echo "<div class='alert alert-warning'>
          <strong>Alert!</strong> Category ID already existed...
    </div>";unset($_SESSION['duplicate_cat_id']); 
    }

elseif(  isset($_SESSION['duplicate_cat_name']) && $_SESSION['duplicate_cat_name'] == -1 ) 
    {
     echo "<div class='alert alert-warning'>
          <strong>Alert!</strong> Category name already existed...
    </div>";unset($_SESSION['duplicate_cat_name']);
    }
elseif(  isset($_SESSION['add_success']) && $_SESSION['add_success'] == 1 )
    {
    echo "<div class='alert alert-success'>
          <strong>Success!</strong> Add category name successfully...
        </div>";unset($_SESSION['add_success']); 
    }
?>
<div class="container">
    <div class="row col-md-6 col-md-offset-2 custyle">
    <table class="table table-striped custab">
    <thead>
        <tr><button class="btn btn-primary pull-left" style="margin-bottom: 5px" data-toggle="modal" data-target="#new_cat"><b>+</b> Add</button>
            <th>Mã</th>
            <th>Tên</th>
            <th ></th>
            <th class="text-center">Action</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <?php
    $rs = $productCat->getAllProductCats();
    foreach($rs as $r)
    { ?>
        <tr>
            <td><?=$r['Ma']?></td>
            <td nowrap="nowrap"><?=$r['Ten']?></td>
            <td class="text-center" colspan="4"><a class="btn btn-info btn-xs " href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="<?=BASE_URL?>views/<?=$p?>XoaCat/index.php?xoaCat=<?=$r['Ma']?>" class="btn btn-danger btn-xs "><span class="glyphicon glyphicon-remove"></span> Del</a></td>
        </tr>
     <?php } ?>
    </table>
    <?php require_once('new_cat.php');?>
    </div>
</div>