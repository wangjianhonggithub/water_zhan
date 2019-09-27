<?php
namespace app\index\controller;
use think\Loader;
use think\Db;
use think\Session;
class Base extends \think\Controller
{
 

     public function _initialize(){
         // Session::delete('uid');
        $uid = session('uid');
        $identity = Db::name('user')->where('id',$uid)->value('identity');

        if (3 !== $identity) {
            $this->error('账号异常，请重新登陆','Login/Login');
        }
        if($uid == null){
            $this->error('请先登录后操作','Login/Login');
        } else {

          $userInfo = Db::name('user')->find($uid);

          $userInfo['num'] = Db::name('order')->where(['status'=>1,'SuId'=>$uid,'orderStatus'=>4])->count();

          $this->assign('userInfo', $userInfo);
        }
    }

     protected function Check()
     {
     	try {
     		if(true){
                throw new \Exception("这是一个演示", 2);
     		}
     	} catch (\Exception $e) {
     		echo $e->getMessage();
     	}
     }


}
