<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\BranchStore as BranchStoreModel;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Order;
use app\admin\model\RevenueDay;
use think\Cookie;
use think\Db;

class Task extends Base
{
    public function start_task()
    {
        // 计划任务
//        $this->store_task();
//        $this->goods_task();
        $this->add_immediate();
    }
    // 分店支出收益统计(已不用)
    public function store_task()
    {
        Db::startTrans();
        try{
            $day_num = date("t");//获取当月天数

            $branch_store = BranchStoreModel::GetDataAll();
            foreach ($branch_store as $key=>$value) {
                //  收益
                $order = Order::GetStoreOrder($value['id']);
                $shouyi['yunfei'] = 0;//订单运费
                //  退桶运费
                $torder_yunfei = Order::GetStoreTOrder($value['id']);
                $shouyi['yunfei'] += $torder_yunfei;
                $shouyi['rent_income'] = Order::GetStoreTZOrder($value['id']);
                $shouyi['cangchu'] = 0;
                $shouyi['goods_diff'] = 0;
                $shouyi['lose_bucket'] = Order::GetLoseBucket();
                $zhichu['commodity_cost'] = 0;
                $song_royalty_num = 0;
                foreach ($order as $k=>$v) {
                    $shouyi['yunfei'] += $v['yunfei'];
                    $order_goods = db::name('order_goods')->where('orderNo',$v['orderNo'])->select();

                    $xiaoliang = 0;
                    foreach ($order_goods as $keys=>$values) {
                        // 商品成本
                        $cost = db::name('store_stock')->where('store_id',$value['id'])->where('goods_id',$values['goodsId'])->value('cost');
                        $xiaoliang += $values['goodsNum'];
                        $warehousing = db::name('config')->where('id',1)->value('warehousing');
                        $shouyi['cangchu'] += $xiaoliang*$warehousing;
                        //成本
                        $shouyi['goods_diff'] += abs($values['goodsPrice']-$cost)*$values['goodsNum'];
                        $zhichu['commodity_cost'] += $cost*$values['goodsNum'];
                        if ($v['deliverType'] == 1) {
                            $song_royalty_num += $values['goodsNum'];
                        }
                    }
                }

                // 支出
                if ($value['rent_cost']) {
                    $zhichu['rent_cost'] = round($value['rent_cost']/$day_num,2);
                } else {
                    $zhichu['rent_cost'] = 0;
                }
                if ($value['electricity_fees']) {
                    $zhichu['electricity_fees'] = round($value['electricity_fees']/$day_num,2);
                } else {
                    $zhichu['electricity_fees'] = 0;
                }
                if ($value['charge_for_water']) {
                    $zhichu['charge_for_water'] = round($value['charge_for_water']/$day_num,2);
                } else {
                    $zhichu['charge_for_water'] = 0;
                }
                $admin_salary = Db::name('admin_users')->where('id',$value['admin_id'])->value('salary');
                $admin_royalty = Db::name('admin_users')->where('id',$value['admin_id'])->value('royalty');
                if ($admin_salary) {
                    if ($admin_royalty) {
                        $day_shouyi = array_sum($shouyi)-array_sum($zhichu);
                        if($day_shouyi <= 0){
                            $admin_tichen = 0;
                        }else{
                            $admin_tichen = $admin_royalty*$day_shouyi;
                        }
                        $zhichu['admin_salary'] = round($admin_salary/$day_num+$admin_tichen,2);
                    }else{
                        $zhichu['admin_salary'] = round($admin_salary/$day_num,2);
                    }
                } else {
                    $zhichu['admin_salary'] = 0;
                }
                $extract = db::name('config')->where('id',1)->value('extract');
                $song_royalty = $song_royalty_num*$extract;
                $song_salary = Db::name('user')->where('status',1)->where('identity',3)->where('belong_to_store',$value['id'])->sum('price');
                $zhichu['song_salary'] = round($song_salary/$day_num+$song_royalty,2);

                // 入库
                $array['store_id'] = $value['id'];
                $profit = json_encode($shouyi);
                $expenditure = json_encode($zhichu);
//                $statistical_time = strtotime('-1 day');
                $statistical_time = strtotime(date('Y-m-d',strtotime("-1 day")));
                $month = date('Y').'-'.date('m');
                $year = date('Y');
                $created_at = time();
                $res = Db::name('revenue_day')->insert(['profit'=>$profit,'expenditure'=>$expenditure,'store_id'=>$value['id'],'statistical_time'=>$statistical_time,'month'=>$month,'year'=>$year,'created_at'=>$created_at]);

            }
            Db::commit();
            echo 'success';
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            echo $e;
        }


    }

