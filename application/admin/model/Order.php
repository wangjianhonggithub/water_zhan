<?php

namespace app\admin\model;

use think\Model;

use think\Db;

use app\admin\model\Bucket as BucketModel;

class Order extends Model

{

    //获取所有的数据

    public static function GetAll($type, $orderStatus, $orderShowStatus,$deliverType)

    {   

        $where = [];

        $where['status'] = 1;

        $where['orderCate'] = $type;

        if ($deliverType) {

            $where['deliverType'] = $deliverType;

        }

        if ($orderShowStatus != 0) {

            $where['orderShowStatus'] =  array('neq',0);

        } else {

            // $where['orderShowStatus'] = $orderShowStatus;

        }

        if ($orderStatus) {

            $where['orderStatus'] = $orderStatus;

        } else {

            $orderStatus = 'orderStatus = 1 or orderStatus = 2 or orderStatus = 3 or orderStatus = 4';

        }
        // 二期  配送订单区分分店
        $admin_user_id_name = Db::name('admin_users')->field('id,username')->where('id='.cookie('AdminUserId'))->find();
//        if ($deliverType == 1 || $deliverType == 2 || $type == 3) {

            if($admin_user_id_name['username'] != 'admin'){
                $store_id = Db::name('branch_store')->where('admin_id',$admin_user_id_name['id'])->value('id');
                $where['belong_store'] = $store_id;
            }
//        }



    	$result = Order::where($where)->where($orderStatus)->order('orderTstatus asc,id desc')->paginate(15);

        foreach ($result as $key => $value) {

            if($value['belong_store']) {

                $result[$key]['belong_store'] = Db::name('branch_store')->where('id',$value['belong_store'])->value('name');
            }else{
                $result[$key]['belong_store'] = '公海订单';
            }

            $result[$key]['userName'] = Db::name('user')->where('id', $value['userId'])->value('nickName');

            //1 代发货 2 已发货 3 待收货 4 已收货 5 已取消

            if ($value['orderStatus'] == 1) {

                $result[$key]['orderStatus'] = '待发货';

            }

            if ($value['orderStatus'] == 2) {

                $result[$key]['orderStatus'] = '已发货';

            }

            if ($value['orderStatus'] == 3) {



                if ($value['deliverType'] == 2) {

                    $result[$key]['orderStatus'] = '已确认';

                } else {

                    $result[$key]['orderStatus'] = '待收货';

                }

            }

            if ($value['orderStatus'] == 4) {

                $result[$key]['orderStatus'] = '已完成';

            }

            if ($value['orderStatus'] == 5) {

                $result[$key]['orderStatus'] = '已取消';

            }

            // 1 余额 2 微信 3 不可提现金额

            if ($value['payType'] == 1) {

                $result[$key]['payType'] = '余额支付';

            }

            if ($value['payType'] == 2) {

                $result[$key]['payType'] = '微信支付';

            }

            if ($value['payType'] == 3) {

                $result[$key]['payType'] = '不可提现金额';

            }

            $result[$key]['bucketNum'] = count(explode(',', $result[$key]['bucketId']));

            $result[$key]['createTime'] = date('Y-m-d H:i:s',$value['createTime']);

            $result[$key]['payTime'] = date('Y-m-d H:i:s',$value['payTime']);

        }



        if ($type == 1) {

            if (isset($result)) {

            

                $goodsType = 1;



                foreach($result as $k => $v) {

                    $goodsList = Db::name('order_goods')->where(['orderNo'=>$v['orderNo']])->select();

                        foreach ($goodsList as $key => $values) {

                            if ($values['goodsType'] == 2) {

                                $result[$k]['goodsType'] = $values['goodsType'];

                                continue;

                            }



                        }


                    $result[$k]['goods']          = $goodsList;

                    $result[$k]['orderGoodsType'] = $result[$k]['goodsType'];

                    $userInfo      = Db::name('user')->where('id',$v['userId'])->field('identification,level')->find();





                    if ($userInfo) {



                        switch ($userInfo['level']) {

                            case 1:

                                $result[$k]['shenfen'] = '普通会员';

                                break;

                            case 2:

                                $result[$k]['shenfen'] = '银卡会员';

                                break;

                            case 3:

                                $result[$k]['shenfen'] = '金卡会员';

                                break;

                        }



                    }







                    $bucketNumbers  = Db::name('bucket')->where(['uid'=>$v['userId'],'bucketType'=>2,'status'=>1])->count();

                    $bucketsss      = Db::name('bucket')->where(['uid'=>$v['userId'],'status'=>1])->count();

                    if ($userInfo['identification'] == 1) {

                        if ($result[$k]['goodsType'] == 2) {

                            if ($userInfo['level'] == 2 || $userInfo['level'] == 3) {

                                

                                // if ($v['orderNo'] == 'I219573726549565') {

                                //     halt($userInfo);

                                //     // halt($result[$k]['goodsType']);

                                // }







                                if ($bucketNumbers > 0) {

                                    $result[$k]['orderGoodsType'] = 3;



                                    $result[$k]['bucketNumbers']  = $bucketNumbers;



                                } else if ($bucketsss == 0) {
                                        $result[$k]['orderGoodsType'] = 3;
                                        $result[$k]['bucketNumbers'] = 0;

                                }

                                

                            }

                        }

                        

                    }

                }

            }

        }



        //dump($result);die();

    	return $result;

    }

    // 订单带薪资数据

    public static function getOrderLists($uid,$times)

    {

        $where = [];

        $where['status']      = 1;    

        $where['uid']         = $uid;

        $where['createTime']  = $times;

        $orderList = Db::name('salary')->where($where)->select();

        $list = [];

        $list['data'] = [];

        $userPrice = Db::name('user')->where('id',$uid)->value('price');

        $list['xinzi'] = $userPrice;

        $money = 0;

        $tmpArr = [];

        if($orderList) {

            foreach ($orderList as $key => $value) {

                    // $list['data'][$key] = Db::name('order')->where('id',$value['orderId'])->find();

                    $money += $value['money'];

                    $tmpArr = Db::name('order')->where('id',$value['orderId'])->find();

                    if ($tmpArr['orderCate'] == 1) {

                        $tmpArr['goodsList'] = Db::name('order_goods')->where(['orderNo'=>$tmpArr['orderNo']])->select();

                    } else {

                        $tmpArr['goodsList'] = [];

                    }

                    $tmpArr['ticheng']   = $value['money'];

                    $tmpArr['times'] = date('Y-m',$value['createTime']);

                    $list['data'][$key] = $tmpArr;

            }

            $list['xinzi'] = $money + $userPrice;

        }

        return $list;

    }

    // 薪资列表 -> 数组

    public static function getXinziList($uid)

    {

        $where = [];

        $where['status']      = 1;    

        $where['uid']         = $uid;

        $orderList = Db::name('salary')->where($where)->group('createTime')->order('createTime desc')->select();

        return $orderList;

    }



    //接口数据

    public static function GetAllApi()

    {

        $result = Order::all(['is_type'=>0]);

        return $result;

    }

    //交流互动接口

    public static function GetProAllApi()

    {

        $result = Order::all(['is_type'=>1]);

        return $result;

    }

    /**

     * 查找用户的单个数据

     */

    public static function GetOne($id)

    {

        $result = Db::name('order')->find($id);
//         二期 获取客户上一次订单水品牌
        $where['userId'] = $result['userId'];
        $where['orderCate'] = 1;
        $where['status'] = 1;
        $where['belong_store'] = $result['belong_store'];
        $all_order = Db::name('order')->where($where)->where('orderStatus','neq',5)->where('id','neq',$id)->order('id','asc')->where('id','<',$result['id'])->select();
        $bucket_category = [];
        $result['qiantong_order_id'] = 0;
        if ($all_order) {
            $last_order = end($all_order);
            //欠桶订单id
            $result['qiantong_order_id'] = $last_order['id'];
            //欠桶数
            $result['waterman_owe_bucket'] = $last_order['waterman_owe_bucket'];
            // 获取商品品类
            $goods_data = Db::name('order_goods')->where('orderNo',$last_order['orderNo'])->select();
            foreach ($goods_data as $key=>$value) {
                $goods = Db::name('goods')->where('id',$value['goodsId'])->find();
                $bucket_category[$key]['bucket_name']= Db::name('bucket_category')->where('id',$goods['bucket_category'])->value('name');
                $bucket_category[$key]['bucket_num'] = $value['goodsNum'];
            }
        }

        $result['huitong'] = $bucket_category;
        $result['nickName'] = Db::name('user')->where('id',$result['userId'])->value('nickName');

        $result['Sname'] = '';

        $result['Smobile'] = '';

        //二期 自取订单增加商品信息
        if ($result['deliverType'] == 2) {
            $result['goodsData'] = Db::name('order_goods')->where('orderNo',$result['orderNo'])->field(['goodsName','goodsNum'])->select();
        }

        if(isset($result['SuId']) && $result['SuId']) {

            $result['Sname'] = Db::name('user')->where('id',$result['SuId'])->value('nickName');

            $result['Smobile'] = Db::name('user')->where('id',$result['SuId'])->value('mobile');

        }

        // 1 余额 2 微信 3 不可提现金额

        if ($result['payType'] == 1) {

            $result['payType'] = '余额支付';

        }

        if ($result['payType'] == 2) {

            $result['payType'] = '微信支付';

        }

        if ($result['payType'] == 3) {

            $result['payType'] = '不可提现金额';

        }



        $userInfo      = Db::name('user')->where('id',$result['userId'])->field('identification,level')->find();



        if ($userInfo) {

            switch ($userInfo['level']) {

                case 1:

                    $result['shenfen']     = '普通会员';

                    break;

                case 2:

                    $result['shenfen']     = '银卡会员';

                    break;

                case 3:

                    $result['shenfen']     = '金卡会员';

                    break;

            }

        }



        $goodsList = Db::name('order_goods')->where(['orderNo'=>$result['orderNo']])->select();

        $goodsType = 1;

        $result['orderGoodsType'] = 1;

        foreach ($goodsList as $key => $value) {

            if ($value['goodsType'] == 2) {

                $goodsType = $value['goodsType'];

                continue;

            }

        }



        $result['orderGoodsType'] = $result['goodsType'];

        if ($userInfo['identification'] == 1) {



            if ($goodsType == 2) {



                if ($userInfo['level'] == 2 || $userInfo['level'] == 3) {



                    $result['orderGoodsType'] = 3;

                }

            }

            

        }

      

        $result['bucketNum'] = count(explode(',', $result['bucketId']));

        return $result;

    }



