<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
class Saysth extends Model{
    public function get(){
        $saysths=Db::query("SELECT * FROM `saysth` ORDER BY `saysth`.`time` DESC");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$saysths]);
    }
}