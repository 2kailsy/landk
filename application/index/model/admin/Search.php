<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Search extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $about=Db::query("SELECT `id`,`img`,`title`,`content`,`author`,`time` FROM `about` LIMIT $start,$rn");
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$about,'total'=>Db::query("SELECT count(1) FROM `about`")[0]['count(1)']]);
	}
	public function add($img,$title,$content,$author){
        if(empty($title)||empty($content)||empty($author)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        $about=Db::name('about')->insert(['img'=>$img,'title'=>$title,'content'=>$content,'author'=>$author,'time'=>$time]);
        if($about){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $about=Db::name('about')->delete($id);
        if($about){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['img','title','content','author','time'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'img'=>$data['img']??null,
            'title'=>$data['title']??null,
            'content'=>$data['content']??null,
            'author'=>$data['author']??null,
            'time'=>$data['time']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('about')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}