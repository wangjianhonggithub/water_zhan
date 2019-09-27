<?php
namespace app\admin\controller;
use app\admin\model\StoreStockLogs;
use think\Loader;
use think\Db;
class Base extends \think\Controller
{

     protected function Check()
     {
      
     	try {
     		if(true){
                  throw new \Exception("这是一个演示-admin");
     		}
     	} catch (\Exception $e) {
     		echo $e->getMessage();
     	}
     }

     protected function CheckAdminLogin()
     {
          $cookie = cookie('AdminUserId');
          if (empty($cookie)) {
               $this->redirect('/Admin/Login');
          }
     }
     /**
      * 返回整个数组
      * @Author   CarLos(wang)
      * @DateTime 2018-06-04
      * @Email    carlos0608@163.com
      * @param    [type]             $file_name [description]
      */
     protected function UploadImg($file_name)
     {
          $info = request()->file($file_name)->move(ROOT_PATH . 'public' . DS . 'uploads');
          if($info){
               $res = '/uploads/'.$info->getSavename();
               $data[$file_name] =str_replace("\\","/",$res);
          }else{
               echo json_encode(["code"=>2,"meg"=>$file->getError()]);
          }
          return $data;
     }

     /**
      * 返回单纯的路径
      * @Author   CarLos(wang)
      * @DateTime 2018-06-04
      * @Email    carlos0608@163.com
      * @param    [type]             $file_name [description]
      */
     protected function UploadTirImg($file_name)
     {
          $info = request()->file($file_name)->move(ROOT_PATH . 'public' . DS . 'uploads');
          if($info){
               $res = '/uploads/'.$info->getSavename();
               $path =str_replace("\\","/",$res);
          }else{
               echo json_encode(["code"=>2,"meg"=>$file->getError()]);
          }
          return $path;
     }

    //二期
    //记录日志
    public function addLogs($store_id,$admin_id,$goods_id,$goods_name,$add_num,$total_money,$supplier_id){
        $storeStockLogs = new StoreStockLogs();
        $data['store_id'] = $store_id;
        $data['admin_id'] = $admin_id;
        $data['goods_id'] = $goods_id;
        $data['goods_name'] = $goods_name;
        $data['add_num'] = $add_num;
        $data['total_money'] = $total_money;
        $data['supplier_id'] = $supplier_id;
        $data['create_time'] = time();
        return $storeStockLogs->addLogs($data);
    }
}
