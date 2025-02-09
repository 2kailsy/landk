<?php
namespace app\index\model\admin;
use think\Model;
use think\Db;
use app\index\model\index\Settings;
use DateTime;
use DateInterval;
class System extends Model{
	public function getInfo(){
	    $sys=new Settings();
	    $info=json_decode($sys->get());
        $about=Db::query("SELECT count(1) FROM `about`")[0]['count(1)'];
        $images=Db::query("SELECT count(1) FROM `images`")[0]['count(1)'];
        $sayme=Db::query("SELECT count(1) FROM `sayme`")[0]['count(1)'];
        $establishmentDate = new DateTime($info->establishment);
        $currentDate = new DateTime();
        $interval=$currentDate->diff($establishmentDate);
        return json_encode(['status'=>200,'msg'=>'获取成功','data'=>[
            'name'=> php_uname("s").PHP_EOL,
            'version'=>$info->version,
            'title'=>$info->title,
            'run_time'=>$interval->days." 天",
            'php'=>phpversion(),
            'mysql'=>Db::query('SELECT VERSION() AS version')[0]['version'],
            'upload_max_size'=>ini_get('upload_max_filesize'),
            'article_total'=>$about,
            'images_total'=>$images,
            'sayme_total'=>$sayme,
        ]]);
	}
}