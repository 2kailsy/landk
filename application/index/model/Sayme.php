<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Sayme extends Model{
	public function get(){
        $saymes=Db::query('SELECT COUNT(1) AS `num` FROM `sayme`');
        return json_encode(['status'=>200,'msg'=>'获取成功','num'=>$saymes[0]['num']]);
	}
	public function add($val){
        if(empty($val)){return json_encode(['status'=>-200,'msg'=>'不可为空']);}
        $time=date('Y-m-d H:i:s');
        $saymes=Db::query("INSERT INTO `sayme` (`id`, `content`, `time`) VALUES (NULL, '$val', '$time')");
        return json_encode(['status'=>200,'msg'=>'发送成功']);
	}
}