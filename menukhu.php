<?php
require('lib/GENERAL.php');
$general = new GENERAL($conn);
?>


<style>
.top1.navbar li a, .top1.navbar .dropdown-btn, .top1.navbar .dropdown-container li a{
    color:#fff
}
</style>
<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"><?php echo $_SESSION['TenTrungTam']; ?></a> 
    </div>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
<?php 
    $khu = $general->getKhu();
    foreach($khu as $r1)
    {
?>
    <li style="list-style-type: none;" class="li-level1">
        <a class="menu-level1" href="home.php?makhu=<?php echo $r1['MaKhu']; ?>"><i class="fa fa-home nav_icon"></i><?php echo $r1['MoTa']; ?></a>
    </li>
<?php
    }

    
?>          
            <button class="dropdown-btn" data-report="BaoCaoBanHang"><i class="fas fa-address-card"></i> Bán hàng
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Khu 1</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Khu 2</a>
                </li>              
            </div>

            <button class="dropdown-btn" data-report="BaoCaoBieuDo"><i class="fas fa-address-card"></i> Báo cáo Biểu đồ
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Độ phủ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Doanh thu bán hàng</a>
                </li>     
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Doanh thu khách lẻ, thẻ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Khách hàng</a>
                </li>          
            </div>

            <button class="dropdown-btn" data-report="BaoCaoSoLieu"><i class="fas fa-address-card"></i> Báo cáo số liệu
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Doanh thu theo khu</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Doanh thu hàng bán</a>
                </li>     
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Doanh thu khách hàng</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Doanh thu nhân viên</a>
                </li>  
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Báo cáo tồn kho</a>
                </li>        
            </div>

            <button class="dropdown-btn" data-report="BaoCaoHangHoa"><i class="fas fa-address-card"></i> Hàng hóa
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Danh sách nhóm hàng</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Danh sách hàng bán</a>
                </li>  
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Giá bán hàng</a>
                </li>    
            </div>

            <button class="dropdown-btn" data-report="BaoCaoNhapXuat"><i class="fas fa-address-card"></i> Nhập xuất kho
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Phiếu nhập hàng</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Phiếu xuất hàng</a>
                </li>  
            </div>

            <button class="dropdown-btn" data-report="BaoCaoKhachHang"><i class="fas fa-address-card"></i> Khách hàng
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Danh sách khách hàng, thẻ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Danh sách lịch hẹn</a>
                </li>  
            </div>

            <button class="dropdown-btn" data-report="BaoCaoNhanVien"><i class="fas fa-address-card"></i> Nhân viên
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Danh sách nhân viên</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Báo cáo Tour KTV</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=BanHang/Khu1/"><i class="fa fa-apple-alt"></i>
                    Lịch sử ra vào</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa" : "" )?>/tonghop-monan-theongay/index.php"><i class="fa fa-cookie"></i>
                    Tổng hợp chấm công</a>
                </li>
            </div>

            <button class="dropdown-btn" data-report="BaoCaoNhanVien"><i class="fas fa-address-card"></i> Users
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=Users/DanhSachUsers/"><i class="fa fa-apple-alt"></i>
                    Danh sách users</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?>/<?=( !isset($_SERVER['HTTPS']) ? "demospa/" : "" )?>index.php?p=Users/DoiMatKhau/"><i class="fa fa-apple-alt"></i>
                    Đổi mật khẩu</a>
                </li>
            </div>

            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="KTV_list.php"><i class="fa fa-upload nav_icon"></i>QUẢN LÝ KTV</a>
            </li>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="KH_list.php"><i class="fa fa-upload nav_icon"></i>KHÁCH HÀNG</a>
            </li>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="logout.php"><i class="fa fa-sign-out nav_icon"></i>THOÁT</a>
            </li>
        </div>
    </div>
</nav>

<?php

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );

?>

<script>
   // var baoCaoDuocXem ="";
    var baoCaoDuocXem= <?=json_encode($bao_cao_duoc_xem);?>;

    var baoCaoBanHang = $('button[data-report="BaoCaoBanHang"]').attr('data-report');
    var baoCaoBieuDo = $('button[data-report="BaoCaoBieuDo"]').attr('data-report');
    var baoCaoHangHoa = $('button[data-report="BaoCaoHangHoa"]').attr('data-report');
    var baoCaoKhachHang = $('button[data-report="BaoCaoKhachHang"]').attr('data-report');
    var baoCaoNhanVien = $('button[data-report="BaoCaoNhanVien"]').attr('data-report');
    var baoCaoNhapXuat = $('button[data-report="BaoCaoNhapXuat"]').attr('data-report');
    var baoCaoSoLieu = $('button[data-report="BaoCaoSoLieu"]').attr('data-report');

    var admin = '<?=$_SESSION['MaNV']?>';

    var reportArr = []; 
    reportArr = [baoCaoBanHang, baoCaoBieuDo, baoCaoHangHoa, baoCaoKhachHang, baoCaoNhanVien, baoCaoNhapXuat, baoCaoSoLieu];
    console.log(baoCaoDuocXem);

    // return report array not in baoCaoDuocXem
    let hiddenReports = reportArr.filter(function (report) {
            return !baoCaoDuocXem.includes(report);
    });
   // console.log(hiddenReports);
   
    if( admin != 'HDQT' )
    {  
        for ( var i = 0; i < hiddenReports.length; i++ )
        {   

            // $('button[data-report="' + hiddenReports[i] + '"]').css({display:'none'});
            // $('button[data-report="' + hiddenReports[i] + '"] + div.dropdown-container').html('');

        }
    }

</script>