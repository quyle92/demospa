<?php
class App{

    protected $controller="Controller_BanHang_Khu1";
    protected $action="getAllData";
    protected $params=[];

    function __construct(){
 
        $arr = $this->UrlProcess();

        // Controller
        $ctrl = "Controller_" . implode( "_", array_slice($arr,0,2) );//var_dump($ctrl);die;
        $_SESSION['page'] = implode( "/", array_slice($arr,0,2) );
        if( file_exists("./mvc/controllers/". $ctrl.".php") ){
            $this->controller = $ctrl;
            unset($arr[0]);
            unset($arr[1]);
        }
        require_once "./mvc/controllers/". $this->controller .".php";
        $this->controller = new $this->controller;//var_dump($this->controller);die;

        // Action
        if(isset($arr[2])){
            if( method_exists( $this->controller , $arr[2]) ){
                $this->action = $arr[2];
            }
            unset($arr[2]);
        }
        

        // Params
        $this->params = $arr?array_values($arr):[];
        if($_POST){
          
            $this->params = $_POST;

        }
        call_user_func_array([$this->controller, $this->action], count($this->params) > 1 ? array($this->params) : $this->params );
        //unset($_SESSION['page']);

    }

    function UrlProcess(){
        if( isset($_GET["url"]) ){
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }

    }

}


/**
 * Note
 */
//(1) https://stackoverflow.com/questions/1583140/can-i-instantiate-a-php-class-inside-another-class
//(2) Controler ko nhất thiết phải call Model và View, only either (VD: app Android ở ngoài gọi đường link abc.com/API_SinhVien/getSinhVienList để lấy list SinhVien dưới dạng json, thì chỉ cần tạo 1 Controller mới đế lấy data từ Model và json_code nó thôi, ko cần call View làm gì)
//(3) Cái hay:
// + làm team dc vì chỉ cần follow model, ko phải mỗi người code mỗi kiểu
// + ko mix php with HTML.
// + nếu khách kêu modify layout, go to View.
// + if they want function modified, add new Contoller.
// + if they change database, go to Model.
?>


