<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Search extends Model{
    public function search($key,$rn=5,$pn=1){
        if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $sql="SELECT * FROM `about` WHERE `title` LIKE '%$key%' OR `content` LIKE '%$key%' OR `author` LIKE '%$key%' LIMIT $start,$rn";
        $sql1="SELECT count(1) FROM `about` WHERE `title` LIKE '%$key%' OR `content` LIKE '%$key%' OR `author` LIKE '%$key%'";
        $searchs=Db::query($sql);
        $all=Db::query($sql1)[0]['count(1)'];
        return json_encode(['status'=>200,'msg'=>'搜索成功','all'=>$all,'data'=>$searchs,'rn'=>$rn,'pn'=>$pn]);
    }
}