<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
use app\index\model\index\Shop;
class Personal extends Model{
	public function get(){
		$user=Db::name('personal')->where('uid','=',session('uid'))->find();
        $user['see']+=1;
        $shop=new Shop();
        $bags=json_decode($shop->getBag(),true)['data'];
        return json_encode(['userInfo'=>$user,'bag'=>$bags]);
	}
	public function change($data){
		if((empty($data['uid'])&&$data['uid']!=0)||
		   empty($data['age'])||
		   empty($data['birth'])||
		   empty($data['birthday'])||
		   empty($data['description'])||
		   empty($data['headsolt'])||
		   empty($data['horo'])||
		   empty($data['nickname'])||
		   empty($data['sex'])){
			return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);
		}
		if($data['uid']===session('uid')){
			$re=Db::table('personal')->where(['uid'=>session('uid')])->update([
				'nickname'=>$data['nickname'],
				'sex'=>$data['sex'],
				'age'=>$data['age'],
				'birth'=>$data['birth'],
				'birthday'=>$data['birthday'],
				'horo'=>$data['horo'],
				'description'=>$data['description'],
				'headsolt'=>$data['headsolt']
			]);
			if(!($re<0)){return json_encode(['status'=>200,'msg'=>'修改成功']);}
			return json_encode(['status'=>-200,'msg'=> '修改失败！']);
		}
        return json_encode(['status'=>-200,'msg'=> '信息错误，禁止修改！']);
	}
	public function addSee(){
		$info=Db::name('personal')->where('uid','=',session('uid'))->find();
        $see=(int)$info['see']+1;
        $level=1;
        if($see<=100){
            //1-10
            if($see<=10){$level=$see;}else{$level=round($see/10);}
        }else if($see>100&&$see<=1000){
            //11-20
            $level=10+round($see/100);
        }else if($see>1000&&$see<=10000){
            //21-30
            $level=20+round($see/1000);
        }else if($see>10000){
            //22-∞
            $level=30+round($see/10000);
        }
		Db::name('personal')->where('uid','=',session('uid'))->update(['see'=>$see,'level'=>$level]);
        return json_encode(['status'=>200]);
	}
	public function checkPass($pwd){
		$info=Db::name('login')->where('id','=',session('uid'))->find();
        return json_encode(['status'=>$info['pwd']===md5($pwd)?200:-200]);
	}
	public function changePass($pwd,$oldPwd){
		if(empty($pwd)||empty($oldPwd)){return json_decode(['status'=>-200,'msg'=>'参数不全，无法修改！']);}
        if(!(json_decode($this->checkPass($oldPwd),true)['status']===200)){return json_encode(['status'=>-200,'msg'=>'原密码错误！']);}
		$info=Db::name('login')->where('id','=',session('uid'))->update(['pwd'=>md5($pwd)]);
		session_destroy();
		return json_encode(['status'=>$info==0?-200:200,'msg'=>$info==0?'修改失败！':'修改成功']);
	}
	public function changeUser($pwd,$usr){
		if(empty($pwd)||empty($usr)){return json_decode(['status'=>-200,'msg'=>'参数不全，无法修改！']);}
		$info=Db::name('login')->where('id','=',session('uid'))->find();
        if(!($info['pwd']===md5($pwd))){return json_encode(['status'=>-200,'msg'=>'原密码错误！']);}
        if($info['usr']===$usr){return json_encode(['status'=>-200,'msg'=>'用户名未更改']);}
		$info=Db::name('login')->where('id','=',session('uid'))->update(['usr'=>$usr]);
		session_destroy();
		return json_encode(['status'=>$info==0?-200:200,'msg'=>$info==0?'修改失败！':'修改成功']);
	}
    public function point($num){
        if(!(session('uid')&&session('uid')!=0)||!is_int($num)){return false;}
		$user=Db::name('personal')->where('uid','=',session('uid'))->find();
        $point=$user['point']+$num;
		Db::name('personal')->where('uid','=',session('uid'))->update(['point'=>$point]);
        return true;
	}
}
