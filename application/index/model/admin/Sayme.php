<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Sayme extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $sayme=Db::query("SELECT `id`,`content`,`time` FROM `sayme` ORDER BY `sayme`.`time` DESC LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$sayme,'total'=>Db::query("SELECT count(1) FROM `sayme`")[0]['count(1)']]);
	}
	public function add($content){
        if(empty($content)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        $sayme=Db::name('sayme')->insert(['content'=>$content,'time'=>$time]);
        if($sayme){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $sayme=Db::name('sayme')->delete($id);
        if($sayme){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['content','time'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'content'=>$data['content']??null,
            'time'=>$data['time']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('sayme')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}