<form action="" method="post" id="occupied-tables">
<?php
require_once('./datetimepicker_all.php');
?>
</form>


<?php
$khu = $general->getKhu();//echo sqlsrv_num_rows($khu);
$i = 0;
foreach ( $khu as $r ) 
{   
    $ma_khu = $r['MaKhu'];
    $ten_khu_raw = $r['MoTa'];
    $ten_khu = stripSpecial(stripUnicode(($r['MoTa'])));

    $file_name = __DIR__ .  './KhuList_Filter/' . $ten_khu . '.php';
    $file_name_ajax =  __DIR__ .  '/KhuList_Filter/ajax/process_' . $ten_khu . '.php';

    if( file_exists($file_name)  )
    {
      unlink($file_name);
    }

    if( !( file_exists($file_name) ) )
    {
      $file_contents = file_get_contents(__DIR__ . "/time_filter_template.php");
      file_put_contents( $file_name , $file_contents );
    }

    if(  file_exists($file_name_ajax) )
    {
      unlink($file_name_ajax);
    }

    if( !( file_exists($file_name_ajax) ) )
    {
      $file_contents = file_get_contents(__DIR__ .  "/KhuList_Filter/ajax/ajax_template.php");
      file_put_contents( $file_name_ajax , $file_contents );
    }

    if( $r['count'] != 1 && $i % 2 === 0 )
    { ?>
       <div class="row loop_start" >
    <?php 
    }   

    include( $file_name );
   
    if( $i % 2 !== 0 && ($i + 1) < count($khu) )
    {?>
      </div>
      <div class="seperator"></div>
    <?php 
    }
    
    $i++;

    if( $i === count($khu) )
    { ?>
      </div>
      <div class=""></div>
    <?php 
    }

} 
?>

<script type="text/javascript">
 
$(function () {
      $('#tungay').datetimepicker({
         format: 'DD/MM/YYYY'
      });

      $('#denngay').datetimepicker({
           format: 'DD/MM/YYYY',
           useCurrent: false //Important! See issue #1075
      });

     $("#tungay").on("dp.change", function (e) {
         $('#denngay').data("DateTimePicker").minDate(e.date.add(1, 'day'));
     });

     $("#denngay").on("dp.change", function (e) {
         $('#tungay').data("DateTimePicker").maxDate(e.date.subtract(1, 'day'));
     });

     $('#tugio').datetimepicker({
          format: 'LT'
     });

     $('#dengio').datetimepicker({
          format: 'LT'
     });

});
</script>
