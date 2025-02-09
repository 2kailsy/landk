<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
use app\index\model\index\Personal;
class Shop extends Model{
	public function getGoods(){
        $goods=Db::query('SELECT * FROM `shop` WHERE `type`=0 ORDER BY `shop`.`time` DESC');
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$goods]);
	}
	public function getGood($id){
        $goods=Db::query("SELECT * FROM `shop` WHERE `type`=0 AND `id`=?",[$id]);
        if(!empty($goods)){return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$goods[0]]);}
        else{return json_encode(['status'=>404,'msg'=>'未找到数据','data'=>null]);}
	}
	public function buyGoods($GoodIdAndHowManyArr){
        // $GoodIdAndHowManyArr=[0=>['id'=>0,'value'=>1]]
        $id=session('uid');
        if(empty($GoodIdAndHowManyArr)||(empty($id)&&$id!=0)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $all=0;
        $str='';
        for($i=0;$i<count($GoodIdAndHowManyArr);$i++){
            if((int)$GoodIdAndHowManyArr[$i]['value']<=0){return json_encode(['status'=>-200,'msg'=>'参数错误！']);}
            $info=json_decode($this->getGood($GoodIdAndHowManyArr[$i]['id']),true)['data'];
            $all+=(int)$GoodIdAndHowManyArr[$i]['value']*(int)$info['price'];
            $str.=$info['name'].','.$info['id'].','.$GoodIdAndHowManyArr[$i]['value'].';';
        }
        $users=new Personal();
        $user=$users->get();
        $point=json_decode($user,true)['userInfo']['point'];
        if($all>$point){return json_encode(['status'=>-200,'msg'=>'积分不足']);}
        $time=date("Y-m-d H:i:s");
        $rs=$users->point(-$all);
        if($rs==false){return json_encode(['status'=>-200,'msg'=>'错误！']);}else{
            Db::query("INSERT INTO `shop` (`id`,`name`,`explanation`,`img`,`price`,`type`,`time`) VALUES (NULL,'购买','$str',NULL,'$all','$id','$time')");
            return json_encode(['status'=>200,'msg'=>'购买成功']);
        }
        return json_encode(['status'=>-200,'msg'=>'购买失败！']);
	}
    public function useGood($id,$remark=''){
        $uid=session('uid');
        if(!$id||!$uid){return json_encode(['status'=>-200,'msg'=>'错误！']);}
        //TO DO
        $good=json_decode($this->getGood($id),true)['data'];
        //发送mail
        if(sendUseGoodMail(null,$good,$remark)===false){return json_encode(['status'=>-200,'msg'=>'使用失败!']);}
        // //减去他的个数(加一个-1的)
        $explanation=$good['name'].','.$good['id'].','.'-1';
        $time=date('Y-m-d H:i:s');
        Db::query("INSERT INTO `shop` (`id`, `name`, `explanation`, `img`, `price`, `type`, `time`)
        VALUES (NULL,'使用','$explanation',NULL,'-1','$uid','$time')");
        return json_encode(['status'=>200,'msg'=>'使用成功']);
    }
    public function getBag(){
        if(!session('uid')&&session('uid')!=0){return json_encode(['status'=>-200,'msg'=>'获取失败']);}
        $id=session('uid');
        $list=Db::query("SELECT * FROM `shop` WHERE `type`=$id AND `name` in ('购买','使用')  ORDER BY `shop`.`time` DESC");
        $lists=[];
        for($i=0;$i<count($list);$i++){
            $info=array_filter(explode(';',$list[$i]['explanation']));
            array_push($lists,$info);
        }
        $list=[];
        for($i=0;$i<count($lists);$i++){
            for($j=0;$j<count($lists[$i]);$j++){
                $_temp=explode(',',$lists[$i][$j]);
                if(isset($list[$_temp[1]])){
                    $list[$_temp[1]]['value']+=(int)$_temp[2];
                }else{
                    $list[$_temp[1]]=['id'=>(int)$_temp[1],'value'=>(int)$_temp[2]];
                }
            }
        }
        sort($list);
        for($i=0;$i<count($list);$i++){if($list[$i]['value']==0){unset($list[$i]);}}
        sort($list);
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$list]);
    }
}