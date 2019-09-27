<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 16:51
 */

namespace app\admin\model;


use think\Model;

class StoreStockLogs extends Model
{
    public function getAll($where){
        return StoreStockLogs::where($where)
            ->alias('ss')
            ->join('supplier s','ss.supplier_id = s.id','LEFT')
            ->order('ss.id','desc')
            ->field('ss.*,s.supplier_name')
            ->select();
    }

    public function getOneLogs($where){
        return StoreStockLogs::where($where)
            ->find();
    }

    public function addLogs($data){
        return StoreStockLogs::save($data);
    }
}