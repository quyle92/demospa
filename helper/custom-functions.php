<?php
define('BASE_URL', ( isset($_SERVER['HTTPS']) ? "https://" : "http://" ) . $_SERVER['SERVER_NAME'] . ( !isset($_SERVER['HTTPS']) ? "/demospa/" : "" ));

function stripSpecial($str){
    if ( strpos($str,"/" )  !== FALSE )  $str = str_replace('/',"_",$str);
    if ( strpos($str,"-" )  !== FALSE )  $str = str_replace('-',"_",$str);
    $arr = array(",","$","!","?","&","'",'"',"+", "(", ")");
    $str = str_replace($arr,"",$str);
    $str = trim($str);
   while (strpos($str,"  ")>0) $str = str_replace("  "," ",$str);
    $str = str_replace(" ","_",$str);
    return $str;
}

function stripUnicode($str){
    if(!$str) return false;
    $unicode = array(
     'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
     'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
     'd'=>'đ','D'=>'Đ',
     'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
     'i'=>'í|ì|ỉ|ĩ|ị', 'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
     'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
     'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
     'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
     'y'=>'ý|ỳ|ỷ|ỹ|ỵ', 'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
    );
    foreach($unicode as $khongdau=>$codau) {
      $arr = explode("|",$codau);
      $str = str_replace($arr,$khongdau,$str);
    }
    return $str;
}

function changeTitle($str){
    $str = $this->stripUnicode($str);
    $str = $this->stripSpecial($str);
    $str = mb_convert_case($str , MB_CASE_LOWER , 'utf-8');
    return $str;
}


function customizeArrayKTV( array $ktvlist ) 
{	
	//var_dump($clients);die;

	foreach( $ktvlist as &$ktv )
	{
	    $ktv['MaPhieuDieuTour'] = array($ktv['MaPhieuDieuTour']);
	    $ktv['MaBanPhong'] = array($ktv['MaBanPhong']);
	    $ktv['TenHangBan'] = array($ktv['TenHangBan']);
	    $ktv['GioThucHien'] = array($ktv['GioThucHien']);
	}
	unset($ktv);

	foreach( $ktvlist as &$ktv )
	{
	    $ktv = (object) $ktv;
	}

	unset($ktv);

	$result = array();
	//$i = 0;
	foreach($ktvlist as $ktv)
	{
	    if( !isset($result[$ktv->MaNV]) )
	    {
	        $result[$ktv->MaNV] = $ktv;
	    }
	    else
	    { 	//var_dump($client->GioVao[0]);die;
	        $result[$ktv->MaNV]->MaPhieuDieuTour[] = implode("",$ktv->MaPhieuDieuTour);
	        $result[$ktv->MaNV]->MaBanPhong[] = implode("",$ktv->MaBanPhong);
	        $result[$ktv->MaNV]->TenHangBan[] = implode("",$ktv->TenHangBan);
	        $result[$ktv->MaNV]->GioThucHien[] =  $ktv->GioThucHien[0];
	    }
	}

	return $result;

}

function customizeArrayKH( array $clients ) 
{	
	//var_dump($clients);die;

	foreach( $clients as &$client )
	{
	    $client['MaLichSuPhieu'] = array($client['MaLichSuPhieu']);
	    $client['TienThucTra'] = array($client['TienThucTra']);
	    $client['GioVao'] = array($client['GioVao']);
	}
		unset($client);
		//var_dump($clients);die;

	foreach( $clients as &$client )
	{
	    $client = (object) $client;
	}

	unset($client);
	// var_dump($clients);//die;


	$result = array();
	//$i = 0;
	foreach($clients as $client)
	{//var_dump($client); echo "<hr>";
	    if( !isset($result[$client->MaDoiTuong]) )
	    {
	        $result[$client->MaDoiTuong] = $client;
	    }
	    else
	    { 	//var_dump($client->GioVao[0]);die;
	        $result[$client->MaDoiTuong]->MaLichSuPhieu[] = implode("",$client->MaLichSuPhieu);
	        $result[$client->MaDoiTuong]->TienThucTra[] = implode("",$client->TienThucTra);
	        $result[$client->MaDoiTuong]->GioVao[] =  $client->GioVao[0];
	    }
	   
	   //	if( sizeof($clients) == 1) return $result;
	}

	//var_dump($result);die;

	return $result;

}

function pr($array = null) { echo "<pre>" . print_r($array, true) . "</pre>"; } 

function strToInt( array $input ){

    $output = array();
    $output = array_map('intval', $input[0]);//Convert array values from string to int
    
    return $output;
}


function removeOuterArr( array $input) {
	//pr($input);//die;
    $output = [];
    foreach($input as $item)
    { //pr($item[0]); die;
        $output[] = ($item[0]);
    }
    //pr($output); die;
    return $output;

}

