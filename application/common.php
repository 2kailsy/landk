<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function upload($file,$folder){
    $info = $file->validate(['size'=>815678,'ext'=>'jpg,png,gif,jpeg,ico'])->move('../public/uploads/'.$folder);
    if($info){
        $img=$info->getSaveName();
        $imgs=str_replace('\\','/',$img);
        $path='/uploads/'.$folder.'/'.$imgs;
        return json_encode(['status'=>200,'msg'=>'上传成功~','path'=>$path]);
    }else{
        //上传失败
        return json_encode(['status'=>-200,'msg'=>'上传失败~']);
    }
}
/**
  * 发送邮件方法
  * @param string $to：接收者邮箱地址
  * @param string $title：邮件的标题
  * @param string $content：邮件内容
  * @return boolean  true:发送成功 false:发送失败
*/
use app\index\model\Settings;
use app\index\model\Shop;
use app\index\model\Personal;
function sendUseGoodMail($to,$id,$explanation='没有备注'){
    $mail=new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $setting=new Settings();
    $settings=json_decode($setting->get(true),true);
    if(!$to){$to=$settings['mail_admin'];}
    if(!$explanation){$explanation='没有备注';}
    $mail->Host=$settings['mail_host'];
    $mail->SMTPAuth=true;
    $mail->Username=$settings['mail_username'];
    $mail->Password=$settings['mail_password'];
    $mail->SMTPSecure=$settings['mail_secure'];
    $mail->Port=$settings['mail_port'];
    $mail->CharSet=$settings['mail_charset'];
    $mail->setFrom($settings['mail_username'],$settings['mail_fromName']);
    $userId=session('uid');
    $user=new Personal();
    $userName=json_decode($user->get($userId),true)['userInfo']['nickname'];
    $shop=new Shop();
    $good=json_decode($shop->getGood($id),true)['data'];
    $goodName=$good['name'];
    $goodImg=$good['img'];
    // $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    // $uri = $_SERVER['REQUEST_URI'];
    // $url = $protocol . $_SERVER['HTTP_HOST'];
    // $goodImg=$url.'/static/img/shops/fenshouka.png';
    $html= '<div style="width: 100%;height: 100%;background: #ffffff;display: flex;flex-direction: column;align-items: center;">
        <header style="display: flex;align-items: center;width: 100%;padding: 0px 8px;box-sizing: border-box;">
            <img src="/logo.png" height="160">
            <p style="flex: 1;"></p>
        </header>
        <section style="background-color: #f7f8fa;width: 100%;padding: 12px 12px;box-sizing: border-box;">
            <h1 style="margin-top: 0;margin-bottom: 12px;font-size: 32px;">使用商品</h1>
            <div style="font-size: 24px;">
                <span>用户('.$userName.')[UID: '.$userId.']申请使用<span style="color: red;font-weight: bold;">'.$goodName.'</span>：</span></br>
                <span>备注：<span style="color: red;font-weight: bold;">'.$explanation.'</span></span></br>
                <span style="display: flex;">商品图片：
                    <img src="'.$goodImg.'">
                </span>
            </div>
        </section>
        <footer style="text-align: center;color: #999999;font-size: 14px;">
            <p style="margin-bottom: 4px;">Copyright © 2021 - 2023 2kweb.</p>
            <p style="margin-top: 0;">All Rights Reserved. 2k 版权所有</p>
        </footer>
    </div>';
    $mail->isHTML(true);
    $mail->addAddress($to,'亲爱的你');
    $mail->Subject='使用商品';
    $mail->Body=$html;
    if($mail->send()){return true;}else{return false;}
}