    // 商品销量统计(已不用)
    public function goods_task()
    {
        $branch_store = BranchStoreModel::GetDataAll();
        $arr = array();
        foreach ($branch_store as $key=>$value) {
            $order = Order::GetStoreOrder($value['id']);
            foreach ($order as $K=>$v) {
                $order_goods = db::name('order_goods')->where('orderNo',$v['orderNo'])->select();
                $xiaoliang = 0;
                foreach ($order_goods as $keys=>$values) {
                    $data['goods_id'] = $values['goodsId'];
                    $data['goods_name'] = $values['goodsName'];
                    $xiaoliang += $values['goodsNum'];
                    $data['sale_num'] = $xiaoliang;
                    // 商品成本
                    $cost = db::name('store_stock')->where('store_id',$value['id'])->where('goods_id',$values['goodsId'])->value('cost');
                    $data['cost'] = $xiaoliang*$cost;
                    $warehousing = db::name('config')->where('id',1)->value('warehousing');
                    $yunfei = db::name('config')->where('id',1)->value('freight');
                    $data['warehousing_get'] = $xiaoliang*$warehousing;
                    if ($v['deliverType'] == 1) {
                        //  送货上门
                        $data['distribution_fee_profit'] = $xiaoliang*$yunfei;
                    }else{
                        //  自取
                        $data['distribution_fee_profit'] = 0;
                    }

                    $data['store_id'] = $value['id'];
                    $data['statistical_time'] = strtotime(date('Y-m-d',strtotime("-1 day")));
                    $data['created_at'] = time();

                    array_push($arr,$data);
                }

            }
        }
        $old = $arr;
        $unique_keys = array();
        foreach ($arr as $key => $value) {
            if (isset($unique_keys[$value["goods_id"]])) {
                $index = $unique_keys[$value["goods_id"]];
                foreach ($arr[$index] as $k => &$v) {
                    if ($k !== "goods_id") {
                        $v += $value[$k];
                    }
                }
                unset($arr[$key]);
            } else {
                $unique_keys[$value["goods_id"]] = $key;
            }
        }
        foreach ($old as $k=>$v) {
            foreach ($arr as $ks=>$vs){
                if($v['goods_id'] == $vs['goods_id']) {
                    $arr[$ks]['goods_name'] = $v['goods_name'];
                    $arr[$ks]['store_id'] = $v['store_id'];
                    $arr[$ks]['statistical_time'] = $v['statistical_time'];
                    $arr[$ks]['created_at'] = $v['created_at'];
                }
            }
        }
        if($arr) {
            $result = db::name('commodity_sales_statistics')->insertAll($arr);
            if ($result) {
                echo 'success';
            } else {
                echo 'error';
            }
        }


    }




    // 分店支出收益统计   时时统计，生成log
    public function add_immediate()
    {
        Db::startTrans();
        try{
            $day_num = (int)date("t");//获取当月天数

            $branch_store = BranchStoreModel::GetDataAll();
            foreach ($branch_store as $key=>$value) {

                $shouyi['yunfei'] = 0;
                $shouyi['rent_income'] = 0;
                $shouyi['cangchu'] = 0;
                $shouyi['goods_diff'] = 0;
                $shouyi['goods_cost'] = 0;
                $shouyi['lose_bucket'] = 0;
                $zhichu['commodity_cost'] = 0;

                // 支出
                if ($value['rent_cost']) {
                    $zhichu['rent_cost'] = (string)round($value['rent_cost']/$day_num,2);
                } else {
                    $zhichu['rent_cost'] = 0;
                }
                if ($value['electricity_fees']) {
                    $zhichu['electricity_fees'] = (string)round($value['electricity_fees']/$day_num,2);
                } else {
                    $zhichu['electricity_fees'] = 0;
                }
                if ($value['charge_for_water']) {
                    $zhichu['charge_for_water'] = (string)round($value['charge_for_water']/$day_num,2);
                } else {
                    $zhichu['charge_for_water'] = 0;
                }
                $admin_salary = Db::name('admin_users')->where('id',$value['admin_id'])->value('salary');
                if ($admin_salary) {
                    $zhichu['admin_salary'] = (string)round($admin_salary/$day_num,2);
                } else {
                    $zhichu['admin_salary'] = 0;
                }
                $zhichu['song_salary'] = 0;

                // 入库
                $array['store_id'] = $value['id'];
                $profit = json_encode($shouyi);
                $expenditure = json_encode($zhichu);
                $statistical_time = strtotime(date('Y-m-d',time()));
                $month = date('Y').'-'.date('m');
                $year = date('Y');
                $created_at = time();
                $res = Db::name('revenue_day')->insert(['profit'=>$profit,'expenditure'=>$expenditure,'store_id'=>$value['id'],'statistical_time'=>$statistical_time,'month'=>$month,'year'=>$year,'created_at'=>$created_at]);

            }
            Db::commit();
            echo 'success';
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            echo $e;
        }


    }

}