    //执行修改

    public static function UpdateData($id,$data)

    {

        $Banner = New Banner;

        $result = $Banner->save($data,['id'=>$id]);

        return $result;

    }

    //执行删除

    public static function DeleteData($id)

    {

        $result = Banner::destroy($id);

        return $result;

    }





    public static function getList($uid, $type, $cate)

    {

        $where = [];

        $where['orderCate']   = $cate;

        $where['status']      = 1;    

        $where['deliverType'] = 1;

        $orderStatus          = $type;

            // dump($orderStatus);die;

            if ( $orderStatus != 'orderStatus = 1' ) {

                $where['SuId'] = $uid;

            }

            $region = Db::name('user')->where('id',$uid)->value('region');

            $arr = [];

            $regions = '';

            $string  = 'region = 10000';

            if ($region) {

                $region = explode(',', $region);

                if (isset($region) && $region) { 

                    foreach ($region as $k => $v) {

                        if ($v !== '') {

                            $str = Db::name('region')->where('id',$v)->value('address');

                            $arr[$k] = explode(',', $str);

                        }

                    }

                }

                if (isset($arr) && $arr) {

                    foreach($arr as &$v){

                        array_pop($v);

                    }

                }

                foreach ($arr as &$v) {

                    $regions .= ','.implode(',', $v);

                }

                $whe = explode(',', $regions);

                array_shift($whe);

                foreach ($whe as &$value) {

                     $string .= ' Or region='.$value;

                }

                $wheres = $string;

            } else {

//                $where['region'] = 0;

            }

        // halt($wheres);

        // 二期 订单生成的时候已经归属于分店，分店店员都可接单(可直接根据送水员所属分店找订单)   去掉->where($string),$where['region']  加上$where['belong_store']
        $belong_to_store = Db::name('user')->where('id',$uid)->value('belong_to_store');

        $where['belong_store'] = $belong_to_store;

        // 订单列表

            $list = Db::name('order')->where($where)->where($orderStatus)->order('orderStatus asc, id desc')->limit(100)->select();

            if ($cate == 1)

            {

//                if (isset($list) && $v) {
                  if (isset($list)) {

                    $goodsType = 1;

                    foreach($list as $k => $v) {

                        $goodsList = Db::name('order_goods')->where(['orderNo'=>$v['orderNo']])->select();

                        $tips = '';
                            foreach ($goodsList as $key => $value) {
                                if($v['belong_store'] != 0 && $v['depositStatus'] == 2){
                                //if($v['belong_store'] != 0){
                                    $tips .= $value['goodsName'].':'.$value['goodsNum'].'桶;';
                                }

                                if ($value['goodsType'] == 2) {

                                    $goodsType = $value['goodsType'];

                                    continue;

                                }

                            }

                        $list[$k]['tips'] = $tips;

                        $list[$k]['goods']          = $goodsList;

                        $list[$k]['orderGoodsType'] = $goodsType;

                        $userInfo      = Db::name('user')->where('id',$v['userId'])->field('identification,level')->find();

                        $bucketNumbers  = Db::name('bucket')->where(['uid'=>$v['userId'],'bucketType'=>2,'status'=>1])->count();

                        $bucketsss      = Db::name('bucket')->where(['uid'=>$v['userId'],'status'=>1])->count();

                        if ($userInfo['identification'] == 1) {

                            if ($goodsType == 2) {

                                if ($userInfo['level'] == 2 || $userInfo['level'] == 3) {

                                    if ($bucketNumbers > 0) {

                                        $list[$k]['orderGoodsType'] = 3;

                                        $list[$k]['bucketNumbers']  = $bucketNumbers;

                                    } else if ($bucketsss == 0) {
                                        $list[$k]['orderGoodsType'] = 3;
                                        $list[$k]['bucketNumbers'] = 0;

                                    }

                                }

                            }

                        }

                    }

                }

            }

            // halt($list);

        return $list;

    }

    public static function getOrderList($uid, $type, $cate, $deliverType)

    {  

        $where = [];

        $where['userId'] = $uid;

        $where['orderCate']   = $cate;

        $where['status']      = 1;    

        $where['deliverType'] = $deliverType;

        $yunfei = Db::name('config')->where('id',1)->value('freight');

        $cangchu = 0;

        $number  = 0;

        if ($type != 0) {

            $where['orderStatus'] = $type;

        }

        $orderList            = Db::name('order')->where($where)->order('orderStatus asc, id desc')->select();

        if ($orderList) {

            foreach ($orderList as $key => $value) {

                $goodsList = Db::name('order_goods')->where(['o.orderNo'=>$value['orderNo']])

                                                                        ->alias('o')

                                                                        ->join('goods g','g.id = o.goodsId')

                                                                        ->join('Category c','c.id = g.cid')

                                                                        ->order('o.id desc')

                                                                        // ->where('g.is_type=1')

                                                                        ->field('o.goodsNum,o.goodsPrice,c.name as cateName,g.thumb_img,g.goods_name as goodsName')

                                                                        ->select();

                if ($goodsList) {

                    $cang = 2;

                    foreach ($goodsList as $kk => $vv) {

                        $cangchu += $vv['goodsNum'] * $cang;

                        $number += $vv['goodsNum'];

                    }

                }

                if ($cate == 1) {

                    $orderList[$key]['cangchu'] = $cangchu;

                }

                $orderList[$key]['goodsList'] = $goodsList;

                $orderList[$key]['number'] = $number;

                $orderList[$key]['yunfeis'] = $yunfei;

                $orderList[$key]['createTime'] = date('Y-m-d H:i:s',$value['createTime']);

                }

        }

        return $orderList;

    }

    public static function Receipt($orderId, $uid)

    {

        if (!$orderId) {

            return json_encode(['code'=>1025,'msg'=>'订单标识不存在']);

        }

        if (!$uid) {

            return json_encode(['code'=>1025,'msg'=>'用户标识不存在']);

        }

        $r = Db::name('order')->where('id', $orderId)->value('SuId');

        if ($r) { 
            return json_encode(['code'=>1025,'msg'=>'订单状态发生变化']);
        }

        $result = Db::name('order')->where('id', $orderId)->update(['SuId'=>$uid,'orderStatus'=>2]);

        //gfy
        //送水员接单，减去相应的分店的相对应品牌的空桶数量,给订单加上分店信息ID

        //分店ID
        $store_id = Db::name('user')->where('id='.$uid)->value('belong_to_store');
        //商品桶名称
        $goods_orderNo = Db::name('order')->where('id',$orderId)->value('orderNo');
        $goods_goods_name_num = Db::name('order_goods')->field('goodsName,goodsNum')->where('orderNo="'.$goods_orderNo.'"')->select();

        //一共多少空桶
        $waterman_owe_bucket_num = 0;
        //对应空桶数变化
        foreach($goods_goods_name_num as $gkey=>$gvalue){
            $waterman_owe_bucket_num += $gvalue['goodsNum'];
            //原有多少对应品牌空桶
            $old_empty_bucket_num = Db::name('empty_bucket')->where('user_id='.$store_id.' and goods_name="'.$gvalue['goodsName'].'"')->value('num');
            //减少相应品牌的桶
            $new_empty_bucket_num = $old_empty_bucket_num - $gvalue['goodsNum'];
            $goods_res1 = Db::name('empty_bucket')->where('user_id='.$store_id.' and goods_name="'.$gvalue['goodsName'].'"')->update(array('num'=>$new_empty_bucket_num));

        }


        //给订单信息中添加分店ID
        //减去分店相应空桶数量
        $goods_res2 = Db::name('order')->where('id',$orderId)->update(array('waterman_owe_bucket'=>$waterman_owe_bucket_num));


        if ($result) {

            return json_encode(['code'=>1001,'msg'=>'操作成功']);

        }

        return json_encode(['code'=>1025,'msg'=>'操作失败']);

    }

