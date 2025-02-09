<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\index\Login;
header("Content-Type: text/html;charset=utf-8");
header('Access-Control-Allow-Origin:*');//允许跨域
class Logins extends Controller {
    public function login(){
        if(request()->isPost()){
			$login=new Login();
			$data=input('post.');
			$num=$login->login($data['usr'],$data['pwd']);
			if($num==3){
				return json_encode(['status'=>200,'msg'=>'登录成功']);
			}else{return json_encode(['status'=>-200,'msg'=>'用户名或密码错误']);}
		}
        return $this->fetch('login');
    }
    public function logout(){
        $login=new Login();
        $login->logout();
        return json_encode(['status'=>200,'msg'=>'已登出']);
    }
    public function check(){
        $login=new Login();
        return $login->check();
    }
}