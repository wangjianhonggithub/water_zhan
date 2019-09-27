<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 11:19
 */

namespace app\admin\controller;
use app\admin\controller\Base;

use app\admin\model\StoreStock as StoreStockModel;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\StoreStockLogs;
use app\admin\model\BranchStore as BranchStoreModel;
use think\Cookie;
use think\Request;
use think\Db;

class StoreStock extends Base
{
    public function __initial(){
        $this->CheckAdminLogin();
    }

    public function index(){
        $storeStock = new StoreStockModel();
        $where['admin_id'] = Cookie::get('AdminUserId');
        $rs = $storeStock->getAll($where);
        $this->assign('rs',$rs);
        return $this->fetch('StoreStock/index');
    }


    /**
     * @param Request $request  goodsId
     * @return false|string
     * 添加商品 或 增加库存 到库存
     */
    public function goodsAdd(Request $request){
        $gd = new GoodsModel();
        //提交添加的产品到库存
        if($request->post()){
            $goodsId = $request->post();
            if(empty($goodsId['stock']) || empty($goodsId['money'])) {
                return json_encode(["code"=>0,"meg"=>"数据不完整"]);
            }
            if(empty($goodsId['supplier_id'])){
                return json_encode(["code"=>0,"meg"=>"请选择供应商"]);
            }
            //查询管理员是哪个分店
            $branchStore = new BranchStoreModel();
            $where['admin_id'] = Cookie::get('AdminUserId');
            $store = $branchStore->GetOneInfo($where);
            $storeStock = new StoreStockModel();
            //查询此分店在库存中是否有此商品
            $where = [];
            $where['store_id'] = $store['id'];
            $where['goods_id'] = $goodsId['goodsId'];
            $goods = $storeStock->getOne($where);
            if(!$goods){
                //无此商品则添加
                $goodsInfo = $gd->getOneGoods($goodsId['goodsId']);
                if($goodsInfo['status'] == 0){
                    return json_encode(["code"=>0,"meg"=>"此产品已下架"]);
                }
                //获取商品信息，添加到库存中
                if($goodsInfo){
                    $addData['store_id'] = $store['id'];
                    $addData['goods_id'] = $goodsInfo['id'];
                    $addData['goods_name'] = $goodsInfo['goods_name'];
                    $addData['stock'] = $goodsId['stock'];
                    $addData['cost'] = $goodsId['money'];
                    $addData['end_auth'] = Cookie::get('AdminUserId');
                    $addData['create_time'] = time();
                    $addData['updata_time'] = time();
                    $rs = $storeStock->addStock($addData);
                    if($rs){
                        //入库日志
                        $this->addLogs($store['id'],Cookie::get('AdminUserId'),$goodsInfo['id'],$goodsInfo['goods_name'],$addData['stock'],$goodsId['stock']*$goodsId['money'],$goodsId['supplier_id']);
                        return json_encode(["code"=>1,"meg"=>"已添加到库存中"]);
                    }else{
                        return json_encode(["code"=>0,"meg"=>"添加库存失败"]);
                    }
                }else{
                    return json_encode(["code"=>0,"meg"=>"获取信息失败"]);
                }
            }else{
                //有此商品修改数量
//                $where['end_auth'] = Cookie::get('AdminUserId');
                $where['goods_id'] = $goods['goods_id'];
                $upData['stock'] = $goodsId['stock']+$goods['stock'];
                $upData['cost'] = $goodsId['money'];
                $storeStock->updataStock($where,$upData);
                //log记录
                $this->addLogs($store['id'],Cookie::get('AdminUserId'),$goods['goods_id'],$goods['goods_name'],$goodsId['stock'],$goodsId['stock']*$upData['cost'],$goodsId['supplier_id']);
                return json_encode(["code"=>1,"meg"=>"库存已更新"]);
            }
        }
        $goodsId = $request->get();
        $rs = $gd->getOneGoods($goodsId['goods_id']);
        $supplier = Db::name('supplier')->where('status','1')->select();
        $this->assign('rs',$rs);
        $this->assign('supplier',$supplier);
        return $this->fetch('StoreStock/goods_add');
    }

    /**
     * @param Request $request
     * @return mixed
     * 查询本分点某个产品库存进货记录
     */
    public function storeLogs(Request $request){
        $getData = $request->get();
        $ssl = new StoreStockLogs();
        $where['store_id'] = $getData['store_id'];
        $where['goods_id'] = $getData['goods_id'];
        $rs = $ssl->getAll($where);
        $this->assign('rs',$rs);
        return $this->fetch('StoreStock/stock_logs');
    }


    /**
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 更改热销状态
     */
    public function updataRecom(Request $request){
        $postData = $request->post();

        $storeStock = new StoreStockModel();
        $where['goods_id'] = $postData['goods_id'];
        $where['store_id'] = $postData['store_id'];
        $storeGoods = $storeStock->getOne($where);
        if($storeGoods){
            $storeGoods['is_recom']==0?$data['is_recom']=1:$data['is_recom']=0;
            $rs = $storeStock->updataStock($where,$data);
            if($rs){
                return json_encode(["code"=>1,"meg"=>"已修改"]);
            }else{
                return json_encode(["code"=>0,"meg"=>"修改失败"]);
            }
        }else{
            return json_encode(["code"=>0,"meg"=>"修改失败，暂无产品"]);
        }
    }
}