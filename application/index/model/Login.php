<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Login extends Model{
	public function login($usr,$pwd){
		$user=Db::name('login')->where('usr','=',$usr)->find();
		if($user){
			if($user['pwd']==$pwd){
				session('username',$user['usr']);
				session('uid',$user['id']);
				return 3; //信息正确
			}else{
				return 2;//密码错误
			}
		}else{
			return 1;//用户不存在
		}
	}
	public function logout(){
		session('uid');
		session_destroy();
	}
}
