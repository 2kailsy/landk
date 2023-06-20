<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Picture extends Model{
    public function get(){
        $pictures=Db::query('SELECT * FROM `images` ORDER BY `images`.`date` DESC');
        return json_encode($pictures);
    }
}