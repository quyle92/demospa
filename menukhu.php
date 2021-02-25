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
        <a class="navbar-brand"><?=isset($_SESSION['TenTrungTam']) ? $_SESSION['TenTrungTam'] : ""; ?></a> 
    </div>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
         <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoBanHang"><i class="fas fa-store"></i> Bán hàng
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/Dashboard/Home/">
                            <i class="fas fa-landmark"></i>
                       Tầng Trệt</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BanHang/Khu1/">
                            <i class="fas fa-landmark"></i>
                        Khu 1</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BanHang/Khu2/">
                            <i class="fas fa-mosque"></i>
                        Khu 2</a>
                    </li>              
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoBieuDo"><i class="fas fa-chart-area"></i> Báo cáo Biểu đồ
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoBieuDo/DoanhThuBanHang/"><i class="fas fa-chart-pie"></i>
                        Doanh thu bán hàng</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoBieuDo/DoanhThuKhachLeThe/"><i class="fa fa-signal nav_icon"></i>
                        Doanh thu khách lẻ, thẻ </a>
                    </li>     
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoBieuDo/DoPhu/"><i class="fas fa-address-card"></i> 
                        Độ phủ</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoBieuDo/KhachHang/"><i class="fas fa-handshake"></i>
                        Khách hàng</a>
                    </li>          
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoSoLieu"><i class="fas fa-book"></i> Báo cáo số liệu
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoSoLieu/DoanhThuTheoKhu/"><i class="fas fa-chart-area"></i>
                        Doanh thu theo khu</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoSoLieu/DoanhThuHangBan/"><i class="fas fa-shopping-cart"></i>
                        Doanh thu hàng bán</a>
                    </li>     
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoSoLieu/DoanhThuKhachHang/"><i class="fas fa-gopuram"></i>
                        Doanh thu khách hàng</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoSoLieu/DoanhThuNhanVien/"><i class="fas fa-male"></i>
                        Doanh thu nhân viên</a>
                    </li>  
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/BaoCaoSoLieu/BaoCaoTonKho/"><i class="fas fa-warehouse"></i>
                        Báo cáo tồn kho</a>
                    </li>        
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoHangHoa"><i class="fas fa-box-open"></i> Hàng hóa
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/HangHoa/DanhSachNhomHang/"><i class="fas fa-th-list"></i>
                        Danh sách nhóm hàng</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/HangHoa/DanhSachHangBan/"><i class="fas fa-list-alt"></i>
                        Danh sách hàng bán</a>
                    </li>  
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoNhapXuat"><i class="fas fa-truck"></i> Nhập xuất kho
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/NhapXuatKho/PhieuNhapHang/"><i class="fas fa-file-invoice"></i>
                        Phiếu nhập hàng</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/NhapXuatKho/PhieuXuatHang/"><i class="fas fa-file-alt"></i>
                        Phiếu xuất hàng</a>
                    </li>  
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoKhachHang"><i class="far fa-handshake"></i> Khách hàng
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/KhachHang/DanhSachKhachHangThe/"><i class="fab fa-cc-visa"></i>
                        Danh sách khách hàng, thẻ</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/KhachHang/DanhSachLichHen/"><i class="fas fa-calendar-check"></i> 
                        Danh sách lịch hẹn</a>
                    </li>  
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoNhanVien"><i class="fas fa-address-card"></i> Nhân viên
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/NhanVien/DanhSachNhanVien/"><i class="fas fa-fingerprint"></i> 
                        Danh sách nhân viên</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/NhanVien/BaoCaoTourKTV/"><i class="fas fa-book-open"></i>
                        Báo cáo Tour KTV</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/NhanVien/LichSuRaVao/"><i class="fas fa-door-open"></i> 
                        Lịch sử ra vào</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/NhanVien/TongHopChamCong/"><i class="fas fa-notes-medical"></i>
                        Tổng hợp chấm công</a>
                    </li>
                </ul>
            </div>

            <div class="menu_item">
                <button class="dropdown-btn" data-report="BaoCaoNhanVien"><i class="fas fa-address-card"></i> Users
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-container">
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/Users/DanhSachUsers/"><i class="fa fa-apple-alt"></i>
                        Danh sách users</a>
                    </li>
                    <li style="list-style-type: none;">
                        <a class="menu-level2" href="<?=BASE_URL?>views/Users/DoiMatKhau/"><i class="fa fa-apple-alt"></i>
                        Đổi mật khẩu</a>
                    </li>
                </ul>
            </div>

            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="<?=BASE_URL?>KTV_list.php"><i class="fa fa-upload nav_icon"></i>QUẢN LÝ KTV</a>
            </li>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="<?=BASE_URL?>KH_list.php"><i class="fa fa-upload nav_icon"></i>KHÁCH HÀNG</a>
            </li>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="<?=BASE_URL?>logout.php"><i class="fa fa-sign-out nav_icon"></i>THOÁT</a>
            </li>
        </div>
    </div>
