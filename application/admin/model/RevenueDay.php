<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class RevenueDay extends Model
{
    public static function GetList($where,$pageParam)
    {

        $list = RevenueDay::alias('rd')
                            ->join('branch_store bs','rd.store_id = bs.id','LEFT')
                            ->field('rd.*,bs.name')
                            ->where($where)
                            ->order('rd.statistical_time','desc')
                            ->paginate('15', false, $pageParam);
        foreach ($list as $k=> $v) {
            $profit = json_decode($v['profit'],true);
            unset($profit['lose_bucket']);
            $list[$k]['profit'] = $profit;//收益
            $list[$k]['expenditure'] = json_decode($v['expenditure'],true);//支出
            $list[$k]['net_profit'] = array_sum($list[$k]['profit'])-array_sum($list[$k]['expenditure']);//净盈利
        }
        return $list;
    }

    public static function GetStoreList($store_id,$where,$pageParam)
    {
        $list = RevenueDay::where('store_id',$store_id)
            ->where($where)
            ->order('statistical_time','desc')
            ->paginate('15', false, $pageParam);
        foreach ($list as $k=> $v) {
            $profit = json_decode($v['profit'],true);
            unset($profit['lose_bucket']);
            unset($profit['yunfei']);
            unset($profit['rent_income']);
            unset($profit['goods_cost']);
            $list[$k]['profit'] = $profit;//收益
            $expenditure = json_decode($v['expenditure'],true);//支出
            unset($expenditure['commodity_cost']);
            unset($expenditure['song_salary']);
            $list[$k]['expenditure'] = $expenditure;
            $list[$k]['net_profit'] = array_sum($list[$k]['profit'])-array_sum($list[$k]['expenditure']);//净盈利
        }
        return $list;
    }


    public static function GetDayExpenditure()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('statistical_time')
            ->paginate('15');
        foreach ($list as $k=> $v) {
            $data = Db::name('revenue_day')->where('statistical_time',$v['statistical_time'])->select();
            $list[$k]['commodity_cost'] = 0;
            $list[$k]['rent_cost'] = 0;
            $list[$k]['electricity_fees'] = 0;
            $list[$k]['charge_for_water'] = 0;
            $list[$k]['admin_salary'] = 0;
            $list[$k]['song_salary'] = 0;
            foreach ($data as $key=>$value){
                $commodity_cost = json_decode($value['expenditure'],true);
                $list[$k]['commodity_cost'] += $commodity_cost['commodity_cost'];
                $list[$k]['rent_cost'] += $commodity_cost['rent_cost'];
                $list[$k]['electricity_fees'] += $commodity_cost['electricity_fees'];
                $list[$k]['charge_for_water'] += $commodity_cost['charge_for_water'];
                $list[$k]['admin_salary'] += $commodity_cost['admin_salary'];
                $list[$k]['song_salary'] += $commodity_cost['song_salary'];
            }
        }
        return $list;

    }

    public static function GetMonthExpenditure()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('month')
            ->paginate('15');
        foreach ($list as $k=> $v) {
            $data = Db::name('revenue_day')->where('month',$v['month'])->select();
            $list[$k]['commodity_cost'] = 0;
            $list[$k]['rent_cost'] = 0;
            $list[$k]['electricity_fees'] = 0;
            $list[$k]['charge_for_water'] = 0;
            $list[$k]['admin_salary'] = 0;
            $list[$k]['song_salary'] = 0;
            foreach ($data as $key=>$value){
                $commodity_cost = json_decode($value['expenditure'],true);
                $list[$k]['commodity_cost'] += $commodity_cost['commodity_cost'];
                $list[$k]['rent_cost'] += $commodity_cost['rent_cost'];
                $list[$k]['electricity_fees'] += $commodity_cost['electricity_fees'];
                $list[$k]['charge_for_water'] += $commodity_cost['charge_for_water'];
                $list[$k]['admin_salary'] += $commodity_cost['admin_salary'];
                $list[$k]['song_salary'] += $commodity_cost['song_salary'];
            }
        }
        return $list;
    }

    public static function GetYearExpenditure()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('year')
            ->paginate('15');
        foreach ($list as $k=> $v) {
            $data = Db::name('revenue_day')->where('year',$v['year'])->select();
            $list[$k]['commodity_cost'] = 0;
            $list[$k]['rent_cost'] = 0;
            $list[$k]['electricity_fees'] = 0;
            $list[$k]['charge_for_water'] = 0;
            $list[$k]['admin_salary'] = 0;
            $list[$k]['song_salary'] = 0;
            foreach ($data as $key=>$value){
                $commodity_cost = json_decode($value['expenditure'],true);
                $list[$k]['commodity_cost'] += $commodity_cost['commodity_cost'];
                $list[$k]['rent_cost'] += $commodity_cost['rent_cost'];
                $list[$k]['electricity_fees'] += $commodity_cost['electricity_fees'];
                $list[$k]['charge_for_water'] += $commodity_cost['charge_for_water'];
                $list[$k]['admin_salary'] += $commodity_cost['admin_salary'];
                $list[$k]['song_salary'] += $commodity_cost['song_salary'];
            }
        }
        return $list;
    }

    public static function GetDayCapitalgains()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('statistical_time')
            ->paginate('15');
        foreach ($list as $k=> $v) {
            $data = Db::name('revenue_day')->where('statistical_time',$v['statistical_time'])->select();
            $list[$k]['yunfei'] = 0;
            $list[$k]['rent_income'] = 0;
            $list[$k]['cangchu'] = 0;
            $list[$k]['goods_diff'] = 0;
            $list[$k]['goods_cost'] = 0;
            $list[$k]['lose_bucket'] = 0;
            foreach ($data as $key=>$value){
                $commodity_cost = json_decode($value['profit'],true);
                $list[$k]['yunfei'] += $commodity_cost['yunfei'];
                $list[$k]['rent_income'] += $commodity_cost['rent_income'];
                $list[$k]['cangchu'] += $commodity_cost['cangchu'];
                $list[$k]['goods_diff'] += $commodity_cost['goods_diff'];
                $list[$k]['goods_cost'] += $commodity_cost['goods_cost'];
                $list[$k]['lose_bucket'] += $commodity_cost['lose_bucket'];
            }
        }
        return $list;

    }

    public static function GetMonthCapitalgains()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('month')
            ->paginate('15');
        foreach ($list as $k=> $v) {
            $data = Db::name('revenue_day')->where('month',$v['month'])->select();
            $list[$k]['yunfei'] = 0;
            $list[$k]['rent_income'] = 0;
            $list[$k]['cangchu'] = 0;
            $list[$k]['goods_diff'] = 0;
            $list[$k]['goods_cost'] = 0;
            $list[$k]['lose_bucket'] = 0;
            foreach ($data as $key=>$value){
                $commodity_cost = json_decode($value['profit'],true);
                $list[$k]['yunfei'] += $commodity_cost['yunfei'];
                $list[$k]['rent_income'] += $commodity_cost['rent_income'];
                $list[$k]['cangchu'] += $commodity_cost['cangchu'];
                $list[$k]['goods_diff'] += $commodity_cost['goods_diff'];
                $list[$k]['goods_cost'] += $commodity_cost['goods_cost'];
                $list[$k]['lose_bucket'] += $commodity_cost['lose_bucket'];
            }
        }
        return $list;

    }

    public static function GetYearCapitalgains()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('year')
            ->paginate('15');
        foreach ($list as $k=> $v) {
            $data = Db::name('revenue_day')->where('year',$v['year'])->select();
            $list[$k]['yunfei'] = 0;
            $list[$k]['rent_income'] = 0;
            $list[$k]['cangchu'] = 0;
            $list[$k]['goods_diff'] = 0;
            $list[$k]['goods_cost'] = 0;
            $list[$k]['lose_bucket'] = 0;
            foreach ($data as $key=>$value){
                $commodity_cost = json_decode($value['profit'],true);
                $list[$k]['yunfei'] += $commodity_cost['yunfei'];
                $list[$k]['rent_income'] += $commodity_cost['rent_income'];
                $list[$k]['cangchu'] += $commodity_cost['cangchu'];
                $list[$k]['goods_diff'] += $commodity_cost['goods_diff'];
                $list[$k]['goods_cost'] += $commodity_cost['goods_cost'];
                $list[$k]['lose_bucket'] += $commodity_cost['lose_bucket'];
            }
        }
        return $list;

    }

    public static function GetDayNetPofit()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('statistical_time')
            ->paginate('15');
        foreach ($list as $k=>$v)
        {
            $data = Db::name('revenue_day')->where('statistical_time',$v['statistical_time'])->select();
            $list[$k]['profit'] = 0;
            $list[$k]['expenditure'] = 0;
            $list[$k]['store_manager'] = 0;
            foreach ($data as $key=>$value){
                $profit = json_decode($value['profit'],true);
                $expenditure = json_decode($value['expenditure'],true);
                unset($profit['lose_bucket']);
                $list[$k]['profit'] += array_sum($profit);
                $list[$k]['expenditure'] += array_sum($expenditure);
                $netpofit = array_sum($profit)-array_sum($expenditure);
                if($netpofit > 0){
                    $admin_id = Db::name('branch_store')->where('id',$value['store_id'])->value('admin_id');
                    $royalty = Db::name('admin_users')->where('id',$admin_id)->value('royalty');
                    $list[$k]['store_manager'] += $netpofit*$royalty;
                }

            }

        }
        return $list;

    }

    public static function GetMonthNetPofit()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('month')
            ->paginate('15');
        foreach ($list as $k=>$v)
        {
            $data = Db::name('revenue_day')->where('month',$v['month'])->select();
            $list[$k]['profit'] = 0;
            $list[$k]['expenditure'] = 0;
            $list[$k]['store_manager'] = 0;
            foreach ($data as $key=>$value){
                $profit = json_decode($value['profit'],true);
                $expenditure = json_decode($value['expenditure'],true);
                unset($profit['lose_bucket']);
                $list[$k]['profit'] += array_sum($profit);
                $list[$k]['expenditure'] += array_sum($expenditure);
                $netpofit = array_sum($profit)-array_sum($expenditure);
                if($netpofit > 0){
                    $admin_id = Db::name('branch_store')->where('id',$value['store_id'])->value('admin_id');
                    $royalty = Db::name('admin_users')->where('id',$admin_id)->value('royalty');
                    $list[$k]['store_manager'] += $netpofit*$royalty;
                }

            }

        }
        return $list;

    }

    public static function GetYearNetPofit()
    {
        $list = RevenueDay::order('statistical_time','desc')
            ->group('year')
            ->paginate('15');
        foreach ($list as $k=>$v)
        {
            $data = Db::name('revenue_day')->where('year',$v['year'])->select();
            $list[$k]['profit'] = 0;
            $list[$k]['expenditure'] = 0;
            $list[$k]['store_manager'] = 0;
            foreach ($data as $key=>$value){
                $profit = json_decode($value['profit'],true);
                $expenditure = json_decode($value['expenditure'],true);
                unset($profit['lose_bucket']);
                $list[$k]['profit'] += array_sum($profit);
                $list[$k]['expenditure'] += array_sum($expenditure);
                $netpofit = array_sum($profit)-array_sum($expenditure);
                if($netpofit > 0){
                    $admin_id = Db::name('branch_store')->where('id',$value['store_id'])->value('admin_id');
                    $royalty = Db::name('admin_users')->where('id',$admin_id)->value('royalty');
                    $list[$k]['store_manager'] += $netpofit*$royalty;
                }

            }

        }
        return $list;

    }

}