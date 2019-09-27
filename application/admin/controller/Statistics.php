<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\CommoditySalesStatistics;
use app\admin\model\RevenueDay;
use app\admin\model\BranchStore as BranchStoreModel;
use think\Db;

class Statistics extends Base
{
    //  品牌销量
    public function goods()
    {
        parent::CheckAdminLogin();

        $where = ' 1 = 1 '; // 搜索条件
        $pageParam    = ['query' =>[]];
        if (isset($_GET['time']) && $_GET['time']) {
            $begin_time = strtotime($_GET['time']);
            $end_time = strtotime(date("$_GET[time]-01", strtotime(date("Y-m-d"))) . " +1 month -1 day");
            $where .= "and statistical_time > $begin_time";
            $where .= " and statistical_time < $end_time";
            $pageParam['query']['time'] = $_GET['time'];

        }


        $data = CommoditySalesStatistics::GetDayDate($where,$pageParam);

        $parame = [
            'begin_time' => isset($_GET['time']) ? $_GET['time'] : '',
        ];
        $this->assign('parame', $parame);// 赋值分页输出

        return $this->fetch('Statistics/goods_index',[
            'list'=>$data,
        ]);

    }

    //  总店商品销量一级详情页
    public function goodsx_detail()
    {
        parent::CheckAdminLogin();
        $goods_name = $_GET['goods_name'];
        $month = $_GET['month'];
        $list = CommoditySalesStatistics::GetGoodsXiaoDetail($goods_name,$month);
        return $this->fetch('Statistics/goods_index_detail',['list'=>$list,'goods_name'=>$goods_name]);

    }

    //  总店商品销量二级详情页
    public function goodsx_details()
    {
        parent::CheckAdminLogin();
        $goods_name = $_GET['goods_name'];
        $month = $_GET['month'];
        $store_id = $_GET['store_id'];
        $list = CommoditySalesStatistics::GetGoodsXiaoDetails($goods_name,$month,$store_id);
        return $this->fetch('Statistics/goods_index_details',['list'=>$list,'goods_name'=>$goods_name]);

    }

    public function storegoodsx_detail()
    {
        parent::CheckAdminLogin();
        $goods_name = $_GET['goods_name'];
        $month = $_GET['month'];
        $store_id = $_GET['store_id'];
        $list = CommoditySalesStatistics::GetGoodsXiaoDetails($goods_name,$month,$store_id);
        return $this->fetch('Statistics/storegoods_index_detail',['list'=>$list,'goods_name'=>$goods_name]);
    }


    public function money()
    {

        parent::CheckAdminLogin();


        $ya_buckets = Db::name('order')->where('orderCate',2)->where('orderStatus',3)->where('isPay',1)->where('status',1)->sum('realTotalMoney');
        $tui_buckets = Db::name('order')->where('orderCate',3)->where('orderStatus',3)->where('isPay',1)->where('status',1)->sum('totalMoney');
        $buckets = $ya_buckets-$tui_buckets;//桶押金收益

        // 余额
        $money = Db::name('user')->where('identity',1)->sum('money');

        // 卡金
        $cardmoney = Db::name('user')->where('identity',1)->sum('cardMoney');

        $nomoney =  Db::name('user')->where('identity',1)->sum('noMoney');

        $yucun = $buckets+$money+$cardmoney+$nomoney;
        return $this->fetch('Statistics/money_count',[
            'buckets'=>$buckets,
            'cardmoney'=>$cardmoney,
            'money'=>$money,
            'nomoney'=>$nomoney,
            'yucun'=>$yucun,
        ]);

    }

    //    成本支出  type    1日2月3年
    public function expenditure()
    {
        parent::CheckAdminLogin();
        $type = $_GET['type'];
        if ($type ==1){
            $data = RevenueDay::GetDayExpenditure();
            return $this->fetch('Statistics/day_zhichu',[
                'list'=>$data,
            ]);

        }elseif ($type ==2){
            $data = RevenueDay::GetMonthExpenditure();
            return $this->fetch('Statistics/month_zhichu',[
                'list'=>$data,
            ]);

        }elseif ($type == 3){
            $data = RevenueDay::GetYearExpenditure();
            return $this->fetch('Statistics/year_zhichu',[
                'list'=>$data,
            ]);

        }

    }

    //    资金流水收益    type    1日2月3年
    public function capitalgains()
    {

        parent::CheckAdminLogin();
        $type = $_GET['type'];

        if ($type ==1){
            $data = RevenueDay::GetDayCapitalgains();
            return $this->fetch('Statistics/day_shouyi',[
                'list'=>$data,
            ]);

        }elseif ($type ==2){
            $data = RevenueDay::GetMonthCapitalgains();
            return $this->fetch('Statistics/month_shouyi',[
                'list'=>$data,
            ]);

        }elseif ($type == 3){
            $data = RevenueDay::GetYearCapitalgains();
            return $this->fetch('Statistics/year_shouyi',[
                'list'=>$data,
            ]);

        }

    }

    //    净收益统计     type    1日2月3年

    public function NetPofit()
    {
        parent::CheckAdminLogin();
        $type = $_GET['type'];

        if ($type ==1){
            $data = RevenueDay::GetDayNetPofit();
            return $this->fetch('Statistics/day_netpofit',[
                'list'=>$data,
            ]);

        }elseif ($type ==2){
            $data = RevenueDay::GetMonthNetPofit();
            return $this->fetch('Statistics/month_netpofit',[
                'list'=>$data,
            ]);

        }elseif ($type == 3){
            $data = RevenueDay::GetYearNetPofit();
            return $this->fetch('Statistics/year_netpofit',[
                'list'=>$data,
            ]);

        }

    }



}