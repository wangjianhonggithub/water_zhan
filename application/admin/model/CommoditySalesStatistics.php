<?php
namespace app\admin\model;
use think\Cookie;
use think\Model;
use think\Db;


class CommoditySalesStatistics extends Model
{
    public static function GetDayDate($where,$pageParam)
    {



        $admin_type = Cookie::get('AdminUserType');
        if ($admin_type == 1) {
            //  总后台
            $result = CommoditySalesStatistics::where($where)
                ->group('goods_name,month')
                ->order('statistical_time','desc')
                ->paginate('15', false, $pageParam);
            foreach ($result as $k=>$v) {
                $list = Db::name('commodity_sales_statistics')->where('goods_name',$v['goods_name'])->where('month',$v['month'])->select();
                $result[$k]['sale_num'] = 0;
                $result[$k]['cost'] = 0;
                $result[$k]['warehousing_get'] = 0;
                $result[$k]['distribution_fee_profit'] = 0;
                foreach ($list as $key=>$value){
                    $result[$k]['sale_num'] += $value['sale_num'];
                    $result[$k]['cost'] += $value['cost'];
                    $result[$k]['warehousing_get'] += $value['warehousing_get'];
                    $result[$k]['distribution_fee_profit'] += $value['distribution_fee_profit'];
                }
            }

        } else {
            //  分店
            $admin_id = Cookie::get('AdminUserId');
            $store_id = Db::name('branch_store')->where('admin_id',$admin_id)->value('id');
            $result = CommoditySalesStatistics::where($where)
                ->group('goods_name,month')
                ->where('store_id',$store_id)
                ->order('statistical_time','desc')
                ->paginate('15', false, $pageParam);
            foreach ($result as $k=>$v) {
                $list = Db::name('commodity_sales_statistics')->where('goods_name',$v['goods_name'])->where('store_id',$v['store_id'])->where('month',$v['month'])->select();
                $result[$k]['sale_num'] = 0;
                $result[$k]['cost'] = 0;
                $result[$k]['warehousing_get'] = 0;
                $result[$k]['distribution_fee_profit'] = 0;
                foreach ($list as $key=>$value){
                    $result[$k]['sale_num'] += $value['sale_num'];
                    $result[$k]['cost'] += $value['cost'];
                    $result[$k]['warehousing_get'] += $value['warehousing_get'];
                    $result[$k]['distribution_fee_profit'] += $value['distribution_fee_profit'];
                }
            }
        }
        return $result;
    }


    public static function GetGoodsXiaoDetail($goods_name,$month)
    {
        $result = CommoditySalesStatistics::alias('css')
            ->join('branch_store bs','bs.id = css.store_id')
            ->where('css.goods_name',$goods_name)
            ->where('css.month',$month)
            ->group('bs.id')
            ->field('css.*,bs.name as store_name,bs.id as store_id')
            ->paginate('15');

        foreach ($result as $k=>$v) {
            $list = Db::name('commodity_sales_statistics')->where('goods_name',$v['goods_name'])->where('store_id',$v['store_id'])->where('month',$v['month'])->select();
            $result[$k]['sale_num'] = 0;
            $result[$k]['cost'] = 0;
            $result[$k]['warehousing_get'] = 0;
            $result[$k]['distribution_fee_profit'] = 0;
            foreach ($list as $key=>$value){
                $result[$k]['sale_num'] += $value['sale_num'];
                $result[$k]['cost'] += $value['cost'];
                $result[$k]['warehousing_get'] += $value['warehousing_get'];
                $result[$k]['distribution_fee_profit'] += $value['distribution_fee_profit'];
            }
        }
        return $result;
    }

    public static function GetGoodsXiaoDetails($goods_name,$month,$store_id)
    {
        $result = CommoditySalesStatistics::alias('css')
            ->join('branch_store bs','bs.id = css.store_id')
            ->where('css.goods_name',$goods_name)
            ->where('css.month',$month)
            ->where('bs.id',$store_id)
            ->field('css.*,bs.name as store_name,bs.id as store_id')
            ->order('css.statistical_time','desc')
            ->paginate('15');


        return $result;
    }

}