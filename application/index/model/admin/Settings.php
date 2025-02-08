<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
class Settings extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $settings=Db::query("SELECT `id`,`k`,`v`,`hide`,`template` FROM `settings` ORDER BY `settings`.`id` ASC LIMIT $start,$rn");
        foreach($settings as &$row){
            if(isset($row['template'])){
                $templateArray=json_decode($row['template'],true);
                $row['template'] = $templateArray;
            }
        }
        unset($row);
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$settings,'total'=>Db::query("SELECT count(1) FROM `settings`")[0]['count(1)']]);
	}
	public function add($k,$v,$hide,$template){
        if(empty($k)||(empty($hide)&&$hide!=0)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $settings=Db::name('settings')->insert(['k'=>$k,'v'=>$v,'hide'=>$hide,'template'=>$template]);
        if($settings){return json_encode(['status'=>200,'msg'=>'添加成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'添加失败']);}
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $settings=Db::name('settings')->delete($id);
        if($settings){return json_encode(['status'=>200,'msg'=>'删除成功']);}
        else{return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['k','v','hide','template'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        $updateData=[
            'k'=>$data['k']??null,
            'v'=>$data['v']??null,
            'hide'=>$data['hide']??null,
            'template'=>$data['template']??null
        ];
        $updateData=array_filter($updateData,'filterCallback');
        $result=Db::table('settings')->where('id',$data['id'])->update($updateData);
        if($result){return json_encode(['status'=>200,'msg'=>'修改成功！']);}
        else{return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);}
	}
}