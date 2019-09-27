<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 16:51
 */

namespace app\admin\model;


use think\Model;

class StoreStock extends Model
{
    /**
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取全部本分站库存
     */
    public function getAll($where){
        return StoreStock::where($where)
            ->order('id','desc')
            ->select();
    }

    /**
     * @param $where
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取本分站单个库存
     */
    public function getOne($where){
        return StoreStock::where($where)
            ->find();
    }

    /**
     * @param $data
     * @return bool|false|int
     * 添加商品库存到本分站
     */
    public function addStock($data){
        return StoreStock::save($data);
    }

    /**
     * @param $where
     * @param $data
     * @return StoreStock
     * 修改本分站单个库存
     */
    public function updataStock($where,$data){
        $data['updata_time'] = time();
        return StoreStock::where($where)
           ->update($data);
    }
}