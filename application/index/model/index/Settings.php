<?php
namespace app\index\model\index;
use think\Model;
use think\Db;
class Settings extends Model{
	public function get(){
        $settings=Db::query('SELECT `id`,`k`,`v` FROM `settings` WHERE `hide`=0');
        $setting=[];
        for($i=0;$i<count($settings);$i++){$setting[$settings[$i]['k']]=$settings[$i]['v'];}
        return json_encode($setting);
	}
	public function getPass(){
        $settings=Db::query("SELECT `k`,`v` FROM `settings` WHERE `k` IN ('mail_admin','mail_username','mail_secure','mail_port','mail_charset','mail_fromName','mail_password','mail_host') AND `hide`=1");
        $setting=[];
        for($i=0;$i<count($settings);$i++){$setting[$settings[$i]['k']]=$settings[$i]['v'];}
        return json_encode($setting);
	}
}