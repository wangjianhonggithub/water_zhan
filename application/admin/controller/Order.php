<?php
namespace app\admin\controller;
use think\Loader;
use think\Db;
use think\Cookie;
use app\admin\controller\Base;
use app\admin\model\Order as OrderModel;
class Order extends Base
{
	/**
	 * 订单列表
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-06
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
    public function index($deliverType)
    {	
    	parent::CheckAdminLogin();

        $type = 1;
        $orderStatus = 0;
        $orderShowStatus = 0;
    	$data = OrderModel::GetAll($type,$orderStatus,$orderShowStatus,$deliverType);

    	return $this->fetch('Order/index',[
    		'list'=>$data,
    	]);
    }

    /**
     * 退款订单列表
     * @Author   CarLos(wang)
     * @DateTime 2018-06-06
     * @Email    carlos0608@163.com
     * @return   [type]             [description]
     */
    public function orderTui()
    {   
        parent::CheckAdminLogin();
        $deliverType = 0;
        $type = 1;
        $orderStatus = 5;
        $orderShowStatus = 0;
        $data = OrderModel::GetAll($type, $orderStatus,$orderShowStatus,$deliverType);
        return $this->fetch('Order/orderTui',[
            'list'=>$data,
        ]);
    }

    /**
     * 退款订单列表
     * @Author   CarLos(wang)
     * @DateTime 2018-06-06
     * @Email    carlos0608@163.com
     * @return   [type]             [description]
     */
    public function OrderShouHou()
    {   
        parent::CheckAdminLogin();
        $deliverType = 0;
        $type            = 1;
        $orderShowStatus = 1;
        $orderStatus     = 0;//5; 
        $data = OrderModel::GetAll($type, $orderStatus,$orderShowStatus,$deliverType);
        return $this->fetch('Order/orderShowHou',[
            'list'=>$data,
        ]);
    }
    
    /**
     * 押桶订单列表
     * @Author   CarLos(wang)
     * @DateTime 2018-06-06
     * @Email    carlos0608@163.com
     * @return   [type]             [description]
     */
    public function bucketList()
    {   
        parent::CheckAdminLogin();
        $deliverType = 0;
        $type = 2;
        $orderStatus = 0;
        $orderShowStatus = 0;
        $data = OrderModel::GetAll($type,$orderStatus,$orderShowStatus,$deliverType);
        return $this->fetch('Order/bucketList',[
            'list'=>$data,
        ]);
    }

    /**
     * 退桶订单列表
     * @Author   CarLos(wang)
     * @DateTime 2018-06-06
     * @Email    carlos0608@163.com
     * @return   [type]             [description]
     */
    public function bucketListTui()
    {   
        parent::CheckAdminLogin();
        $deliverType = 0;
        $type = 3;
        $orderStatus = 0;
        $orderShowStatus = 0;
        $data = OrderModel::GetAll($type,$orderStatus,$orderShowStatus,$deliverType);
        return $this->fetch('Order/bucketListTui',[
            'list'=>$data,
        ]);
    }
    //    详情页面
    public function getInfo()
    {
        $info = OrderModel::GetOne($_GET['id']);
        return $this->fetch('Order/action',[
            'info'=>$info,
        ]);
    }

    //退款订单详情
    public function getTuiKuanInfo()
    {
        $info = OrderModel::GetOne($_GET['id']);
        return $this->fetch('Order/tuiAction',[
            'info'=>$info,
        ]);
    }

    public function getShouHouInfo()
    {
        $info = OrderModel::GetOne($_GET['id']);
        return $this->fetch('Order/shouAction',[
            'info'=>$info,
        ]);
    }

    public function getBucketInfo()
    {
        $info = OrderModel::GetOne($_GET['id']);
        return $this->fetch('Order/bucketAction',[
            'info'=>$info,
        ]);
    }

    public function orderTuiKuan()
    {
        
        if (!isset($_POST['type']) || !$_POST['type']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        if (!isset($_POST['orderId']) || !$_POST['orderId']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        $type = $_POST['type'];
        $orderId = $_POST['orderId'];
        
        $result = OrderModel::orderTuiKuan($type, $orderId);

        return $result;
    }

    public function completeOrderZiQu()
    {
        
        if (!isset($_POST['userId']) || !$_POST['userId']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        if (!isset($_POST['orderId']) || !$_POST['orderId']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        $userId  = $_POST['userId'];
        $orderId = $_POST['orderId'];
        
        $result = OrderModel::completeOrderDoZiQu($userId, $orderId);

        return json_encode(["code"=>0,"meg"=>"操作成功"]);
    }

    public function doShouHou()
    {
        if (!isset($_POST['orderId']) || !$_POST['orderId']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        $orderId = $_POST['orderId'];
        
        $result = Db::name('order')->where('id',$orderId)->update(['orderShowStatus'=>2]);

        if($result){
            return json_encode(["code"=>0,"meg"=>"操作成功"]);
        }
        return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
    }

    public function orderTuiTong()
    {

        if (!isset($_POST['orderId']) || !$_POST['orderId']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        $orderId = $_POST['orderId'];
        
        $result = OrderModel::orderTuiTong($orderId);

        return $result;
    }




    /*
     * 二期
     * 押退桶订单记录
     * */
    public function DepositRecord()
    {
        parent::CheckAdminLogin();

        // 判断是否是管理员
        $admin_type = Cookie::get('AdminUserType');
        $admin_id = Cookie::get('AdminUserId');
        if ( $admin_type == 1) {
            $admin_id = 'all';
        }
//        var_dump($admin_id);die();

        $orderCate = [2,3];

        $data = OrderModel::GetDepositRecord($orderCate,$admin_id);
        return $this->fetch('Order/depositRecord',[
            'list'=>$data,
        ]);

    }

    /*
     * 二期
     * 店长确认回桶操作，并加入空桶库存
     * */

    public function ConfirmEmptyBarrey()
    {
        $data = $_POST;
        Db::startTrans();
        try {
            // 空桶库存
            foreach ($data['empty_barrey'] as $key => $value) {
                $barrey = Db::name('empty_barrey')->where('goodsName', $value['bucket_name'])->where('userId', $data['belong_store'])->find();
                if($barrey) {
                    $result =  Db::name('empty_barrey')->where('goodsName', $value['bucket_name'])->where('userId', $data['belong_store'])->setInc('number', $value['bucket_num']);
                } else {
                    $result =  Db::name('empty_barrey')->insert(['goodsName'=>$value['bucket_name'],'number'=>$value['bucket_num'],'userId'=>$data['belong_store']]);
                }
                // 回桶记录日志
                $log['user_id'] = cookie('AdminUserId');
                $log['for_user_id'] = $data['belong_store'];
                $log['type'] = 2;
                $log['time'] = time();
                $log['goods_name']= $value['bucket_name'];
                $log['num'] = $value['bucket_num'];
                db('logs')->insert($log);
            }
            //订单欠桶数归0
            $data = Db::name('order')->where('id',$data['qiantong_order_id'])->update(['waterman_owe_bucket'=>'0']);

            Db::commit();
            return json_encode(['code'=>'1','meg'=>'操作成功']);
        }catch(\Exception $e){
            // 回滚事务

            Db::rollback();
            return json_encode(['code'=>'0','meg'=>'操作失败']);
        }

    }

} 
