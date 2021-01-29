<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"><?=isset($_SESSION['TenTrungTam']) ? $_SESSION['TenTrungTam'] : ""?></a> 
    </div>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
<?php 
    $general = new General();
    $rs = $general->getKhu();

    foreach($rs as $r1)
    {
        $_SESSION['MaKhu'] = $r1['MaKhu'];
?>
    <li style="list-style-type: none;" class="li-level1">
        <a class="menu-level1" href="../../home.php?makhu=<?php echo $r1['MaKhu']; ?>"><i class="fa fa-home nav_icon"></i><?=$r1['MoTa']?></a>
    </li>
<?php
        //}
    }

?>
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