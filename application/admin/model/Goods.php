<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use think\Cookie;
use app\admin\model\StoreStock;
class Goods extends Model
{
    //获取所有的数据
    public static function GetAll()
    {
        $result = Db::name('goods')
                    ->alias('g')
                    ->join('Category c','c.id = g.cid','left')
                    ->join('store_stock ss','ss.goods_id = g.id','left')
                    ->join('branch_store bs','bs.id = g.belong_store','left')
                    ->order('g.status desc','g.id desc')
                    ->field('g.*,c.name,ss.stock as goods_stock,bs.name as store_name')
                    ->where('g.belong_store','neq','')
                    ->paginate(15);
        //	商品月销量
//        $last_month_time = strtotime("-1 month");
//        foreach ($result as $k=>$v) {
//
//            $storeStock = StoreStock::where('goods_id',$v['id'])
//                ->find();
//            $stock = Db::name('store_stock_logs')->where('goods_id',$v['id'])->where('create_time','>=',$last_month_time)->sum('add_num');
//            $result[$k]['yuexiao'] = $stock-$storeStock['stock'];
//        }
        
    	return $result;
    }

    //接口数据
    public static function GetAllApi()
    {
        $result = Goods::all();
        return $result;
    }
    /**
     * 查找用户的单个数据
     */
    public static function GetOne($id,$uid=null)
    {
//        $result = Goods::find($id);
//            二期  分店取库存
        $result = StoreStock::alias('ss')
                    ->join('goods g','g.id = ss.goods_id','right')
                    ->where('g.id',$id)
                    ->field('g.*,ss.stock as store_stock')
                    ->find();
        $result['stock'] = $result['store_stock'];
        if ($result) {

            if ($uid && $uid != 'null') {
                
                // 会员等级
                $level = Db::name('user')->where('id',$uid)->value('level');
                
                if ($level) {

                    switch ($level) {
                        case 1:
                            $result['level'] = '普通会员';
                            $result['money'] = $result['ordinaryMoney'];
                            break;
                        case 2:
                            $result['level'] = '银卡会员';
                            $result['money'] = $result['silverCardMoney'];
                            break;
                        case 3:
                            $result['level'] = '金卡会员';
                            $result['money'] = $result['goldenCardMoney'];
                            break;
                    }
                }

            }
            // 分类
            $result['catName'] = Db::name('category')->where('id',$result['cid'])->value('name');
            // 运费
            $result['yunfei']  = Db::name('config')->where('id',1)->value('freight');

            $result['cangchu'] = Db::name('config')->where('id',1)->value('warehousing');
        
        }

        return $result;
    }

    //执行添加
    public static function AddData($data)
    {
        $Goods = New Goods;

        $result = $Goods->validate('GoodsValidate')->save($data);

        if ($result === false) {
            return  json_encode(["code"=>1,"meg"=>$Goods->getError()]);
        }else{
            return json_encode(["code"=>0,"meg"=>"操作成功"]);
        }
    }
    //执行修改
    public static function UpdateData($id,$data,$type = 0)
    {
        $Goods = New Goods;
        if ($type == 1) {
            $result = $Goods->save($data,['id'=>$id]);
        } else {
            $result = $Goods->validate('GoodsValidate')->save($data,['id'=>$id]);
        }
        
        // dump($Goods->getLastSql());
        // dump($result);die();
        if ($result) {
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }else{
            return json_encode(["code"=>1,"meg"=>$Goods->getError()]);
        }

    }
    //执行删除
    public static function DeleteData($id)
    {
        $result = Goods::destroy($id);
        return $result;
    }

    /**
     * 二期
     */

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 通过id获取单个产品
     */
    public function getOneGoods($id){
        return Goods::where('id',$id)->find();
    }

    /**
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * 分站使用的查看产品
     */
    public function getAllGoods($store_id){
//         $rs = Goods::paginate(10);
//         $rs->toArray();

        $rs = Db::name('goods')
            ->alias('g')
            ->join('Category c','c.id = g.cid')
            ->order('g.status desc','g.id desc')
            ->field('g.*,c.name')
            ->where('belong_store',$store_id)
            ->paginate(15);

        //	商品月销量
        $last_month_time = strtotime("-1 month");
         foreach($rs as $k=>$v){
            $data = [];
            $data = $v;

            $storeStock = StoreStock::where('store_id',$store_id)
                ->where('goods_id',$data['id'])
                ->find();
             $stock = Db::name('store_stock_logs')->where('goods_id',$data['id'])->where('store_id',$store_id)->where('create_time','>=',$last_month_time)->sum('add_num');
             $data['yuexiao'] = 50;
            if(!empty($storeStock)){
                $data['cost'] = '￥'.$storeStock['cost'];
                $data['stock'] = $storeStock['stock'];
                $data['is_recom'] = $storeStock['is_recom'];
            }else{
                $data['cost'] = '';
                $data['stock'] = '';
                $data['is_recom'] = 0;
            }
            $rs->offsetSet($k,$data);
         }
        return $rs;
    }


    //二期
    //通过用户id查询店铺区片商店id
    public function getStoreRegion($uid)
    {
        //user_address.cid=address.id=region.address=branch_store.region

        //获取用户地址中default=1的cid
        $cid = UserAddress::where('uid', $uid)->where('is_default', 1)->find();
        //无默认default则选择最晚添加的地址
        if (empty($cid)) {
            $cid = UserAddress::where('uid', $uid)->order('id', 'desc')->find();
        }
        //通过用户地址cid获取地址表中的id
        $id = Address::where('id', $cid['cid'])->find();
        //通过地址表中的id获取范围区片
        $address = Region::field('id')->where('address', 'like', '%' . $id['id'] . '%')->where('id','neq',53)->find();
        //通过范围区片获取分店
        $store = BranchStore::select();
        //如果范围区片为多个，被多个分店覆盖，则选择分店覆盖数量最高的

        foreach ($store as $k => $v) {
            $store_region = explode(',', $v['region']);
            array_pop($store_region);
            //查看是否存在里面
            if(in_array($address['id'],$store_region)){
                return $v['id'];
            }
        }
        return '';
    }

    public static function getStoreId()
    {
        $admin_id = Cookie::get('AdminUserId');
        $belong_store = db::name('branch_store')->where('admin_id',$admin_id)->value('id');
        if($belong_store){
            return $belong_store;
        }else{
            return 0;
        }

    }
}