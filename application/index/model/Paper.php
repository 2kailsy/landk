<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Paper extends Model{
	public function look($pwd){
        $paper=Db::query("SELECT `content`,`date`,`look` FROM `paper` WHERE `pwd`=$pwd");
        $time=date('Y-m-d H:i:s');
        try{
            $look=$paper[0]['look'].'||'.$time;
            Db::query("UPDATE `paper` SET `look`='$look' WHERE `paper`.`pwd`=$pwd;");
            return json_encode(['status'=>200,'msg'=>'查看成功','data'=>['content'=>$paper[0]['content'],'date'=>$paper[0]['date']]]);
        }catch(\Throwable $th){
            return json_encode(['status'=>-200,'msg'=>'小纸条不存在~(￣▽￣)~*']);
        }
	}
}