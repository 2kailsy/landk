<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Login;
use app\index\model\Settings;
use app\index\model\Personal;
use app\index\model\Picture;
use app\index\model\Search;
use app\index\model\Sign;
use app\index\model\Say;
use app\index\model\Saysth;
use app\index\model\Sayme;
use app\index\model\Paper;
use app\index\model\Ques;
use app\index\model\Guess;
use app\index\model\Shop;
header("Content-Type: text/html;charset=utf-8");
header('Access-Control-Allow-Origin:*');//允许跨域
class Index extends Controller {
    public function index($type='index'){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        return $this->fetch('index');
    }
    public function login(){
        if(request()->isPost()){
			$login=new Login();
			$data=input('post.');
			$num=$login->login($data['usr'],$data['pwd']);
			if($num==3){
				return json_encode(['status'=>200,'msg'=>'登录成功']);
			}else{return json_encode(['status'=>-200,'msg'=>'用户名或密码错误']);}
		}
        return $this->fetch('login');
    }
    public function settings(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
			$setting=new Settings();
			$data=input('post.');
            switch($data['type']){
                case 'get': $setting=$setting->get();break;
            }
            return $setting;
        }
    }
    public function personal(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
			$personal=new Personal();
			$data=input('post.');
            switch($data['type']){
                case 'get': $person=$personal->get();break;
                case 'change': $person=$personal->change($data);break;
                case 'addSee': $person=$personal->addSee();break;
                case 'checkPass': $person=$personal->checkPass($data['password']);break;
                case 'changePass': $person=$personal->changePass($data['password'],$data['oldPassword']);break;
                case 'changeUser': $person=$personal->changeUser($data['password'],$data['usr']);break;
            }
            return $person;
        }
    }
    public function upload($type){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        switch($type){
            case 'user': $floder='user';break;
            default: $floder='unknow';break;
        }
        if(strcmp($floder,'unknow')===1){
            $file=request()->file('file');
            $path=upload($file,$floder);
            echo $path;
        }else{
            echo json_encode(['status'=>404,'msg'=>'未知路径']);
        }
    }
    public function logout(){
        $login=new Login();
        $login->logout();
        return json_encode(['status'=>200,'msg'=>'已登出~']);
    }
    public function picture(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $pic=new Picture();
            return $pic->get();
        }
        return $this->fetch('picture');
    }
    public function search(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $search=new Search();
            $data=input('post.');
            if(empty($data['rn'])){$data['rn']=5;}
            if(empty($data['pn'])){$data['pn']=1;}
            switch($data['type']){
                case 'search': $searchs=$search->search($data['key'],$data['rn'],$data['pn']);break;
            }
            return $searchs;
        }
    }
    public function qiandao(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $qiandao=new Sign();
            $data=input('post.');
            switch($data['type']){
                case 0: $qiandaos=$qiandao->qiandao($data['liu']);break;
                case 1: $qiandaos=$qiandao->buqian($data['day'],$data['year'],$data['because']);break;
                case 2: $qiandaos=$qiandao->get($data['year'],$data['month']);break;
            }
            return $qiandaos;
        }
    }
    public function says(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $say=new Say();
            $data=input('post.');
            switch($data['type']){
                case 'get': $says=$say->get();break;
            }
            return $says;
        }
    }
    public function saysth(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $saysth=new Saysth();
            $data=input('post.');
            switch($data['type']){
                case 'get': $saysths=$saysth->get();break;
            }
            return $saysths;
        }
    }
    public function sayme(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $me=new Sayme();
            $data=input('post.');
            switch($data['type']){
                case 'get': $mes=$me->get();break;
                case 'add': $mes=$me->add($data['value']);break;
            }
            return $mes;
        }
    }
    public function paper(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $paper=new Paper();
            $data=input('post.');
            switch($data['type']){
                case 'look': $papers=$paper->look($data['pwd']);break;
            }
            return $papers;
        }
    }
    public function question(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $ques=new Ques();
            $data=input('post.');
            switch($data['type']){
                case 'get': $questions=$ques->get();break;
                case 'answer': $questions=$ques->answer($data['id'],$data['value']);break;
            }
            return $questions;
        }
    }
    public function guess(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $guess=new Guess();
            $data=input('post.');
            switch($data['type']){
                case 'get': $guesses=$guess->get();break;
                case 'check': $guesses=$guess->check($data['id'],$data['value']);break;
            }
            return $guesses;
        }
    }
    public function shop(){
        if(!session('uid')||!session('username')){$this::error("请登录！",url('/login'));}
        if(request()->isPost()){
            $shop=new Shop();
            $data=input('post.');
            switch($data['type']){
                case 'getGoods': $goods=$shop->getGoods();break;
                case 'buyGoods': $goods=$shop->buyGoods($data['goods']);break;
                case 'useGood': $goods=$shop->useGood($data['id'],$data['remark']);break;
            }
            return $goods;
        }
    }
}