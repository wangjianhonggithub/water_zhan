<?php

namespace app\index\controller;

use think\Loader;

use think\Db;

use app\index\controller\Base;

use app\admin\model\Order as OrderModel;

class Order extends Base

{



    public function index()

    {

    	// parent::Check();

    	// parent::CheckAdminLogin();

		// $data = AddressModel::GetAll();

		return $this->fetch('songshuiyuan/index',[

			'list'=>null,	

		]);

    }



    public function OrderList()

    {

        $uid = session('uid');

        $status = Db::name('user')->where('id', $uid)->value('status');

        if (!$status) {

            return $this->fetch('songshuiyuan/index',[

            'list'=>null]);

        }

        $type = 'orderStatus = 1';

        $cate = 1;

        //代发货

        $list = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 2';

        // 已发货

        $Yfhlist = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 3';

        // 已送达

        $Ysdlist = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 4';

        // 已完成

        $Ywclist = OrderModel::getList($uid,$type,$cate);

 // halt($Ywclist);
        $type = 'orderStatus = 5';

        // 已取消

        $Yqxlist = OrderModel::getList($uid,$type,$cate);



        $this->assign('Yfhlist', $Yfhlist);



        $this->assign('Ysdlist', $Ysdlist);



        $this->assign('Ywclist', $Ywclist);



        $this->assign('Yqxlist', $Yqxlist);

		
        return $this->fetch('songshuiyuan/s_order',[

			'list'=>$list,	

		]);

    }





    public function TOrderList()

    {



        $uid = session('uid');

       

        $status = Db::name('user')->where('id', $uid)->value('status');

        if (!$status) {

            return $this->fetch('songshuiyuan/index',[

            'list'=>null]);

        }

        $type = 'orderStatus = 1';

        $cate = 3;

        //代发货

        $list = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 2';

        // 已发货

        $Yfhlist = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 3';

        // 已送达

        $Ysdlist = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 4';

        // 已完成

        $Ywclist = OrderModel::getList($uid,$type,$cate);

        $type = 'orderStatus = 5';

        // 已取消

        $Yqxlist = OrderModel::getList($uid,$type,$cate);

        $this->assign('Yfhlist', $Yfhlist);

        $this->assign('Ysdlist', $Ysdlist);

        $this->assign('Ywclist', $Ywclist);

        $this->assign('Yqxlist', $Yqxlist);

		return $this->fetch('songshuiyuan/t_order',[

			'list'=>$list,	

		]);

    }

    public function SOrderList()

    {

        $uid = session('uid');

        $cate = 1;

        $type = 'orderStatus = 2 Or orderStatus = 3 Or orderStatus = 4 Or orderStatus = 5 ';

        //代发货   

        $list = OrderModel::getList($uid,$type,$cate);

        return $this->fetch('songshuiyuan/s_q_order',[

            'list'=>$list,   

        ]);

    }



    public function TOrderLists()

    {   

        $uid = session('uid');

        $cate = 3;

        $type = 'orderStatus = 2 Or orderStatus = 3 Or orderStatus = 4 Or orderStatus = 5 ';

        //代发货   

        $list = OrderModel::getList($uid,$type,$cate);

        return $this->fetch('songshuiyuan/t_q_order',[

            'list'=>$list,   

        ]);

    }



    // 送水员接单

    public function Receipt()

    {

        $orderId = $_GET['orderId'];

        $uid     = session('uid');

        $result = OrderModel::Receipt($orderId, $uid);

        return json_decode($result);

    }

    // 送水员退回订单

    public function giveUp()

    {

        $orderId = $_GET['orderId'];

        $uid     = session('uid');    

        $result = OrderModel::giveUp($orderId, $uid);

        return json_decode($result);

    }



    // 已完成

    public function giveTo()

    {

        $orderId = $_GET['orderId'];

        $uid     = session('uid');    

        $result = OrderModel::giveTo($orderId, $uid);

        return json_decode($result);

    }





    // 送水员确认收桶

    public function Buckets()

    {

        $orderId = $_GET['orderId'];

        $uid     = session('uid');    

        $result  = OrderModel::Buckets($orderId, $uid);

        return json_decode($result);

    }

    
    // 二期   送水员回桶情况
    public function BucketsLog()
    {
        $where['SuId'] = session('uid');
        $where['orderStatus'] = 4;
        $where['orderCate'] = 1;
        $all_order = Db::name('order')->where($where)->order('id','desc')->select();//送水员订单
        $bucket_category = [];
        foreach ($all_order as $k=>$v)
        {
//            获取此订单应回桶品牌及数量(实际为用户上一个订单)
            $where_data['orderStatus'] = 4;
            $where_data['orderCate'] = 1;
            $user_order = Db::name('order')->where('userId',$v['userId'])->where('belong_store',$v['belong_store'])->where('id','neq',$v['id'])->order('id','asc')->where($where_data)->where('completeDate','<=',$v['completeDate'])->select();

            if($user_order) {
//                $pre_order = array_slice($user_order,-$k-1,1);
                $pre_order = end($user_order);//用户上一个订单
                    // 获取商品品类
                    $goods_data = Db::name('order_goods')->where('orderNo',$pre_order['orderNo'])->select();
                    foreach ($goods_data as $key=>$value) {
                        $goods = Db::name('goods')->where('id',$value['goodsId'])->find();
                        $bucket_category[$k]['qiantong_orderNo'] = $v['orderNo'];//订单号
                        $bucket_category[$k]['completeDate'] = $v['completeDate'];//订单完成时间
                        $bucket_category[$k]['waterman_owe_bucket'] = $pre_order['waterman_owe_bucket'];//回桶数
                        $bucket_category[$k]['bucket'][$key]['bucket_name']= Db::name('bucket_category')->where('id',$goods['bucket_category'])->value('name');//回桶品牌
                        $bucket_category[$k]['bucket'][$key]['bucket_num'] = $value['goodsNum'];//桶品牌数

                    }

            }

        }
        return $this->fetch('songshuiyuan/bucket_order',[

            'list'=>$bucket_category,

        ]);


    }
    

}

