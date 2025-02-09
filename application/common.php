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
    $info=$file->validate(['ext'=>'jpg,png,gif,jpeg,ico,avif'])->move('../public/static'.$folder);
    if($info){
        try{
            $img=$info->getSaveName();
            $imgs=str_replace('\\','/',$img);
            $path='/static'.$folder.'/'.$imgs;
            return json_encode(['status'=>200,'msg'=>'上传成功','path'=>$path]);
        }catch(Exception $e){
            return json_encode(['status'=>-200,'msg'=>'上传失败','e'=>$e]);
        }
    }else{
        //上传失败
        return json_encode(['status'=>-200,'msg'=>'上传失败']);
    }
}
/**
  * 发送邮件方法
  * @param string $to：接收者邮箱地址
  * @param string $title：邮件的标题
  * @param string $content：邮件内容
  * @return boolean  true:发送成功 false:发送失败
*/
use app\index\model\index\Settings;
use app\index\model\index\Shop;
use app\index\model\index\Personal;
function sendUseGoodMail($to,$good,$explanation='没有备注'){
    $mail=new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $setting=new Settings();
    $settings=json_decode($setting->getPass(),true);
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
    $goodName=$good['name'];
    $goodImg=$good['img'];
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $uri = $_SERVER['REQUEST_URI'];
    $url = $protocol . $_SERVER['HTTP_HOST'];
    $goodImg=$url.$goodImg;
    $html= '<div style="width: 100%;height: 100%;background: #ffffff;display: flex;flex-direction: column;align-items: center;">
        <header style="display: flex;align-items: center;width: 100%;padding: 0px 8px;box-sizing: border-box;">
            <img src="'.$url.'/logo.png" height="160">
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
            <p style="margin-bottom: 4px;">Copyright © 2021 - 2025 2kweb.</p>
            <p style="margin-top: 0;">All Rights Reserved. 2k 版权所有</p>
        </footer>
    </div>';
    $mail->isHTML(true);
    $mail->addAddress($to,'亲爱的你');
    $mail->Subject='使用商品';
    $mail->Body=$html;
    if($mail->send()){return true;}else{return false;}
}
// 不移除 0，只移除 false、null、''
function filterCallback($value){return $value!==false&&$value!==null&&$value!=='';}
/**
 * 获取星座
 * @param int $month 阳历月份
 * @param int $day   阳历日
 * @return string|bool 星座名称或 false（如果日期无效）
 */
function getConstellation($month,$day){
    $month=(int)$month;
    $day=(int)$day;
    $lastDay=($day<=30);
    $febDay=(($month==2)&&($day<=29));
    $res=null;
    switch($month){
        case 1:
            if($day<=19){$res='摩羯座';}
            else if($day>=20){$res='水瓶座';}break;
        case 2:
            if($day<=18){$res='水瓶座';}
            else if($day>=19&&$febDay){$res='双鱼座';}break;
        case 3:
            if($day<=20){$res='双鱼座';}
            else if($day>=21){$res='白羊座';}break;
        case 4:
            if($day<=19){$res='白羊座';}
            else if($day>=20&&$lastDay){$res='金牛座';}break;
        case 5:
            if($day<=20){$res='金牛座';}
            else if($day>=21){$res='双子座';}break;
        case 6:
            if($day<=21){$res='双子座';}
            else if($day>=22&&$lastDay){$res='巨蟹座';}break;
        case 7:
            if($day<=22){$res='巨蟹座';}
            else if($day>=23){$res='狮子座';}break;
        case 8:
            if($day<=22){$res='狮子座';}
            else if($day>=23){$res='处女座';}break;
        case 9:
            if($day<=22){$res='处女座';}
            else if($day>=23&&$lastDay){$res='天秤座';}break;
        case 10:
            if($day<=23){$res='天秤座';}
            else if($day>=24){$res='天蝎座';}break;
        case 11:
            if($day<=22){$res='天蝎座';}
            else if($day>=23&&$lastDay){$res='射手座';}break;
        case 12:
            if($day<=21){$res='射手座';}
            else if($day>=22){$res='摩羯座';}break;
        default:return false;
    }
    return $res?:'日期无效';
}
/**
 * 根据阳历生日计算年龄（周岁）
 * @param string $birthday 阳历生日，格式为 'Y-m-d'（如 '1990-05-15'）
 * @return int|null 返回年龄（失败返回 null）
 */
function calculateAge($birthday){
    try{
        $birthDate=new DateTime($birthday);
        $today=new DateTime('today');
        $interval=$today->diff($birthDate);
        return $interval->y;
    }catch(Exception $e){return null;}
}