    public static function OrderDetail($id)

    {

        $Detail = Db::name('order')->where('id', $id)->find();

        $cangchu = 0;

        $num = 0;

        if (isset($Detail) && $Detail) {

                $goodsList = Db::name('order_goods')->where(['o.orderNo'=>$Detail['orderNo']])

                                                                        ->alias('o')

                                                                        ->join('goods g','g.id = o.goodsId')

                                                                        ->join('Category c','c.id = g.cid')

                                                                        ->order('o.id desc')

                                                                        // ->where('g.is_type=1')

                                                                        ->field('o.goodsNum,o.cangchu,o.goodsNum,o.goodsPrice,c.name as cateName,g.thumb_img,g.goods_name as goodsName')

                                                                        ->select();

                if ($goodsList) {

                    foreach ($goodsList as $key => $value) {

                        $cangchu += $value['cangchu'] * $value['goodsNum'];

                        $num += $value['goodsNum'];

                    }

                }

                $Detail['cangchu'] = $cangchu;

                if ($Detail['orderCate'] == 1) {

                    $Detail['num']     = $num;

                }

                $Detail['address'] = Db::name('config')->where('id',1)->value('address');

                $Detail['yunfeis'] = Db::name('config')->where('id',1)->value('freight');

                $Detail['goodsList'] = $goodsList;

                $Detail['payTime']   = date('Y-m-d H:i:s',$Detail['payTime']);

                $Detail['uname']   = Db::name('user')->where('id',$Detail['SuId'])->value('nickname');

                $Detail['umobile'] = Db::name('user')->where('id',$Detail['SuId'])->value('mobile');

        }

        return $Detail;

    }



    public static function giveUp($orderId, $uid)

    {

        if (!$orderId) {

            return json_encode(['code'=>1025,'msg'=>'订单标识不存在']);

        }

        if (!$uid) {

            return json_encode(['code'=>1025,'msg'=>'用户标识不存在']);

        }

        $result = Db::name('order')->where('id', $orderId)->update(['SuId'=>'','orderStatus'=>1]);

        //gfy
        //送水员放弃订单，加上相应的分店的相对应品牌的空桶数量

        //分店ID
        $store_id = Db::name('order')->where('id',$orderId)->value('belong_store');
        //$store_id = Db::name('user')->where('id='.$uid)->value('belong_to_store');
        //商品桶名称
        $goods_orderNo = Db::name('order')->where('id',$orderId)->value('orderNo');
        $goods_goods_name_num = Db::name('order_goods')->field('goodsName,goodsNum')->where('orderNo="'.$goods_orderNo.'"')->select();

        foreach($goods_goods_name_num as $k=>$v){
            //原有多少对应品牌空桶
            $old_empty_bucket_num = Db::name('empty_bucket')->where('user_id='.$store_id.' and goods_name="'.$v['goodsName'].'"')->value('num');
            //减少相应品牌的桶
            $new_empty_bucket_num = $old_empty_bucket_num + $v['goodsNum'];
            $goods_res1 = Db::name('empty_bucket')->where('user_id='.$store_id.' and goods_name="'.$v['goodsName'].'"')->update(array('num'=>$new_empty_bucket_num));
        }

        // dump(Db::name('order')->getLastSql());

        if ($result) {

            return json_encode(['code'=>1001,'msg'=>'操作成功']);

        }

        return json_encode(['code'=>1025,'msg'=>'操作失败']);

    }

    public static function giveTo($orderId, $uid)

    {

        if (!$orderId) {

            return json_encode(['code'=>1025,'msg'=>'订单标识不存在']);

        }

        if (!$uid) {

            return json_encode(['code'=>1025,'msg'=>'用户标识不存在']);

        }

        $res = Db::name('order')->where(['id'=>$orderId,'SuId'=>$uid,'orderStatus'=>2])->find();

        if (!$res) {

            return json_encode(['code'=>1025,'msg'=>'操作失败，该订单状态已经发生变化']);

        }
        $time = time();
        $result = Db::name('order')->where(['id'=>$orderId,'SuId'=>$uid])->update(['orderStatus'=>3,'completeDate'=>$time]);

        // dump(Db::name('order')->getLastSql());

        if ($result) {

            return json_encode(['code'=>1001,'msg'=>'操作成功']);

        }

        return json_encode(['code'=>1025,'msg'=>'操作失败']);

    }

    public static function Buckets($orderId, $uid)

    {

        if (!$orderId) {

            return json_encode(['code'=>1025,'msg'=>'订单标识不存在']);

        }

        if (!$uid) {

            return json_encode(['code'=>1025,'msg'=>'用户标识不存在']);

        }
        $time = time();
        $result = Db::name('order')->where('id', $orderId)->update(['orderStatus'=>3]);

        if ($result) {

            // $orderInfo = Db::name('order')->where('id', $orderId)->find();

            // $mon       = Db::name('config')->where('id', 1)->value('bucketDeposit');

            // $money     = $orderInfo['num'] * $mon;

            // $oldMoney  = Db::name('user')->where('id',$orderInfo['userId'])->value('money');

            // $newMoney  = $oldMoney + $money;

            // Db::name('user')->where('id', $orderInfo['userId'])->update(['money'=>$newMoney]);

            // //退桶

            // $detail    = '退桶运费';

            // $result    =  self::AddBill($orderInfo['userId'], 0 - $orderInfo['yunfei'], $detail);

            return json_encode(['code'=>1001,'msg'=>'操作成功']);

        }

        return json_encode(['code'=>1025,'msg'=>'操作失败']);

    }



    public static function SetOrderDetail($id,$payType,$cartType,$orderType,$cardType)

