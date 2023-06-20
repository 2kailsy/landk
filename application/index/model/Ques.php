<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Ques extends Model{
	public function get(){
        $ques=Db::query('SELECT `id`,`quen` AS `content`,`quet` AS `time` FROM `ques` WHERE `queact`=0');
        return json_encode(['status'=>200,'msg'=>'获取成功~','data'=>$ques]);
	}
	public function answer($id,$val){
        if(empty($id)||empty($val)){return json_encode(['status'=>-200,'msg'=>'参数不全~']);}
        $time=date('Y-m-d H:i:s');
        $ques=Db::query("UPDATE `ques` SET `quea`='$val',`queso`='$time',`queact`=1 WHERE `ques`.`id`=$id;");
        return json_encode(['status'=>200,'msg'=>'回答成功~']);
	}
}