<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Shop extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $shop=Db::query("SELECT `id`,`name`,`explanation`,`img`,`price`,`time` FROM `shop` WHERE `type`=0 LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$shop,'total'=>Db::query("SELECT count(1) FROM `shop`")[0]['count(1)']]);
	}
	public function add($img,$name,$price,$explanation){
        if(empty($img)||empty($name)||empty($price)||empty($explanation)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        if($price<=0){return json_encode(['status'=>-200,'msg'=>'添加失败']);}
        $shop=Db::name('shop')->insert(['name'=>$name,'explanation'=>$explanation,'img'=>$img,'price'=>$price,'type'=>0,'time'=>$time]);
        if($shop){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $shop=Db::name('shop')->delete($id);
        if($shop){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['name','explanation','img','price','time'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        if(isset($data['price'])){if($data['price']<=0){return json_encode(['status'=>-200,'msg'=>'添加失败']);}}
        $updateData=[
            'name'=>$data['name']??null,
            'explanation'=>$data['explanation']??null,
            'img'=>$data['img']??null,
            'price'=>$data['price']??null,
            'time'=>$data['time']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('shop')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}