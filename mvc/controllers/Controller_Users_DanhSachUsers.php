<?php

// http://localhost/live/Home/Show/1/2

class Controller_Users_DanhSachUsers extends Controller{

    public function getAllData() 
    {

    	$users = $this->getUsersList();
    	$reports = $this->layTatCaBaoCao();

        $this->view("index", [
            "Page"=> $_SESSION['page'],
            "users" => $users,
            "reports" => $reports
        ]); 

    }

    function getUsersList()
    {
        $users = $this->model("Model");
        return $users->getUsersList();
    }

    function layTatCaBaoCao()
    {
    	$reports = $this->model("Model");
        return $reports->layTatCaBaoCao();
    }

    public static function layBaoCao( $ma_bao_cao ){
		$report = self::model("Model");
        return $report->layBaoCao( $ma_bao_cao );
	}

	public function them($user_info){

		$themUser = $this->model("Model");
		$themUser->them($user_info); 
	}

	public function edit($user_info){

		$editUser = $this->model("Model");
		if( !isset( $user_info['password'] ) )
			$editUser->edit($user_info); 
		else
		{
			$editUser->editWithPassword($user_info); 
		}
		
	}

	public function xoaUser( $tenSD ){

		$xoaUser = $this->model("Model");
		$xoaUser->xoaUser($tenSD); 
		
	}






}
?>