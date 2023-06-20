<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Sign extends Model{
    public function buqian($day,$year,$because){
        $ac=$year.'-'.date('m');
        $signs=Db::query("SELECT * FROM `sign` WHERE `day`=$day AND `ac`='$ac'");

        if(count($signs)>0){
            return json_encode(['status'=>-200,'ax'=>$ac,'msg'=>'已经签过到啦~']);
        }else{
            $time=Date('Y-m-d H:i:s');
            Db::query("INSERT INTO `sign` (`day`, `sign`, `time`, `ac`, `because`, `liu`) VALUES ($day,NULL,'$time','$ac','$because',NULL);");
            return json_encode(['status'=>200,'msg'=>'补签成功~以后要早点签到呦~']);
        }
	}
    public function qiandao($liu){
        if(empty($liu)){return json_encode(['status'=>-200,'msg'=>'参数不全！']);}
        $d=(int)Date('j');
        $dd=(int)Date('d');
        $ac=Date('Y-m');
        $signs=Db::query("SELECT * FROM `sign` WHERE `day`=$d AND `ac`='$ac'");
        if(count($signs)>0){return json_encode(['status'=>-200,'msg'=>'已经签过到啦~']);}
        $time=Date('Y-m-d H:i:s');
        $signs=Db::query("INSERT INTO `sign` (`day`, `sign`, `time`, `ac`, `because`, `liu`) VALUES ($dd,NULL,'$time','$ac',NULL,'$liu');");
        return json_encode(['status'=>200,'msg'=>'签到成功~']);
	}
    public function get($year,$month){
        if(empty($year)||empty($month)){return json_decode(['status'=>-200,'msg'=>'参数不全']);}
        $mm=$month<10?'0'.$month:$month;
        $ac=$year.'-'.$mm;
        $signs=Db::query("SELECT * FROM `sign` WHERE `ac`='$ac'");
        return json_encode(['status'=>200,'msg'=>'获取成功~','days'=>$signs]);
	}
}