<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Sign extends Model{
	public function get($year,$month){
        $sign=Db::query("SELECT `day`,`sign`,`time`,`ac`,`because`,`liu` FROM `sign` WHERE `ac`='$year-$month'");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>['data'=>$sign,'year'=>$year,'month'=>$month],'total'=>Db::query("SELECT count(1) FROM `sign`")[0]['count(1)']]);
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $sign=Db::name('sign')->delete($id);
        if($sign){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])&&$data['id']!==0){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['content','ranswer','time','shows'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'content'=>$data['content']??null,
            'ranswer'=>$data['ranswer']??null,
            'shows'=>$data['shows']??null,
            'time'=>$data['time']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('sign')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}