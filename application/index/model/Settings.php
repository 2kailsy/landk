<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Settings extends Model{
	public function get($showPass=false){
        $settings=Db::query('SELECT * FROM `settings`');
        $setting=[];
        for($i=0;$i<count($settings);$i++){
            if($showPass==false){
                if(!stristr($settings[$i]['k'],'mail')){
                    $setting[$settings[$i]['k']]=$settings[$i]['v'];
                }
            }else{
                $setting[$settings[$i]['k']]=$settings[$i]['v'];
            }
        }
        return json_encode($setting);
	}
}