<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Paper extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $paper=Db::query("SELECT `id`,`pwd`,`content`,`date`,`look` FROM `paper` ORDER BY `paper`.`date` DESC LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$paper,'total'=>Db::query("SELECT count(1) FROM `paper`")[0]['count(1)']]);
	}
	public function add($pwd,$content){
        if(empty($content)||empty($pwd)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        $paper=Db::name('paper')->insert(['pwd'=>$pwd,'content'=>$content,'date'=>$time]);
        if($paper){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $paper=Db::name('paper')->delete($id);
        if($paper){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['content','pwd','date'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'content'=>$data['content']??null,
            'pwd'=>$data['pwd']??null,
            'date'=>$data['date']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('paper')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}