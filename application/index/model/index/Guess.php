<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
class Guess extends Model{
	public function get(){
        $guess=Db::query('SELECT *  FROM `guess` WHERE `shows`=0 ORDER BY `shows` ASC');
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$guess]);
	}
	public function check($id,$val){
        if(empty($id)||empty($val)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $info=Db::query("SELECT * FROM `guess` WHERE `id`=?",[$id])[0];
        if(empty($info)){return json_encode(['status'=>-200,'msg'=>'参数错误']);}
        if($info['ranswer']===$val){$is=true;$shows=1;}else{$is=false;$shows=0;}
        $time=$info['answert'].'||'.date('Y-m-d H:i:s');
        $answers=$info['answers'].'||'.$val;
        $guess=Db::query("UPDATE `guess` SET `answers`='$answers',`answert`='$time',`shows`=$shows WHERE `guess`.`id`=$id;");
        return json_encode(['status'=>$is?200:-200,'msg'=>$is?'正确':'错误']);
	}
}