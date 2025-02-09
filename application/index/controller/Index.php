<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\index\Settings;
use app\index\model\index\Personal;
use app\index\model\index\Picture;
use app\index\model\index\Search;
use app\index\model\index\Sign;
use app\index\model\index\Says;
use app\index\model\index\Saysth;
use app\index\model\index\Sayme;
use app\index\model\index\Paper;
use app\index\model\index\Ques;
use app\index\model\index\Guess;
use app\index\model\index\Shop;
header("Content-Type: text/html;charset=utf-8");
header('Access-Control-Allow-Origin:*');//允许跨域
class Index extends Controller {
    protected function initialize(){if((!session('uid')&&session('uid')!=0)||!session('username')){$this::error("请登录！",url('/login'));}}
    public function index($type='index'){return $this->fetch('index');}
    public function settings(){
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
        switch($type){
            case 'user': $floder='/img/uploads/user';break;
            case 'about': $floder='/img/uploads/about';break;
            case 'shops': $floder='/img/uploads/shops';break;
            case 'picture': $floder='/img/uploads/picture';break;
            default: $floder='unknow';break;
        }
        if($floder!=='unknow'){
            $file=request()->file('file');
            $path=upload($file,$floder);
            echo $path;
        }else{
            echo json_encode(['status'=>404,'msg'=>'未知路径']);
        }
    }
    public function picture(){
        if(request()->isPost()){
            $pic=new Picture();
            return $pic->get();
        }
        return $this->fetch('picture');
    }
    public function search(){
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
        if(request()->isPost()){
            $qiandao=new Sign();
            $data=input('post.');
            switch($data['type']){
                case 0: $qiandaos=$qiandao->qiandao($data['liu']);break;
                case 1: $qiandaos=$qiandao->buqian($data['day'],$data['month'],$data['year'],$data['because']);break;
                case 2: $qiandaos=$qiandao->get($data['year'],$data['month']);break;
            }
            return $qiandaos;
        }
    }
    public function says(){
        if(request()->isPost()){
            $say=new Says();
            $data=input('post.');
            switch($data['type']){
                case 'get': $says=$say->get();break;
            }
            return $says;
        }
    }
    public function saysth(){
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