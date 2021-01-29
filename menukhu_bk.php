<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"><?php echo $tentrungtam; ?></a> 
    </div>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
<?php 
    $l_sql="select a.* from tblDMKhu a Where MaKhu in (Select MaKhu from tblDMBan)";
    $makhu = "";
    if(isset($_SESSION['MaKhu']))
        $makhu = $_SESSION['MaKhu'];
    try
    {
        $rs = $conn->query($l_sql);
        if(($rs) != false)
        {
            foreach($rs as $r1)
            {
                $r1['MoTa'];

                if($makhu == "") $makhu = $r1['MaKhu'];
                //if($makhu == $r1['MaKhu'])
                //{
?>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="home.php?makhu=<?php echo $r1['MaKhu']; ?>"><i class="fa fa-home nav_icon"></i><?php echo $r1['MoTa']; ?></a>
            </li>
<?php
                //}
            }
        }//end if co record
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    $_SESSION['MaKhu']=$makhu;
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