<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Guess extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $guess=Db::query("SELECT `id`,`ranswer`,`content`,`answers`,`answert`,`shows`,`time` FROM `guess` ORDER BY `shows` ASC LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$guess,'total'=>Db::query("SELECT count(1) FROM `guess`")[0]['count(1)']]);
	}
	public function add($content,$ranswer,$shows){
        if(empty($content)||empty($ranswer)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        $guess=Db::name('guess')->insert(['ranswer'=>$ranswer,'content'=>$content,'shows'=>$shows,'time'=>$time]);
        if($guess){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $guess=Db::name('guess')->delete($id);
        if($guess){return json_encode(['status'=>200,'msg'=>'删除成功']);}
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
        $result=Db::table('guess')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}