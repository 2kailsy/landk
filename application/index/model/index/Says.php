<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
class Says extends Model{
    public function get(){
        $says=Db::query("SELECT * FROM `says` ORDER BY `says`.`id` ASC");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$says]);
    }
}