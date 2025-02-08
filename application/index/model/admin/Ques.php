<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Ques extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $ques=Db::query("SELECT `id`,`quen` AS `content`,`quet` AS `time`,`queact` AS `act`,`queaa` AS `author`,`quea` AS `answer`,`queso` AS `atime` FROM `ques` LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$ques,'total'=>Db::query("SELECT count(1) FROM `ques`")[0]['count(1)']]);
	}
	public function add($quen,$queact){
        if(empty($quen)||(empty($queact)&&$queact!==0)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        $ques=Db::name('ques')->insert(['quen'=>$quen,'quet'=>$time,'queact'=>$queact]);
        if($ques){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $ques=Db::name('ques')->delete($id);
        if($ques){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['act','answer','content','author','time','atime'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'queact'=>(isset($data['act'])&&($data['act']===0||$data['act']===1))?$data['act']:null,
            'quea'=>$data['answer']??null,
            'quen'=>$data['content']??null,
            'queaa'=>$data['author']??null,
            'queso'=>$data['atime']??null,
            'quet'=>$data['time']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('ques')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}