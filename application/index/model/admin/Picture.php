<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Picture extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $images=Db::query("SELECT `id`,`title`,`imageUrl`,`show`,`content`,`time`,`date` FROM `images` LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$images,'total'=>Db::query("SELECT count(1) FROM `images`")[0]['count(1)']]);
	}
	public function add($imageUrl,$title,$time,$show,$content){
        if(empty($imageUrl)||empty($title)||empty($time)||empty($content)||(empty($show)&&$show!==0)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $date=date('Y-m-d H:i:s');
        $images=Db::name('images')->insert(['title'=>$title,'time'=>$time,'imageUrl'=>$imageUrl,'show'=>$show,'content'=>$content,'date'=>$date]);
        if($images){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $images=Db::name('images')->delete($id);
        if($images){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['title','time','imageUrl','show','content','date'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'title'=>$data['title']??null,
            'time'=>$data['time']??null,
            'imageUrl'=>$data['imageUrl']??null,
            'show'=>$data['show']??null,
            'content'=>$data['content']??null,
            'date'=>$data['date']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('images')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}