    {

        $bucket  = new BucketModel;

        if (!$id) {

            return json_encode(['code'=>1025,'msg'=>'订单标识不存在']);

        } 

        if (!$payType) {

            return json_encode(['code'=>1025,'msg'=>'支付方式错误']);

        }   

        $data = [];

        $datas = [];

        // $data['orderStatus'] = 1;

        $data['status']      = 1;

        $data['payTime']     = time();

        $data['payType']     = $payType;

        $data['isPay']       = 1;

        if ($orderType == 2 || $orderType == 5 || $orderType == 4 || $orderType == 7 || $orderType == 10 || $orderType == 8) {

            $data['orderStatus'] = 3;

        }

        $result = Db::name('order')->where('id', $id)->update($data);

        $Order  = Db::name('order')->where('id', $id)->find();

        if ($orderType == 5) {

            $oldMoney = Db::name('user')->where('id',$Order['userId'])->value('money');

            $newMoney = $Order['realTotalMoney'] + $oldMoney;

            $datas['money'] = $newMoney;

            $detail    = '余额充值'; 

            $result    =  self::AddBill($Order['userId'], $Order['realTotalMoney'], $detail);

            $res   = Db::name('user')->where('id', $Order['userId'])->update($datas);

        } elseif ($orderType == 1) {

            // 查询商品、修改库存

            $goodsInfo = Db::name('order_goods')->where(['orderNo'=>$Order['orderNo']])->select();
            $warehousing = db::name('config')->where('id',1)->value('warehousing');

            //   获取用户身份
            $level = Db::name('user')->where('id',$Order['userId'])->value('level');

            if ($goodsInfo) {

                $goodsNum = 0;

                $goodsMoney = 0;

                $goods_diff = 0;

                $statistical_time = strtotime(date('Y-m-d',time()));
                $store_id = $Order['belong_store'];


                foreach ($goodsInfo as $k => $v) {

                    $goodsId  = $v['goodsId'];

                    $num      = $v['goodsNum'];

//                    $stock    = Db::name('goods')->where('id',$goodsId)->value('stock');
                    $stock    = Db::name('store_stock')->where('goods_id',$goodsId)->value('stock');
                    $cost    = Db::name('store_stock')->where('goods_id',$goodsId)->value('cost');

                    $goodsMoney  += $num*$cost;

                    $newStock = $stock - $num;

                    // 删减库存

//                    Db::name('goods')->where('id',$goodsId)->update(['stock'=>$newStock]);
//                    二期，减少分店相应库存
                    Db::name('store_stock')->where('goods_id',$goodsId)->update(['stock'=>$newStock]);

                    // 计算订单内商品数量

                    $goodsNum += $v['goodsNum'];

//                    商品差价收益
                    $good_fanxian = Db::name('goods')->where('id',$goodsId)->find();
                    if ($good_fanxian['ordinaryMoney'] == 0 && $good_fanxian['silverCardMoney'] == 0 && $good_fanxian['goldenCardMoney'] == 0) {
                        $goods_diff = 0;
                    }else{
                        if($level == 1){
                            $goods_diff += ($good_fanxian['goods_pic']-$cost-$good_fanxian['ordinaryMoney'])*$num;
                        }elseif ($level == 2){
                            $goods_diff += ($good_fanxian['goods_pic']-$cost-$good_fanxian['silverCardMoney'])*$num;
                        }elseif ($level == 3){
                            $goods_diff += ($good_fanxian['goods_pic']-$cost-$good_fanxian['goldenCardMoney'])*$num;
                        }
                    }

                    //  二期    增加商品销量统计
                    $commodity_sales_volume = Db::name('commodity_sales_statistics')->where('statistical_time',$statistical_time)->where('goods_id',$v['goodsId'])->find();
                    if($Order['deliverType'] == 1){
                        //  送货上门
                        $freight = db::name('config')->where('id',1)->value('freight');
                        $yunfei = $freight*$num;
                    }else{
                        //自取
                        $yunfei = 0;
                    }
                    if($commodity_sales_volume){
                        //  修改
                        $sale_num = $commodity_sales_volume['sale_num']+$num;//销售量
                        $cost = $commodity_sales_volume['cost']+$num*$cost;//成本支出
                        $warehousing_get = $commodity_sales_volume['warehousing_get']+$num*$warehousing;//仓储费盈利
                        $distribution_fee_profit = $commodity_sales_volume['distribution_fee_profit']+$yunfei;//配送费盈利
                        Db::name('commodity_sales_statistics')->where('statistical_time',$statistical_time)->where('goods_id',$v['goodsId'])->update(['sale_num'=>$sale_num,'cost'=>$cost,'warehousing_get'=>$warehousing_get,'distribution_fee_profit'=>$distribution_fee_profit]);
                    }else{
                        //  增加
                        $data_goods['goods_id'] = $v['goodsId'];
                        $data_goods['goods_name'] = $v['goodsName'];
                        $data_goods['sale_num'] = $num;
                        $data_goods['cost'] = $num*$cost;
                        $data_goods['warehousing_get'] = $num*$warehousing;
                        $data_goods['distribution_fee_profit'] = $yunfei;
                        $data_goods['store_id'] = $Order['belong_store'];
                        $data_goods['statistical_time'] = $statistical_time;
                        $data_goods['month'] = date('Y').'-'.date('m');
                        $data_goods['created_at'] = time();
                        Db::name('commodity_sales_statistics')->insert($data_goods);

                    }
                }

                    if ($Order['depositStatus'] != 2) {

                        // 跟未使用的桶进行匹配

                        $bucketArr = Db::name('bucket')->where(['bStatus'=>0,'status'=>1,'uid'=>$Order['userId']])->limit($goodsNum)->select();

                        $bucketData = [];

                        foreach ($bucketArr as $key  => $value) {

                            $bucketData[$key]['id']  = $value['id'];

                            $bucketData[$key]['uid'] = $Order['userId'];

                            $bucketData[$key]['bStatus'] = 1;

                        }

                        $BucketModel = new BucketModel();

                        $res = $BucketModel->saveAll($bucketData);

                    }

                    $detail    = '购买商品'; 

                    $realTotalMoney = 0;

                    if ($Order['deliverType'] == 1) {

                        $realTotalMoney = $Order['realTotalMoney'];

                    } elseif ($Order['deliverType'] == 2) {

                        $realTotalMoney = $Order['realTotalMoney'];

                    }

                    $result    =  self::AddBill($Order['userId'], 0 - $realTotalMoney, $detail);

                //   二期   增加时时统计

                $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->find();
                if ($revenue_day) {
                    $profit = json_decode($revenue_day['profit'],true);
                    $expenditure = json_decode($revenue_day['expenditure'],true);
                    $profit['yunfei'] += $Order['yunfei'];//运费
                    $profit['goods_diff'] += $goods_diff;//商品差价收益
                    $profit['goods_cost'] += $goodsMoney;//商品成本收益
                    $profit['cangchu'] += $goodsNum*$warehousing;//仓储费
                    $expenditure['commodity_cost'] += $goodsMoney;//商品成本
                    $profit = json_encode($profit);
                    $expenditure = json_encode($expenditure);
                    Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->update(['profit'=>$profit,'expenditure'=>$expenditure]);
                }


            }      

        } elseif ($orderType == 2) {



            if($Order['substitution'] == 1) {

                $res   = Db::name('bucket')->where('orderNo', $Order['orderNo'])->update(['status'=>1]);

            } elseif ($Order['substitution'] == 2) {

                $res   = Db::name('bucket')->where('orderNo', $Order['orderNo'])->update(['subStatus'=>2]);

            } elseif ($Order['substitution'] == 3) {

                $res   = Db::name('bucket')->where('orderNo', $Order['orderNo'])->update(['status'=>1]);

            }

         

            //押桶订单

            $detail    = '桶押金充值'; 

            $result    =  self::AddBill($Order['userId'], 0 - $Order['realTotalMoney'], $detail);

            // if ($res) {

            //     $ids   = Db::name('bucket')->where(['orderNo'=>$Order['orderNo'],'status'=>1])->column('id');

            //     if ($ids) {

            //         if ($ids) {

            //             $buckets = [];

            //             foreach ($ids as $k => $v) {

            //                 $buckets[$k]['uid'] = $Order['userId'];

            //                 $buckets[$k]['bid'] = $v;

            //                 $buckets[$k]['createTime'] = time();

            //                 $buckets[$k]['status'] = 1;

            //             }

            //             $res = Db::name('user_bucket')->insertAll($buckets);

            //         }

            //     }

            // }

        } elseif ($orderType == 4) {

            // 时间添加

            $res   = Db::name('bucket')->where('id', $Order['bucketId'])->find();

            if ($res) {

                if ($res['bucketType'] == 2) {

                    $oldtime = time();
                    
                    if ($Order['type'] == 1) {

                        $newsTime = $oldtime + (30 * 24 * 60 * 60);

                    } else if ($Order['type'] == 2) {

                        $newsTime = $oldtime + (365 * 24 * 60 * 60);

                    }

                } else {

                    $oldtime = $res['validity'];

                    if ($Order['type'] == 1) {

                        $newsTime = $oldtime + (30 * 24 * 60 * 60);

                    } else if ($Order['type'] == 2) {

                        $newsTime = $oldtime + (365 * 24 * 60 * 60);

                    }

                }

                $detail    = '通租金充值'; 

                $result    =  self::AddBill($Order['userId'], 0 - $Order['realTotalMoney'], $detail);

//                时时统计桶租金收益
                $statistical_time = strtotime(date('Y-m-d',time()));
                $store_id = $Order['belong_store'];
                $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->find();
                if ($revenue_day) {
                    $profit = json_decode($revenue_day['profit'],true);
                    $profit['rent_income'] += $Order['realTotalMoney'];//桶租金收益
                    $profit = json_encode($profit);
                    Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->update(['profit'=>$profit]);
                }

                if ($res['bucketType'] == 2) {

                    $bucketInfo = [];

                    $bucketInfo['substitution'] = 1;

                    $bucketInfo['bucketType']   = 1;

                    $bucketInfo['validity']     = $newsTime;

                    $res       = Db::name('bucket')->where('id', $Order['bucketId'])->update($bucketInfo);

                } else {

                    $res       = Db::name('bucket')->where('id', $Order['bucketId'])->update(['validity'=>$newsTime]);

                }

                



            }

        } elseif ($orderType == 7) {

            if (!$payType) {

                return json_encode(['code'=>1025,'msg'=>'充值类型错误']);

            }  

            $userData = [];

            $userData['cardMoney'] = 0;

            if ($Order['cardType'] == 2) {

                $userData['level'] = 2;

                $userData['identification'] = 1;

                $userData['cardMoney'] = $Order['goodsMoney'];

                $res = Db::name('user')->where('id', $Order['userId'])->update($userData);

            } elseif ($Order['cardType'] == 3){

                $oldMoney = Db::name('user')->where('id', $Order['userId'])->value('cardMoney');

                $newMoney = $oldMoney + $Order['goodsMoney'];

                $userData['cardMoney'] = $newMoney;

                $userData['level'] = 3;

                $userData['identification'] = 1;

                $res = Db::name('user')->where('id', $Order['userId'])->update($userData);

            }

            //卡金订单

            $detail    = '卡金充值'; 

            $result    =  self::AddBill($Order['userId'], 0 - $Order['goodsMoney'], $detail);

        } elseif ($orderType == 3) {

            // 注销桶

            $buckets         = [];

            $bucketId        = explode (',',$Order['bucketId']);

            for ($i = 0; $i < count($bucketId); $i++) {

                $buckets[$i]['id']      = $bucketId[$i];

                $buckets[$i]['status']  = 0;

                $buckets[$i]['bStatus'] = 0;

                $Buckets[$i]['uid']     = $Order['userId'];

                $Buckets[$i]['orderBstatus']     = Db::name('bucket')->where('id',$bucketId[$i])->value('bStatus');

            }

            // if(isset($bucketId) && $bucketId) {

            // dump($datas);die();

            // }

            $res = $bucket->saveAll($buckets);

            //退桶运费

            $detail    = '退桶运费'; 

            $result    =  self::AddBill($Order['userId'], 0 - $Order['yunfei'], $detail);

        } elseif ($orderType == 10) {

            // 生成收益记录

            $profit = [];

            $profit['uid']        = $Order['shangId'];

            $profit['orderId']    = $Order['id'];

            $profit['money']      = $Order['realTotalMoney'];

            $profit['userId']     = $Order['userId'];

            $profit['createTime'] = time();

            $profit['times'] = strtotime(date('Y-m-d',time()));

            // 给收益表添加数据

            $res = Db::name('profit')->insert($profit);

            // 给商家增加金额

            $oldMoney  = Db::name('user')->where('id', $Order['shangId'])->value('money');

            $newsMoney = $oldMoney + $Order['realTotalMoney'];

            $res = Db::name('user')->where('id', $Order['shangId'])->update(['money'=>$newsMoney]);

            //给用户返现不可提现金额

            $level = Db::name('user')->where('id',$Order['userId'])->value('level');

            if ($Order['fanxian'] && $Order['fanxian'] != 0) {

                if($level == 3) {

                    $oldMoney  = Db::name('user')->where('id', $Order['userId'])->value('money');

                    $newsMoney = $oldMoney + $Order['fanxian'];

                    $res = Db::name('user')->where('id', $Order['userId'])->update(['money'=>$newsMoney]);

                } else if($level == 2) {

                    $oldMoney  = Db::name('user')->where('id', $Order['userId'])->value('noMoney');

                    $newsMoney = $oldMoney + $Order['fanxian'];

                    $res = Db::name('user')->where('id', $Order['userId'])->update(['noMoney'=>$newsMoney]);

                }

            }

            //线下消费

            $detail    = '线下消费'; 

            $result    =  self::AddBill($Order['userId'], 0 - $Order['realTotalMoney'], $detail);

            if($level == 3) {

                $detail    = '线下消费返利 余额'; 

            } else if($level == 2) {

                $detail    = '线下消费返利 不可提现金额'; 

            }

            if ($Order['fanxian'] && $Order['fanxian'] != 0 && $level != 1) {

                $result    =  self::AddBill($Order['userId'], $Order['fanxian'], $detail);

            }    

        } elseif ($orderType == 8) {

            // 卡金清零 、退回到余额 并且修改用户的 会员身份

            $oldMoney = Db::name('user')->where('id', $Order['userId'])->value('cardMoney');

            $userMoney = Db::name('user')->where('id', $Order['userId'])->value('money');

            // $newMoney = $oldMoney + $Order['goodsMoney'];

            $userData['cardMoney'] = 0;

            $userData['money']     = $oldMoney + $userMoney;

            $userData['level']     = 1;

            $userData['identification'] = 1;

            $res = Db::name('user')->where('id', $Order['userId'])->update($userData);

            //退卡金订单

            $detail    = '卡金退款'; 

            $result    =  self::AddBill($Order['userId'], $oldMoney, $detail);

        }

        if ($cartType == 1) {

          $res =  Db::name('cart')->where(['uid'=>$Order['userId'],'selected'=>1])->update(['status'=>0]);

        }

        return $res;

    }

