<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\admin\Settings;
use app\index\model\admin\Personal;
use app\index\model\admin\Picture;
use app\index\model\admin\Search;
use app\index\model\admin\Sign;
use app\index\model\admin\Says;
use app\index\model\admin\Saysth;
use app\index\model\admin\Sayme;
use app\index\model\admin\Paper;
use app\index\model\admin\Ques;
use app\index\model\admin\Guess;
use app\index\model\admin\Shop;
use app\index\model\admin\System;
header("Content-Type: text/html;charset=utf-8");
header('Access-Control-Allow-Origin:*');//允许跨域
class Admin extends Controller {
    protected function initialize(){if((!session('uid')&&session('uid')!=0)||!session('username')||!session('sort')=='管理'){$this::error("请登录！",url('/login'));}}
    public function admin($type='admin'){return $this->fetch('index');}
    public function system(){
        if(request()->isPost()){
			$system=new System();
			$data=input('post.');
            switch($data['type']){
                case 'get': $sys=$system->getInfo();break;
            }
            return $sys;
        }
    }
    public function settings(){
        if(request()->isPost()){
			$setting=new Settings();
			$data=input('post.');
            switch($data['type']){
                case 'get': $setting=$setting->get($data['p'],$data['n']);break;
                case 'add': $setting=$setting->add($data['k'],isset($data['v'])?$data['v']:null,$data['hide'],isset($data['template'])?$data['template']:null);break;
                case 'del': $setting=$setting->del($data['id']);break;
                case 'edit': $setting=$setting->edit($data);break;
            }
            return $setting;
        }
    }
    public function personal(){
        if(request()->isPost()){
			$personal=new Personal();
			$data=input('post.');
            switch($data['type']){
                case 'get': $person=$personal->get($data['p'],$data['n']);break;
                case 'getPerson': $person=$personal->getPerson($data['uid']);break;
                case 'del': $person=$personal->del($data['id']);break;
                case 'add': $person=$personal->add($data['usr'],
                                                    (isset($data['sort'])&&!empty($data['sort']))?$data['sort']:'用户',
                                                    (isset($data['sex'])&&!empty($data['sex']))?$data['sex']:'无',
                                                    $data['pwd'],
                                                    $data['nickname'],
                                                    (isset($data['headsolt'])&&!empty($data['headsolt']))?$data['headsolt']:'/uploads/user/k.png',
                                                    (isset($data['description'])&&!empty($data['description']))?$data['description']:'介个人hen懒喔，什么都没写',
                                                    $data['birth'],
                                                    $data['birthday']
                                                );break;
                case 'edit': $person=$personal->edit($data);break;
            }
            return $person;
        }
    }
    public function picture(){
        if(request()->isPost()){
            $pic=new Picture();
            $data=input('post.');
            switch($data['type']){
                case 'get': $pictures=$pic->get($data['p'],$data['n']);break;
                case 'add': $pictures=$pic->add($data['imageUrl'],$data['title'],$data['time'],$data['show'],$data['content']);break;
                case 'del': $pictures=$pic->del($data['id']);break;
                case 'edit': $pictures=$pic->edit($data);break;
            }
            return $pictures;
        }
    }
    public function search(){
        if(request()->isPost()){
            $search=new Search();
            $data=input('post.');
            switch($data['type']){
                case 'get': $searchs=$search->get($data['p'],$data['n']);break;
                case 'add': $searchs=$search->add(isset($data['img'])?$data['img']:null,$data['title'],$data['content'],$data['author']);break;
                case 'del': $searchs=$search->del($data['id']);break;
                case 'edit': $searchs=$search->edit($data);break;
            }
            return $searchs;
        }
    }
    public function says(){
        if(request()->isPost()){
            $say=new Says();
            $data=input('post.');
            switch($data['type']){
                case 'get': $says=$say->get($data['p'],$data['n']);break;
                case 'add': $says=$say->add($data['content']);break;
                case 'del': $says=$say->del($data['id']);break;
                case 'edit': $says=$say->edit($data);break;
            }
            return $says;
        }
    }
    public function saysth(){
        if(request()->isPost()){
            $saysth=new Saysth();
            $data=input('post.');
            switch($data['type']){
                case 'get': $says=$saysth->get($data['p'],$data['n']);break;
                case 'add': $says=$saysth->add($data['content']);break;
                case 'del': $says=$saysth->del($data['id']);break;
                case 'edit': $says=$saysth->edit($data);break;
            }
            return $says;
        }
    }
    public function sayme(){
        if(request()->isPost()){
            $me=new Sayme();
            $data=input('post.');
            switch($data['type']){
                case 'get': $mes=$me->get($data['p'],$data['n']);break;
                case 'add': $mes=$me->add($data['content']);break;
                case 'del': $mes=$me->del($data['id']);break;
                case 'edit': $mes=$me->edit($data);break;
            }
            return $mes;
        }
    }
    public function paper(){
        if(request()->isPost()){
            $paper=new Paper();
            $data=input('post.');
            switch($data['type']){
                case 'get': $papers=$paper->get($data['p'],$data['n']);break;
                case 'add': $papers=$paper->add($data['pwd'],$data['content']);break;
                case 'del': $papers=$paper->del($data['id']);break;
                case 'edit': $papers=$paper->edit($data);break;
            }
            return $papers;
        }
    }
    public function question(){
        if(request()->isPost()){
            $ques=new Ques();
            $data=input('post.');
            switch($data['type']){
                case 'get': $questions=$ques->get($data['p'],$data['n']);break;
                case 'add': $questions=$ques->add($data['content'],$data['act']);break;
                case 'del': $questions=$ques->del($data['id']);break;
                case 'edit': $questions=$ques->edit($data);break;
            }
            return $questions;
        }
    }
    public function guess(){
        if(request()->isPost()){
            $guess=new Guess();
            $data=input('post.');
            switch($data['type']){
                case 'get': $guesses=$guess->get($data['p'],$data['n']);break;
                case 'add': $guesses=$guess->add($data['content'],$data['ranswer'],$data['shows']);break;
                case 'del': $guesses=$guess->del($data['id']);break;
                case 'edit': $guesses=$guess->edit($data);break;
            }
            return $guesses;
        }
    }
    public function Sign(){
        if(request()->isPost()){
            $sign=new Sign();
            $data=input('post.');
            switch($data['type']){
                case 'get': $signs=$sign->get($data['year'],$data['month']);break;
                case 'del': $signs=$sign->del($data['id']);break;
                case 'edit': $signs=$sign->edit($data);break;
            }
            return $signs;
        }
    }
    public function shop(){
        if(request()->isPost()){
            $shop=new Shop();
            $data=input('post.');
            switch($data['type']){
                case 'get': $goods=$shop->get($data['p'],$data['n']);break;
                case 'add': $goods=$shop->add($data['img'],$data['name'],$data['price'],$data['explanation']);break;
                case 'del': $goods=$shop->del($data['id']);break;
                case 'edit': $goods=$shop->edit($data);break;
            }
            return $goods;
        }
    }
}