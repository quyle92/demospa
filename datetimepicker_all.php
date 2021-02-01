<?php
$tungay = date('d-m-Y');
//$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = date('d-m-Y', strtotime('+1 day'));
//$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$tugio =  isset( $_POST['tugio'] ) ? $_POST['tugio'] :"";
if ($tugio == '' || $tugio == null) $tugio = "00:01";

$dengio =  isset( $_POST['dengio'] ) ? $_POST['dengio'] :"";
if ($dengio == '' || $dengio == null) $dengio = "23:00";

?>


  <div class="row">
      	<div class="col-md-2" >Từ ngày: </div>
	        <div class="col-md-3" >
            <div class="form-group">
              <div class='input-group date'>
                 <input type='text'  name="tungay" class="form-control" value="<?=isset($tungay) ? $tungay : ""?>" id="tungay"/>
                 <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                 </span>
              </div>
            </div>
          </div>
	        <div class="col-md-2" >Từ giờ: </div>
            <div class="col-md-3" >
  	          <div class="form-group">
                <div class='input-group date' name="tugio"    value="<?=isset($tugio) ? $tugio : ""?>">
                   <input type='text' class="form-control" id='tugio'/>
                   <span class="input-group-addon">
                   <span class="glyphicon glyphicon-time"></span>
                   </span>
                </div>
              </div>
            </div>
        <div class="col-md-2" ></div>
	</div>
	<div class="row">
      	<div class="col-md-2" >Đến ngày:</div>
	        <div class="col-md-3" >
            <div class="form-group">
              <div class='input-group date'>
                 <input type='text'  name="denngay" class="form-control" value="<?=isset($denngay) ? $denngay : ""?>" id="denngay"/>
                 <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                 </span>
              </div>
            </div>
          </div>
	        <div class="col-md-2" >Đến giờ: </div>
	        <div class="col-md-3" >
              <div class="form-group">
                <div class='input-group date' name="dengio"  value="<?=isset($dengio) ? $dengio : ""?>">
                   <input type='text' class="form-control"  id='dengio' />
                   <span class="input-group-addon">
                   <span class="glyphicon glyphicon-time"></span>
                   </span>
                </div>
              </div>
            </div>
        <div class="col-md-2" ><button type="submit" class="btn btn-primary">Lọc</button></div>
	</div>


