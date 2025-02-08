<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
class Login extends Model{
	public function login($usr,$pwd){
		$user=Db::name('login')->where('usr','=',$usr)->find();
		if($user){
			if($user['pwd']==md5($pwd)){
				session('username',$user['usr']);
				session('uid',$user['id']);
				session('sort',$user['sort']);
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
	public function check(){
	    if(session('uid')&&session('username')&&session('sort')){return json_encode(['status'=>200,'isAdmin'=>(session('sort')==='管理'?true:false),'msg'=>'欢迎~(￣▽￣)~*']);}
	    return json_encode(['status'=>-200,'msg'=>'未登录']);
	}
}