    public static function completeOrder($userId, $orderId)

    {

        // 查询订单状态

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if (!isset($orderInfo['orderStatus']) || !$orderInfo['orderStatus']) {

            return false;

        }

        // 查询用户信息

        $userInfo  = Db::name('user')->where('id',$userId)->find();

        if (!$userInfo) {

            return false;

        }

        if ($orderInfo['orderStatus'] != 3) {

            return 3;

        }

        // 修改订单状态

        $result = Db::name('order')->where('id',$orderId)->update(['orderStatus'=>4,'completeDate'=>time()]);

        // 订单内商品数量

        $goodsList = Db::name('order_goods')->where(['orderNo'=>$orderInfo['orderNo']])->select();

        $num = 0;

        foreach ($goodsList as $key => $value) {

            $num += $value['goodsNum'];

        }

         if ($orderInfo['depositStatus'] != 2) {

            // 跟使用的桶进行匹配

            $bucketArr = Db::name('bucket')->where(['bStatus'=>1,'status'=>1,'uid'=>$userId])->limit($num)->select();

            $bucketData = [];

            foreach ($bucketArr as $key => $value) {

                $bucketData[$key]['id']      = $value['id'];

                $bucketData[$key]['bStatus'] = 0;

                $bucketData[$key]['uid']     = $userId;

            }

            $BucketModel = new BucketModel();

            $res = $BucketModel->saveAll($bucketData);

         }

        $price = Db::name('config')->where('id',1)->value('price');

        $money = $num * $price;

        $data = [];



        if (isset($orderInfo['SuId']) && $orderInfo['SuId']) {

        	$data['uid']        = $orderInfo['SuId'];

        	$data['createTime'] = strtotime(date('Y-m',time()));

	        $data['orderId']    = $orderId;

	        $data['money']      = $money;

	        $data['num']        = $num;

	        // 给薪资表添加数据

        	$res = Db::name('salary')->insert($data);

            //  统计表加支出
            $statistical_time = strtotime(date('Y-m-d',time()));
            $belong_to_store = $orderInfo['belong_store'];
            $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$belong_to_store)->find();
            if ($revenue_day) {
                $expenditure = json_decode($revenue_day['expenditure'],true);
                $expenditure['song_salary'] += $money;//送水员支出
                $expenditure = json_encode($expenditure);
                Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$belong_to_store)->update(['expenditure'=>$expenditure]);
            }



        }



          // 计算金额 ordinaryMoney silverCardMoney goldenCardMoney

         $level = 0;

         if (isset($userInfo['level']) && $userInfo['level']){

         	$level = $userInfo['level'];

         }

         if (isset($orderInfo['orderNo']) && $orderInfo['orderNo']) {

         	$goodsList = Db::name('order_goods')->where('orderNo',$orderInfo['orderNo'])->select();

         	if ($goodsList) {

         		$goodsArr = [];

         		foreach ($goodsList as $key => $value) {

         				$goodsArr[$key]['goodsId']  = $value['goodsId'];

         				$goodsArr[$key]['goodsNum'] = $value['goodsNum'];

         		}

         		$prices = 0;

                $pricess = 0;

         		if (!empty($goodsArr)) {

         			foreach ($goodsArr as $key => $value) {

         				$goodsInfos = Db::name('goods')->where('id',$value['goodsId'])->find();

         				switch ($level) {

         					case 1:

         						$prices    = $prices + ($goodsInfos['ordinaryMoney'] * $value['goodsNum']);

         						break;

         					case 2:

         						$prices    = $prices + ($goodsInfos['silverCardMoney'] * $value['goodsNum']);
                                

         						break;

         					case 3:

         						$prices    = $prices + ($goodsInfos['goldenCardMoney'] * $value['goodsNum']);
                                $pricess   = $pricess + ($goodsInfos['silverCardMoney'] * $value['goodsNum']);
         						break;

         				}



         			}

         		}



         	}



         }	



        $detail    = '不可提现金额'; 

        if ($orderInfo['payType'] != 3) {

            if ($orderInfo['fanxian'] > 0) {

                // $fanxian = $prices * 0.6;
                $fanxian = $prices;

                if ($userInfo['level'] == 3) {

                    $detail    = '余额'; 

                    //给用户返现余额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('money');

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

                    $money = $oldMoney + $fanxian;

                    // $newsMoney = $oldMoney + $orderInfo['fanxian'];

                    if ($money != 0) {

                        $res = Db::name('user')->where('id',$userId)->update(['money'=>$money]);

                    }

                } else {

                   $result    =  self::AddBill($userId,$fanxian,$detail);

                    // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

                    //给用户返现不可提现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    // $newsMoney = $oldMoney + $orderInfo['fanxian'];

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]); 

                }
            }

        } elseif ($orderInfo['payType'] == 3) {

            if ($userInfo['level'] == 2) {

                if ($orderInfo['fanxian'] > 0) {

                    $fanxian = $prices * 0.6;

                    // $fanxian = $orderInfo['fanxian'] * 0.6;

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    // $result    =  self::AddBill($userId,$fanxian,$detail);

                    //给用户返现不可提现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    // $newsMoney = $oldMoney + $fanxian;

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                }

            } elseif ($userInfo['level'] == 3) {

                $detail    = '不可提现金额'; 

                    if ($orderInfo['fanxian'] > 0) {

                    $fanxian = $pricess * 0.6;

                    // $fanxian = $orderInfo['fanxian'] * 0.6;

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    // $result    =  self::AddBill($userId,$fanxian,$detail);

                    //给用户返现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    // $newsMoney = $oldMoney + $fanxian;

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                } 

            }

        }

        return $res;

    }

    public static function completeOrderZiQu($userId, $orderId)

    {

        // 查询订单状态

        // $orderInfo = Db::name('order')->where('id',$orderId)->find();

        // if (!$orderInfo) {

        //     return false;

        // }

        // if (!isset($orderInfo['orderStatus']) || !$orderInfo['orderStatus']) {

        //     return false;

        // }

        // // 查询用户信息

        // $userInfo  = Db::name('user')->where('id',$userId)->find();

        // if (!$userInfo) {

        //     return false;

        // }

        // // if ($orderInfo['orderStatus'] != 3) {

        // //     return false;

        // // }

        // // 修改订单状态

        // $result = Db::name('order')->where('id',$orderId)->update(['orderStatus'=>3]);

        // //给用户返现不可提现金额

        // $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

        // $detail    = '不可提现金额'; 

        // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

        // $newsMoney = $oldMoney + $orderInfo['fanxian'];

        // $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

        // return $result;

       

         // 查询订单状态

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if (!$orderInfo) {

            return false;

        }

        if (!isset($orderInfo['orderStatus']) || !$orderInfo['orderStatus']) {

            return false;

        }

        // 查询用户信息

        $userInfo  = Db::name('user')->where('id',$userId)->find();

        if (!$userInfo) {

            return false;

        }

        if ($orderInfo['orderStatus'] != 1) {

            return false;

        }



        // 修改订单状态
        $time = time();
        $results = Db::name('order')->where('id',$orderId)->update(['orderStatus'=>4,'completeDate'=>$time]);

        // 订单内商品数量

        $goodsList = Db::name('order_goods')->where(['orderNo'=>$orderInfo['orderNo']])->select();

        $num = 0;

        if ($goodsList) {

            foreach ($goodsList as $key => $value) {

                $num += $value['goodsNum'];

            }     

        }

        if ($orderInfo['depositStatus'] != 2) {

            // 跟使用的桶进行匹配

            $bucketArr = Db::name('bucket')->where(['bStatus'=>1,'status'=>1,'uid'=>$orderInfo['userId']])->limit($num)->select();

            $bucketData = [];

            foreach ($bucketArr as $key => $value) {

                $bucketData[$key]['id']      = $value['id'];

                $bucketData[$key]['bStatus'] = 0;

                $bucketData[$key]['uid']     = $orderInfo['userId'];

            }

            $BucketModel = new BucketModel();

            $res = $BucketModel->saveAll($bucketData);

         }



         // 计算金额 ordinaryMoney silverCardMoney goldenCardMoney

         $level = 0;

         if (isset($userInfo['level']) && $userInfo['level']){

         	$level = $userInfo['level'];

         }



         if (isset($orderInfo['orderNo']) && $orderInfo['orderNo']) {



         	$goodsList = Db::name('order_goods')->where('orderNo',$orderInfo['orderNo'])->select();



         	if ($goodsList) {



         		$goodsArr = [];



         		foreach ($goodsList as $key => $value) {

         				$goodsArr[$key]['goodsId']  = $value['goodsId'];

         				$goodsArr[$key]['goodsNum'] = $value['goodsNum'];

         		}



         		$prices  = 0;
                $pricess = 0;


         		if (!empty($goodsArr)) {



         			foreach ($goodsArr as $key => $value) {

         				

         				$goodsInfos = Db::name('goods')->where('id',$value['goodsId'])->find();



         				switch ($level) {

         					case 1:

         						$prices    = $prices + ($goodsInfos['ordinaryMoney'] * $value['goodsNum']);

         						break;

         					case 2:

         						$prices    = $prices + ($goodsInfos['silverCardMoney'] * $value['goodsNum']);
                                
         						break;

         					case 3:

         						$prices    = $prices + ($goodsInfos['goldenCardMoney'] * $value['goodsNum']);
                                $pricess   = $pricess + ($goodsInfos['silverCardMoney'] * $value['goodsNum']);
         						break;

         				}



         			}

         		}



         	}



         }	



        $detail    = '不可提现金额'; 

        if ($orderInfo['payType'] != 3) {



            if ($userInfo['level'] == 3) {

                $detail    = '余额'; 

                //给用户返现余额

                $oldMoney  = Db::name('user')->where('id',$userId)->value('money');

                $result    =  self::AddBill($userId,$prices,$detail);

                // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

                $money = $oldMoney + $prices;

                // $newsMoney = $oldMoney + $orderInfo['fanxian'];

                if ($money != 0) {

                    $res = Db::name('user')->where('id',$userId)->update(['money'=>$money]);

                }

            } else {

                //给用户返现不可提现金额

                $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                $result    =  self::AddBill($userId,$prices,$detail);

                // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

                $newsMoney = $oldMoney + $prices;

                // $newsMoney = $oldMoney + $orderInfo['fanxian'];

                if ($newsMoney != 0) {

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                }

            }



           

        } elseif ($orderInfo['payType'] == 3) {

            if ($userInfo['level'] == 2) {

                if ($orderInfo['fanxian'] > 0) {

                    $fanxian = $prices * 0.6;

                    // $fanxian = $orderInfo['fanxian'] * 0.6;

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    // $result    =  self::AddBill($userId,$fanxian,$detail);

                    //给用户返现不可提现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    // $newsMoney = $oldMoney + $fanxian;

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                }

            } elseif ($userInfo['level'] == 3) {

                $detail    = '不可提现金额'; 

               if ($orderInfo['fanxian'] > 0) {

                    $fanxian = $pricess * 0.6;

                    // $fanxian = $orderInfo['fanxian'] * 0.6;

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    // $result    =  self::AddBill($userId,$fanxian,$detail);

                    //给用户返现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    // $newsMoney = $oldMoney + $fanxian;

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                } 

            }

        }

        return $results;

    }

    // 确认订单

    public static function completeOrderDoZiQu($userId, $orderId)

    {

        // 查询订单状态

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if (!$orderInfo) {

            return false;

        }

        if (!isset($orderInfo['orderStatus']) || !$orderInfo['orderStatus']) {

            return false;

        }

        // 查询用户信息

        $userInfo  = Db::name('user')->where('id',$userId)->find();

        if (!$userInfo) {

            return false;

        }

        if ($orderInfo['orderStatus'] != 3) {

            return false;

        }

        // 修改订单状态
        $time = time();
        $result = Db::name('order')->where('id',$orderId)->update(['orderStatus'=>4,'completeDate'=>$time]);

        // 订单内商品数量

        $goodsList = Db::name('order_goods')->where(['orderNo'=>$orderInfo['orderNo']])->select();

        $num = 0;

        if ($goodsList) {

            foreach ($goodsList as $key => $value) {

                $num += $value['goodsNum'];

            }     

        }  

         if ($orderInfo['depositStatus'] != 2) {

            // 跟使用的桶进行匹配

            $bucketArr = Db::name('bucket')->where(['bStatus'=>1,'status'=>1,'uid'=>$orderInfo['userId']])->limit($num)->select();

            $bucketData = [];

            foreach ($bucketArr as $key => $value) {

                $bucketData[$key]['id']      = $value['id'];

                $bucketData[$key]['bStatus'] = 0;

                $bucketData[$key]['uid']     = $orderInfo['userId'];

            }

            $BucketModel = new BucketModel();

            $res = $BucketModel->saveAll($bucketData);

         }

        if ($orderInfo['payType'] != 3) {

                if ($userInfo['level'] == 3) {

                    $detail    = '余额'; 

                    //给用户返现余额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('money');

                    $result    =  self::AddBill($userId,$prices,$detail);

                    // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

                    $money = $oldMoney + $prices;

                    // $newsMoney = $oldMoney + $orderInfo['fanxian'];

                    if ($money != 0) {

                        $res = Db::name('user')->where('id',$userId)->update(['money'=>$money]);

                    }

                } else {

                   $result    =  self::AddBill($userId,$prices,$detail);

                    // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

                    //给用户返现不可提现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $prices;

                    // $newsMoney = $oldMoney + $orderInfo['fanxian'];

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]); 

                }







            // //给用户返现不可提现金额

            // $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

            // $detail    = '不可提现金额'; 

            // $result    =  self::AddBill($userId,$orderInfo['fanxian'],$detail);

            // $newsMoney = $oldMoney + $orderInfo['fanxian'];

            // if ($newsMoney != 0) {

            //     $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

            // }

        } elseif ($orderInfo['payType'] == 3) {

            if ($userInfo['level'] == 2) {

                if ($orderInfo['fanxian'] > 0) {

                    $fanxian = $orderInfo['fanxian'] * 0.6;

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    //给用户返现不可提现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                }

            } elseif ($userInfo['level'] == 3) {

                $detail    = '不可提现金额'; 

                if ($orderInfo['fanxian'] > 0) {

                    $fanxian = $orderInfo['fanxian'] * 0.6;

                    $result    =  self::AddBill($userId,$fanxian,$detail);

                    //给用户返现不可提现金额

                    $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                    $newsMoney = $oldMoney + $fanxian;

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                }

            }

        }

        return $result;

    }

    public static function cancelOrder($userId, $orderId, $orderText)

    {

        $BucketModel = new BucketModel();

         // 查询订单状态

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if (!$orderInfo) {

            return false;

        }

        // 查询用户信息

        $userInfo  = Db::name('user')->where('id',$userId)->find();

        if (!$userInfo) {

            return false;

        }   

        if ($orderInfo['orderStatus'] == 5) {

            return false;

        }

        // 修改订单状态

        $result = Db::name('order')->where('id',$orderId)->update(['orderStatus'=>5,'orderText'=>$orderText]);

        if ($orderInfo['orderCate'] == 3) {

             if ($orderInfo['depositStatus'] != 2) {

                 // 桶退回押桶列表

                $buckets         = [];

                $bucketId        = explode(',',$orderInfo['bucketId']);

                for ($i = 0; $i < count($bucketId); $i++) {

                    $buckets[$i]['id']      = $bucketId[$i];

                    $buckets[$i]['status']  = 1;

                    $buckets[$i]['bStatus'] = Db::name('bucket')->where('id',$bucketId[$i])->value('orderBstatus');

                    $Buckets[$i]['uid']     = $orderInfo['userId'];

                }

                // if(isset($bucketId) && $bucketId) {

                // dump($datas);die();

                // }

                $res = $BucketModel->saveAll($buckets);

             }

            if ($orderInfo['payType'] == 1 || $orderInfo['payType'] == 2) {

                 //不可提现金额

                $oldMoney  = Db::name('user')->where('id',$userId)->value('money');

                $detail    = '余额'; 

                $ress    =  self::AddBill($userId,$orderInfo['realTotalMoney'],$detail);

                $newsMoney = $oldMoney + $orderInfo['realTotalMoney'];

                if ($newsMoney != 0) {

                    $res = Db::name('user')->where('id',$userId)->update(['money'=>$newsMoney]);

                }

            } elseif ($orderInfo['payType'] == 3) {

                 //不可提现金额

                $oldMoney  = Db::name('user')->where('id',$userId)->value('noMoney');

                $detail    = '不可提现金额'; 

                $resss    =  self::AddBill($userId,$orderInfo['realTotalMoney'],$detail);

                $newsMoney = $oldMoney + $orderInfo['realTotalMoney'];

                if ($newsMoney != 0) {

                    $res = Db::name('user')->where('id',$userId)->update(['noMoney'=>$newsMoney]);

                }

            }

        }

        return $result;

    }

    public static function ShouOrder($userId, $orderId, $orderText)

    {

        // 查询订单状态

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if (!$orderInfo) {

            return false;

        }

        // 查询用户信息

        $userInfo  = Db::name('user')->where('id',$userId)->find();

        if (!$userInfo) {

            return false;

        }

        // 修改订单状态

        $result = Db::name('order')->where('id',$orderId)->update(['orderShowStatus'=>1,'showText'=>$orderText]);

        return $result;

    }

    public static function orderTuiKuan($type, $orderId)

    {

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if(isset($orderInfo['orderTstatus']) && $orderInfo['orderTstatus'] == 2) {

            return  json_encode(["code"=>1,"meg"=>'操作失败, 请重试！']);

        }

        $price     = Db::name('config')->where('id',1)->value('price'); 

        $goodsNum  = 0;

        if ($type == 2) {

            if (!isset($orderInfo['SuId']) || !$orderInfo['SuId']) {

                return  json_encode(["code"=>1,"meg"=>'操作失败,该订单未有送水员接单！']);

            } 

        }
        $goods_diff = 0;
        $goodsCostMoney = 0;
        if ($orderInfo) {

            $goodsList = Db::name('order_goods')->where('orderNo',$orderInfo['orderNo'])->select();
            $config = Db::name('config')->where('id',1)->find();
            //   获取用户身份
            $level = Db::name('user')->where('id',$orderInfo['userId'])->value('level');
            if ($goodsList) {

                foreach ($goodsList as $key => $value) {

//                    $stock = Db::name('goods')->where('id',$value['goodsId'])->value('stock');
                    $stock    = Db::name('store_stock')->where('goods_id',$value['goodsId'])->value('stock');
                    $cost = Db::name('store_stock')->where('goods_id',$value['goodsId'])->value('cost');

                    $newsStock = $stock + $value['goodsNum'];

//                    Db::name('goods')->where('id',$value['goodsId'])->update(['stock'=>$newsStock]);
//                    二期，减少分店相应库存（退款增加库存）
                    Db::name('store_stock')->where('goods_id',$value['goodsId'])->update(['stock'=>$newsStock]);
                    $goodsNum += $value['goodsNum'];
                    $goodsCostMoney += $value['goodsNum']*$cost;

                    //                    商品差价收益
                    $good_fanxian = Db::name('goods')->where('id',$value['goodsId'])->find();
                    if ($good_fanxian['ordinaryMoney'] == 0 && $good_fanxian['silverCardMoney'] == 0 && $good_fanxian['goldenCardMoney'] == 0) {
                        $goods_diff = 0;
                    }else{
                        if($level == 1){
                            $goods_diff += ($good_fanxian['goods_pic']-$cost-$good_fanxian['ordinaryMoney'])*$value['goodsNum'];
                        }elseif ($level == 2){
                            $goods_diff += ($good_fanxian['goods_pic']-$cost-$good_fanxian['silverCardMoney'])*$value['goodsNum'];
                        }elseif ($level == 3){
                            $goods_diff += ($good_fanxian['goods_pic']-$cost-$good_fanxian['goldenCardMoney'])*$value['goodsNum'];
                        }
                    }

                    $statistical_time_goods = strtotime(date('Y-m-d',time()));
                    $date_goods = Db::name('commodity_sales_statistics')->where('statistical_time',$statistical_time_goods)->where('goods_id',$value['goodsId'])->find();
                    if($date_goods){
                        $sale_num = $date_goods['sale_num']-$value['goodsNum'];
                        $cost = $date_goods['cost']- $cost*$value['goodsNum'];
                        $warehousing_get = $date_goods['warehousing_get']-$config['warehousing']*$value['goodsNum'];
                        if($orderInfo['deliverType'] == 1){
                            if ($type ==1){
                                $distribution_fee_profit = $date_goods['distribution_fee_profit']-$config['freight']*$value['goodsNum'];
                            }else{
                                $distribution_fee_profit = $date_goods['distribution_fee_profit'];
                            }

                        }elseif ($orderInfo['deliverType'] == 2){
                            $distribution_fee_profit = $date_goods['distribution_fee_profit'];
                        }
                        Db::name('commodity_sales_statistics')->where('statistical_time',$statistical_time_goods)->where('goods_id',$value['goodsId'])->update(['sale_num'=>$sale_num,'cost'=>$cost,'warehousing_get'=>$warehousing_get,'distribution_fee_profit'=>$distribution_fee_profit]);
                    }

                }

                     if ($orderInfo['depositStatus'] != 2) {

                        // 跟使用的桶进行匹配

                        $bucketArr = Db::name('bucket')->where(['bStatus'=>1,'status'=>1,'uid'=>$orderInfo['userId']])->limit($goodsNum)->select();

                        $bucketData = [];

                        foreach ($bucketArr as $key => $value) {

                            $bucketData[$key]['id']      = $value['id'];

                            $bucketData[$key]['bStatus'] = 0;

                            $bucketData[$key]['uid']     = $orderInfo['userId'];

                        }

                        $BucketModel = new BucketModel();

                        $res = $BucketModel->saveAll($bucketData);

                     }              

            }

        }

        $money   = Db::name('user')->where('id',$orderInfo['userId'])->value('money');

        $noMoney = Db::name('user')->where('id',$orderInfo['userId'])->value('noMoney');

        $realTotalMoney = 0;

        // 全额退款

        if ($type == 1) {

        	if ($orderInfo['payType'] == 1 || $orderInfo['payType'] == 2) {

        		$newsMoney = $money + $orderInfo['realTotalMoney'];

	            $realTotalMoney = $orderInfo['realTotalMoney'];

	            $result = Db::name('user')->where('id',$orderInfo['userId'])->update(['money'=>$newsMoney]);

        	} elseif($orderInfo['payType'] == 3){

        		$newsMoney = $noMoney + $orderInfo['realTotalMoney'];

	            $realTotalMoney = $orderInfo['realTotalMoney'];

	            $result = Db::name('user')->where('id',$orderInfo['userId'])->update(['noMoney'=>$newsMoney]);

        	}

            // 退款修改时时记录的支出收益数据
            $statistical_time = strtotime(date('Y-m-d',time()));
            $store_id = $orderInfo['belong_store'];
            $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->find();
            if ($revenue_day) {
                $profit = json_decode($revenue_day['profit'],true);
                $expenditure = json_decode($revenue_day['expenditure'],true);
                $profit['yunfei'] -= $orderInfo['yunfei'];//运费
                $profit['goods_diff'] -= $goods_diff;//商品差价收益
                $profit['goods_cost'] -= $goodsCostMoney;//商品成本收益
                $warehousing = db::name('config')->where('id',1)->value('warehousing');
                $profit['cangchu'] -= $goodsNum*$warehousing;//仓储费
                $expenditure['commodity_cost'] -= $goodsCostMoney;//商品成本
                $profit = json_encode($profit);
                $expenditure = json_encode($expenditure);
                Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->update(['profit'=>$profit,'expenditure'=>$expenditure]);
            }

        // 扣运费退款

        } elseif ($type == 2) {

            // 商家送货退款

            if ($orderInfo['deliverType'] == 1) {

                $newsMoney = $money + $orderInfo['realTotalMoney']  - $orderInfo['yunfei'];

                $realTotalMoney = $orderInfo['realTotalMoney'] - $orderInfo['yunfei'];

                // 给送水员加薪资

                $salary = [];

                $salary['uid']        = $orderInfo['SuId'];

                $salary['createTime'] = strtotime(date('Y-m',time()));

                $salary['orderId']    = $orderId;

                $salary['money']      = $price * $goodsNum;

                $salary['num']        = $goodsNum;

                // 给薪资表添加数据

                $res = Db::name('salary')->insert($salary);

                //  统计表加支出
                $statistical_time = strtotime(date('Y-m-d',time()));
                $belong_to_store = $orderInfo['belong_store'];
                $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$belong_to_store)->find();
                if ($revenue_day) {
                    $expenditure = json_decode($revenue_day['expenditure'],true);
                    $expenditure['song_salary'] += $price * $goodsNum;//送水员支出
                    $expenditure = json_encode($expenditure);
                    Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$belong_to_store)->update(['expenditure'=>$expenditure]);
                }


            // 自取订单退款

            } else {

                $newsMoney = $money + $orderInfo['realTotalMoney'];

                $realTotalMoney = $orderInfo['realTotalMoney'];

            }

            if ($orderInfo['payType'] == 1 || $orderInfo['payType'] == 2) {

        		$result = Db::name('user')->where('id',$orderInfo['userId'])->update(['money'=>$newsMoney]);

        	} elseif($orderInfo['payType'] == 3){

        		$newsMoney = $noMoney + $orderInfo['realTotalMoney'];

	            $result = Db::name('user')->where('id',$orderInfo['userId'])->update(['noMoney'=>$newsMoney]);

        	}

            // 退款修改时时记录的支出收益数据
            $statistical_time = strtotime(date('Y-m-d',time()));
            $store_id = $orderInfo['belong_store'];
            $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->find();
            if ($revenue_day) {
                $profit = json_decode($revenue_day['profit'],true);
                $expenditure = json_decode($revenue_day['expenditure'],true);
                $profit['goods_diff'] -= $goods_diff;//商品差价收益
                $profit['goods_cost'] -= $goodsCostMoney;//商品成本收益
                $warehousing = db::name('config')->where('id',1)->value('warehousing');
                $profit['cangchu'] -= $goodsNum*$warehousing;//仓储费
                $expenditure['commodity_cost'] -= $goodsCostMoney;//商品成本
                $profit = json_encode($profit);
                $expenditure = json_encode($expenditure);
                Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$store_id)->update(['profit'=>$profit,'expenditure'=>$expenditure]);
            }

        }

            $detail    = '订单退款'; 

            $result    =  self::AddBill($orderInfo['userId'],$realTotalMoney,$detail);

            //生成一条消息发送给用户

            $data = [];

            $data['problem'] = '订单退款消息';

            $data['answer'] = '订单号为'.$orderInfo['orderNo'].'的订单已退款，请去余额查看，如有问题请联系网站管理人员！';

            $data['create_time'] = time();

            $data['type'] = 3;

            $data['uid'] = $orderInfo['userId'];

            Db::name('help')->insert($data);

            $result = Db::name('order')->where('id',$orderId)->update(['orderTstatus'=>2,'orderTuiStatus'=>$type]);

            if ($result === false) {

                return  json_encode(["code"=>1,"meg"=>'操作失败']);

            }else{

                return json_encode(["code"=>0,"meg"=>"操作成功"]);

            }

    }

    public static function orderTuiTong($orderId)

    {

        $orderInfo = Db::name('order')->where('id',$orderId)->find();

        if ($orderInfo) {

            $buckets = explode(',', $orderInfo['bucketId']);

            if ($buckets) {

                $bucketMoney = 0;

                foreach ($buckets as &$value) {

                    $bucketMoney += Db::name('bucket')->where('id',$value)->value('bucketDeposit');

                } 

            }

        }

        if(isset($orderInfo['orderTstatus']) && $orderInfo['orderTstatus'] == 1) {

            $money = Db::name('user')->where('id',$orderInfo['userId'])->value('money');

            $newsMoney = $money + $bucketMoney;

            $result = Db::name('user')->where('id',$orderInfo['userId'])->update(['money'=>$newsMoney]);

            $detail    = '桶押金退款'; 

            $result    =  self::AddBill($orderInfo['userId'],$bucketMoney,$detail);

            $price     = Db::name('config')->where('id',1)->value('price'); 

            if ($orderInfo['SuId']) {

                // 给送水员加薪资

                $salary = [];

                $salary['uid']        = $orderInfo['SuId'];

                $salary['createTime'] = strtotime(date('Y-m',time()));

                $salary['orderId']    = $orderId;

                $salary['money']      = $price;

                $salary['num']        = 1;

                // 给薪资表添加数据

                $res = Db::name('salary')->insert($salary);

                //  统计表加支出
                $statistical_time = strtotime(date('Y-m-d',time()));
                $belong_to_store = $orderInfo['belong_store'];
                $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$belong_to_store)->find();
                if ($revenue_day) {
                    $expenditure = json_decode($revenue_day['expenditure'],true);
                    $expenditure['song_salary'] += $price;//送水员支出
                    $expenditure = json_encode($expenditure);
                    Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$belong_to_store)->update(['expenditure'=>$expenditure]);
                }

            }

            //生成一条消息发送给用户

            $data = [];

            $data['problem'] = '订单退款消息';

            $data['answer'] = '订单号为'.$orderInfo['orderNo'].'的订单已退款，请去余额查看，如有问题请联系网站管理人员！';

            $data['create_time'] = time();

            $data['type'] = 4;

            $data['uid'] = $orderInfo['userId'];

            Db::name('help')->insert($data);

            $result = Db::name('order')->where('id',$orderId)->update(['orderTstatus'=>2,'orderStatus'=>4,'completeDate'=>time()]);

        } else {

            return  json_encode(["code"=>1,"meg"=>'操作失败']);

        }

        if ($result === false) {

            return  json_encode(["code"=>1,"meg"=>'操作失败']);

        }else{

            return json_encode(["code"=>0,"meg"=>"操作成功"]);

        }

    }

    // 消费明细接口

    public static function AddBill($uid,$money,$detail)

    {

        $data = [];

        $data['uid']        = $uid;

        $data['money']      = $money;

        $data['createTime'] = time();

        $data['detail']     = $detail;

        $result = Db::name('bill')->insert($data);

    }

    //   桶押退记录
    public static function GetDepositRecord($orderCate, $admin_id)
    {
        if($admin_id == 'all') {
            $data = Order::whereIn('orderCate',$orderCate)->order('id desc')->paginate(15);
        } else {
            // 分店id
            $store_id = db::name('branch_store')->where('admin_id',$admin_id)->value('id');
            $data = Order::whereIn('orderCate',$orderCate)->where('belong_store',$store_id)->order('id desc')->paginate(15);
        }

        foreach ($data as $key => $value) {



            $data[$key]['userName'] = Db::name('user')->where('id', $value['userId'])->value('nickName');



            if ($value['orderStatus'] == 1) {

                $data[$key]['orderStatus'] = '待取桶';

            }

            if ($value['orderStatus'] == 2) {

                $data[$key]['orderStatus'] = '取桶中';

            }

            if ($value['orderStatus'] == 3) {



                $data[$key]['orderStatus'] = '已收桶';


            }

            if ($value['orderStatus'] == 4) {

                $data[$key]['orderStatus'] = '已完成';

            }

            if ($value['orderStatus'] == 5) {

                $data[$key]['orderStatus'] = '已取消';

            }

            // 1 余额 2 微信 3 不可提现金额

            if ($value['payType'] == 1) {

                $data[$key]['payType'] = '余额支付';

            }

            if ($value['payType'] == 2) {

                $data[$key]['payType'] = '微信支付';

            }

            if ($value['payType'] == 3) {

                $data[$key]['payType'] = '不可提现金额';

            }

            $data[$key]['bucketNum'] = count(explode(',', $data[$key]['bucketId']));

            $data[$key]['createTime'] = date('Y-m-d H:i:s',$value['createTime']);

            $data[$key]['payTime'] = date('Y-m-d H:i:s',$value['payTime']);

        }
        
        return $data;
    }

    //获取分店商品订单
    public static function GetStoreOrder($store_id)
    {
        $where['orderCate'] = 1;
        $where['belong_store'] = $store_id;
        $where['status'] = 1;
        $orderStatus = [3,4];
        $begin_time = strtotime("-1 day");
        $end_time = time();
        $order = Db::name('order')->whereIn('orderStatus',$orderStatus)->where($where)->where('completeDate','>=',$begin_time)->where('completeDate','<=',$end_time)->select();
        return $order;


    }

