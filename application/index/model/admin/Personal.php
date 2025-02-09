<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
use DateTime;
class Personal extends Model{
	public function get($rn=5,$pn=1){
	    if($rn<=0){$rn=5;}
        if($pn<=0){$pn=1;}
        $start=($pn-1)*$rn;
        $personal=Db::query("SELECT `id`,`usr`,`sort`,`time` FROM `login` ORDER BY `login`.`time` DESC LIMIT $start,$rn");
        $personalIds=array_column($personal,'id');
        $results = Db::name('login')
            ->alias('l')
            ->field([
                'l.id','l.usr','l.sort','l.time',
                'p.nickname','p.sex','p.age','p.birth','p.birthday','p.horo','p.description','p.headsolt','p.level','p.point','p.see'
            ])->join('personal p', 'l.id = p.uid', 'LEFT')
            ->whereIn('l.id', $personalIds)
            ->select();
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>$results,'total'=>Db::query("SELECT count(1) FROM `login`")[0]['count(1)']]);
	}
	public function getPerson($id){
        $personal=Db::query("SELECT `id`,`usr`,`sort`,`time` FROM `login` WHERE `id`=$id");
        $personalIds=array_column($personal,'id');
        $result = Db::name('login')
            ->alias('l')
            ->field([
                'l.id','l.usr','l.sort','l.time',
                'p.nickname','p.sex','p.age','p.birth','p.birthday','p.horo','p.description','p.headsolt','p.level','p.point','p.see'
            ])->join('personal p', 'l.id = p.uid', 'LEFT')
            ->whereIn('l.id',$personalIds)
            ->limit(1)
            ->select();
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>array_merge($result[0],['pwd'=>''])]);
	}
	public function add($usr,$sort,$sex,$pwd,$nickname,$headsolt,$description,$birth,$birthday){
        if(empty($usr)||empty($sort)||empty($sex)||empty($pwd)||empty($nickname)||empty($headsolt)||empty($description)||empty($description)||empty($birth)||empty($birthday)){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        $time=date('Y-m-d H:i:s');
        Db::startTrans();
        try{
            $loginId=Db::name('login')->insertGetId([
                'usr' =>$usr,
                'pwd' =>md5($pwd),
                'sort'=>$sort,
                'time'=>$time
            ]);
            $date=new DateTime($birth);
            $horo=getConstellation($date->format('m'),$date->format('d'));
            $age=calculateAge($birth);
            Db::name('personal')->insert([
                'uid'        =>$loginId,
                'nickname'   =>$nickname,
                'sex'        =>$sex,
                'age'        =>$age,
                'horo'       =>$horo,
                'birth'      =>$birth,
                'birthday'   =>$birthday,
                'description'=>$description,
                'headsolt'   =>$headsolt
            ]);
            Db::commit();
            return json_encode(['status'=>200,'msg'=>'添加成功']);
        }catch(\Exception $e){
            Db::rollback();
            return json_encode(['status'=>-200,'msg'=>'添加失败']);
        }
	}
	public function del($id){
        if(empty($id)&&$id!==0){return json_encode(['status'=>-200,'msg'=>'参数不全']);}
        try {
            Db::transaction(function()use($id){
                Db::name('personal')
                    ->where('uid',$id)
                    ->delete();
                Db::name('login')
                    ->where('id',$id)
                    ->delete();
            });
            return json_encode(['status'=>200,'msg'=>'删除成功']);
        }catch(\Exception $e){return json_encode(['status'=>-200,'msg'=>'删除失败']);}
	}
	public function edit($data){
	    if(empty($data['id'])){return json_encode(['status'=>-200,'msg'=> '信息不全，禁止修改！']);}
		$requiredFields=['usr','pwd','sort','time','nickname','sex','birth','birthday','description','headsolt','level','point','see'];
        $allEmpty=true;
        foreach($requiredFields as $field){if(isset($data[$field])&&$data[$field]!==null){$allEmpty=false;break;}}
        if($allEmpty){return json_encode(['status'=>-200,'msg'=>'信息不全，至少需要一个字段有值，禁止修改！']);}
        if(isset($data['birth'])&&!empty($data['birth'])){$date=new DateTime($data['birth']);$horo=getConstellation($date->format('m'),$date->format('d'));$age=calculateAge($data['birth']);}
        $updateData1=[
            'usr'=>$data['usr']??null,
            'pwd'=>(isset($data['pwd'])&&!empty($data['pwd']))?md5($data['pwd']):null,
            'time'=>$data['time']??null,
            'sort'=>$data['sort']??null
        ];
        $updateData2=[
            'nickname'=>$data['nickname']??null,
            'sex'=>$data['sex']??null,
            'birth'=>$data['birth']??null,
            'birthday'=>$data['birthday']??null,
            'description'=>$data['description']??null,
            'headsolt'=>$data['headsolt']??null,
            'level'=>$data['level']??null,
            'point'=>$data['point']??null,
            'see'=>$data['see']??null,
            'age'=>$age??null,
            'horo'=>$horo??null
        ];
        $updateData1=array_filter($updateData1,'filterCallback');
        $updateData2=array_filter($updateData2,'filterCallback');
        Db::startTrans();
        try{
            Db::table('login')->where('id',$data['id'])->update($updateData1);
            Db::table('personal')->where('uid',$data['id'])->update($updateData2);
            Db::commit();
            return json_encode(['status'=>200,'msg'=>'修改成功']);
        }catch(\Exception $e){
            Db::rollback();
            return json_encode(['status'=>-200,'msg'=>'修改失败，请稍后再试！']);
        }
	}
}