</nav>

<?php

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );

?>

<script>
   // var baoCaoDuocXem ="";
    var baoCaoDuocXem = <?=json_encode($bao_cao_duoc_xem);?>;
    if (baoCaoDuocXem.lenth < 1)  baoCaoDuocXem = [];

    var baoCaoBanHang = $('button[data-report="BaoCaoBanHang"]').attr('data-report');
    var baoCaoBieuDo = $('button[data-report="BaoCaoBieuDo"]').attr('data-report');
    var baoCaoHangHoa = $('button[data-report="BaoCaoHangHoa"]').attr('data-report');
    var baoCaoKhachHang = $('button[data-report="BaoCaoKhachHang"]').attr('data-report');
    var baoCaoNhanVien = $('button[data-report="BaoCaoNhanVien"]').attr('data-report');
    var baoCaoNhapXuat = $('button[data-report="BaoCaoNhapXuat"]').attr('data-report');
    var baoCaoSoLieu = $('button[data-report="BaoCaoSoLieu"]').attr('data-report');

    var admin = '<?=isset($_SESSION['MaNV']) ? $_SESSION['MaNV'] : '';?>';

    var reportArr = []; 
    reportArr = [baoCaoBanHang, baoCaoBieuDo, baoCaoHangHoa, baoCaoKhachHang, baoCaoNhanVien, baoCaoNhapXuat, baoCaoSoLieu];
    //console.log(baoCaoDuocXem);

    // return report array not in baoCaoDuocXem
    let hiddenReports = reportArr.filter(function (report) {
            return !baoCaoDuocXem.includes(report);
    });
    //ref:https://flaviocopes.com/how-to-remove-item-from-array/
   
    if( admin != 'HDQT' )
    {  
        for ( var i = 0; i < hiddenReports.length; i++ )
        {   

            $('button[data-report="' + hiddenReports[i] + '"]').css({display:'none'});
            $('button[data-report="' + hiddenReports[i] + '"] + div.dropdown-container').html('');

        }
    }

</script>

<script>
$(document).ready( function() {

        $(document).on('click', '.menu_item' , function(){  
       // $(".menu_item").on('click', function() {// cái này mà để theo event propagation sẽ ko toggle đc vì kẹt     
           // console.log($(this).find('ul.dropdown-container'));     
            $(this).find('ul.dropdown-container').toggle();
        });

        // Get current page and set current in nav
        var path = location.href ;//console.log( 'path: ' + path);

        $(".navbar-default.sidebar .sidebar-nav ul > li").each(function() {//alert(11);
          let navItem = $(this);
          
          let href  = navItem.find("a").attr("href");//console.log('href: '+ href);

          if ( path == href ) {
            //navItem.addClass("active");
            navItem.parent().css({display:'block'});
            navItem.css({background:'green'});
            navItem.find("a").css({color:'#fff'});
          }

        });

        $(".navbar-default.sidebar li.li-level1").each(function() {//alert(11);
          let navItem = $(this);//console.log('navItem: '+ navItem);
          
          let href  = navItem.find("a").attr("href");//console.log('href: '+ href);

          if ( path == href ) {
            //navItem.addClass("active");
            navItem.parent().css({display:'block'});
            navItem.css({background:'green'});
            navItem.find("a").css({color:'#fff'});
          }

        });



         $("ul.dropdown-container ").on('click', function(e) {
              e.stopPropagation(); 
                
        });

  });

</script>