//    获取当日遗失水桶数量
    public static function GetLoseBucket()
    {
        $begin_time = strtotime("-1 day");
        $end_time = time();
        $num = Db::name('logs')->where('time','>=',$begin_time)->where('time','<=',$end_time)->where('type',3)->sum('num');
        return $num;
    }

    //获取分店退桶订单  返回运费之和
    public static function GetStoreTOrder($store_id)
    {
        $where['orderCate'] = 3;
        $where['belong_store'] = $store_id;
        $where['status'] = 1;
        $orderStatus = [3,4];
        $begin_time = strtotime("-1 day");
        $end_time = time();
        $torder_yunfei = Db::name('order')->whereIn('orderStatus',$orderStatus)->where($where)->where('completeDate','>=',$begin_time)->where('completeDate','<=',$end_time)->sum('yunfei');
        return $torder_yunfei;


    }

    //获取分店桶租金充值订单  返回之和
    public static function GetStoreTZOrder($store_id)
    {
        $where['orderCate'] = 4;
        $where['belong_store'] = $store_id;
        $where['status'] = 1;
        $orderStatus = [3,4];
        $begin_time = strtotime("-1 day");
        $end_time = time();
        $tzorder_yunfei = Db::name('order')->whereIn('orderStatus',$orderStatus)->where($where)->where('payTime','>=',$begin_time)->where('payTime','<=',$end_time)->sum('realTotalMoney');
        return $tzorder_yunfei;


    }

}
