<?php 
namespace app\api\controller\v1;
/**
* 商品列表接口
*/
use think\Controller;
use think\Db;
use app\admin\model\Goods as GoodsModel;
use app\api\controller\v1\Base;
use app\service\WechatQrcode;
use app\admin\model\Cart as CartModel;
use app\admin\model\User as UserModel;
use app\admin\model\BranchStore as BranchStoreModel;
class Goods extends Base
{
	function __construct($cache_time=180,$Pay_time=54000,$goodsid='')
	{
		//缓存时间
		$this->cache_time = $cache_time;
		//支付时间缓存
		$this->Pay_time = $Pay_time;
	}

    /**
     * @param 商品的id
     */
	public function GoodsInfo($goodsid,$uid,$cat = 1)
	{	

		try {
			if ($goodsid == null) {
                throw new \Exception("商品id不存在");	# code...
			}
			if (!intval($goodsid)){
                throw new \Exception("商品id类型不对");	# code...
            }
            
            // if (isset($_GET['cat']) && $_GET['cat']){
            // 	$cat = $_GET['cat'];
            // }
            $data = [];
            $result = GoodsModel::GetOne($goodsid,$uid);
            // 内容转换
            $result['goods_info'] = str_replace("/ueditor/php/upload/",'https://'.$_SERVER['HTTP_HOST']."/ueditor/php/upload/",stripslashes($result['goods_info']));

			if ($result){

                $goodsimg = explode(',',$result['goods_img']);
                $result->goods_img = $goodsimg;          
                $data['res'] = [$result];
                // 运费 仓储 总价
                $Cinfo = [];

                // 仓储
            	$Cinfo['cangchu']      = $result->cangchu;

            	// 运费
            	$Cinfo['yunfei']       = $result->yunfei;

            	// 返现
            	$Cinfo['fanxian']      = $result->money;

            	// 身份
            	$Cinfo['level']        = $result->level;

            	// 商品总价
            	$Cinfo['goods_total']  = $result->goods_pic;
            	if ($cat == 1) {
	               //订单总价
            		$Cinfo['total']        = $result->goods_pic + $result->yunfei + $result->cangchu;


	            } else {
	                //订单总价
            		$Cinfo['total']        = $result->goods_pic + $result->cangchu;
	            }
            
                $data['data']          = $Cinfo;

                return json_encode(['code'=>1001,'meg'=>'获取成功','data'=>$data]);
            }else{
			    throw new \Exception('数据未找到');
            }
		} catch (\Exception $e) {
			return json_encode(['code'=>1025,'meg'=>$e->getMessage()]);
		}
	}

	/**
	 * 首页热销商品展示
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-05
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function GoodsList($store_id)
	{
		$res = false;//cache('Goods');
//		 dump($uid);die;
		if ($res === false) {
            // 获取用户所选择的门店   store_id
//

                $Goods = Db::name('goods')
                    ->alias('g')
                    ->join('store_stock ss','ss.goods_id = g.id','right')
                    ->where("ss.is_recom=1 and g.status=1")
//                    ->where('g.belong_store','2')
                    ->where('g.belong_store',$store_id)
                    ->where('ss.stock','>',0)
                    ->order('g.create_time','desc')
                    ->field('g.id,g.goods_pic,g.goods_name,g.thumb_img,g.ordinaryMoney,g.silverCardMoney,g.goldenCardMoney,ss.stock')
                    ->select();
                //把数据打入缓存文件中
                cache('Goods', json_encode($Goods), $this->cache_time);
                echo json_encode($Goods);


		}else{
			echo $res;
		}
		
	}

	/**
	 * 商品分类展示
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-05
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function GoodsCategoryList($store_id)
	{
		$res = false;//cache('cList');//false;

		// dump($res);die;
		if ($res === false) {
		
		// 商品分类
		$cList = Db::name('category')
							->where('status = 1')
							->field('id,name')
							->order(['order'=>'desc','id'=>'desc'])
							->select();
        //	获取用户所选门店  store_id
		// 商品列表
		$goodsList = Db::name('goods')
                            ->alias('g')
                            ->join('store_stock ss','ss.goods_id = g.id','right')
							->where('g.status = 1')
//                            ->where('g.belong_store','2')
                            ->where('ss.stock','>',0)
                            ->where('g.belong_store',$store_id)
							->field('g.id,g.cid,g.goods_name,g.thumb_img,g.goods_pic,g.ordinaryMoney,g.silverCardMoney,g.goldenCardMoney,ss.stock')
							->select();
        $last_month_time = strtotime("-1 month");
		//拼接数据
		foreach ($cList as &$classinfo) {
			$classinfo['goods'] = [];
			foreach ($goodsList as $value) {
				
//				$value['yuexiao'] = 50;
                $stock = Db::name('store_stock_logs')->where('goods_id',$value['id'])->where('create_time','>=',$last_month_time)->sum('add_num');
                $value['yuexiao'] = 50;

				// $value['fanxian'] = 

				if ($value['cid'] == $classinfo['id']) {
					$classinfo['goods'][] = $value;
				}
			}
		}

		// dump($cList);die();
		//把数据打入缓存文件中
		cache('cList', json_encode($cList), $this->cache_time);
		echo json_encode($cList);
		}else{
			echo $res;
		}
		
	}

	/**
	 * 商品搜索
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-06
	 * @Email    carlos0608@163.com
	 */
	public function GoodsSeach($store_id)
	{
		$title = '';
        //	获取用户所选的门店  store_id
		if (isset($_GET['title']) && !empty($_GET['title'])) {
				$title = $_GET['title'];
			}
			$search['g.goods_name']  = ['like',"%$title%"];
			$search['g.status'] = 1;
			$data = Db::name('goods')
                    ->alias('g')
                    ->join('store_stock ss','ss.goods_id = g.id','right')
                    ->where($search)
//                    ->where('g.belong_store','2')
                    ->where('g.belong_store',$store_id)
                    ->where('ss.stock','>',0)
                    ->field('g.id,g.goods_name,g.thumb_img,g.ordinaryMoney,g.silverCardMoney,g.goldenCardMoney,ss.stock')
                    ->select();
            //	商品月销量
			$last_month_time = strtotime("-1 month");
            foreach ($data as $k=>$v) {
                $stock = Db::name('store_stock_logs')->where('goods_id',$v['id'])->where('create_time','>=',$last_month_time)->sum('add_num');
                $data[$k]['yuexiao'] = 50;

            }
		if($data){
			return json_encode(["code"=>1001,"meg"=>"获取数据成功","data"=>$data]);
		}else{
			return json_encode(["code"=>1025,"meg"=>"获取数据失败","data"=>""]);
		}
	}
	/**
	 * 生成二维码测试
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-21
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function ceshi()
	{
		$data = [
			'user_id' =>1,
			'is_type' =>0
		];
		$result = WechatQrcode::getWchatQrcode('http://127.0.0.1',5,$data);
		echo $result;
	}

	/**
	 * 添加购物车
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-22
	 * @Email    carlos0608@163.com
	 * @todo  uid 用户id   gid 商品id  num 数量 price 总价格
	 */
	public function AddShopCar()
	{
		try {
			$data = $_POST;
			self::CheckCartData($data);
			$data['create_time'] = time();
			$where = [
				'uid'=>$_POST['uid'],
				'gid'=>$_POST['gid'],
			];
			//检测购物车是否重复添加
			$findSelect = Db::name('cart')->where($where)->find();
			if ($findSelect) {
				//如果同一个用户添加过相同的商品的话
				$data['num'] =  $findSelect['num'] + $_POST['num']; 
				$data['price'] =  $findSelect['price'] + $_POST['price'];
				//如果重复添加的话修改数据库
				$saveCart = CartModel::UpdateData($findSelect['id'],$data);
				if ($saveCart) {
					echo json_encode(['code'=>1001,'message'=>'购物车添加成功']);
				}else{
					echo json_encode(['code'=>1025,'message'=>'购物车添加失败']);
				}
			}else{
				//如果没有重复添加的话执行添加购物车
				if (CartModel::AddData($data)) {
					echo json_encode(['code'=>1001,'message'=>'购物车添加成功']);
				}else{
					echo json_encode(['code'=>1025,'message'=>'购物车添加失败']);
				}
			}
		} catch (\Exception $e) {
			echo json_encode(['code'=>1025,'message'=>$e->getMessage()]);
		}
	}
	/**
	 * 删除购物车 
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-22
	 * @Email    carlos0608@163.com
	 * @todo  id 购物车id
	 */
	public function DeleteCart()
	{
		$id= $_GET['id'];
		$result = CartModel::DeleteData($id);
		if ($result) {
			echo json_encode(['code'=>1001,'message'=>'success']);
		}else{
			echo json_encode(['code'=>1025,'message'=>'error']);
		}
	}


	/**
	 * 验证添加购物车的数据
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-22
	 * @Email    carlos0608@163.com
	 */
	private function CheckCartData($data)
	{
		if (!intval($data['uid'])) {
			throw new \Exception("uid数据类型不正确");	# code...
		}
		if (!intval($data['gid'])) {
			throw new \Exception("gid数据类型不正确");	# code...
		}
		if (!intval($data['num'])) {
			throw new \Exception("num数据类型不正确");	# code...
		}
		return true;
	}
	/**
	 * 添加修改购物车
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-22
	 * @Email    carlos0608@163.com
	 * @todo  id  购物车id picone 单价
	 */
	public function AddUpdateCart()
	{
		try {
			self::checkFindCartData($_GET);
			$id = $_GET['id'];
			$findData = self::FindCart($id);
			$data['num'] = $findData['num']+1;
			$data['price'] = $findData['price']+$_GET['picone'];
			$saveCart = CartModel::UpdateData($id,$data);
			if ($saveCart) {
				echo json_encode(['code'=>1001,'message'=>'success']);
			}else{
				echo json_encode(['code'=>1025,'message'=>'error']);
			}
		} catch (\Exception $e) {
			echo json_encode(['code'=>1025,'message'=>$e->getMessage()]);
		}
	}
	/**
	 * 减少修改购物车
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-22
	 * @Email    carlos0608@163.com
	 */
	public function ReduUpdateCart()
	{
		try {
			self::checkFindCartData($_GET);
			$id = $_GET['id'];
			$findData = self::FindCart($id);
			if ($findData['num'] == 1) {
				throw new \Exception("最后一件了");	
			}
			$data['num'] = $findData['num']-1;
			$data['price'] = $findData['price']-$_GET['picone'];
			$saveCart = CartModel::UpdateData($id,$data);
			if ($saveCart) {
				echo json_encode(['code'=>1001,'message'=>'success']);
			}else{
				echo json_encode(['code'=>1025,'message'=>'error']);
			}	
		} catch (\Exception $e) {
			echo json_encode(['code'=>1025,'message'=>$e->getMessage()]);
		}
		
	}
	/**
	 * 查询购物车
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-22
	 * @Email    carlos0608@163.com
	 * @param    [type]             $id [description]
	 */
	private function FindCart($id)
	{
		$data = CartModel::GetOne($id);
		return $data;
	}
	/**
	 * 数据检测
	 */
	private function checkFindCartData($data)
	{
		if ($data['id'] == null || !intval($data['id'])) {
			throw new \Exception("参数id非法");	# code...
		}
		if ($data['picone'] == null || !isset($data['picone'])) {
			throw new \Exception("参数picone无效");	# code...
		}
		return true;
	}

	//二期
    //返回店铺id，以便后续分配送水片区
    public function showIndexStore(){
        $uid = $_GET['uid'];
        $goods = new GoodsModel();
        $rs = $goods->getStoreRegion($uid);
        if(empty($rs)){
            $rs = 53;//总控
        }
        return $rs;
    }

    // 二期
    public function ShowAllStore()
    {
        $data = Db::name('branch_store')->where('status',1)->field('id,name')->select();
        if($data){
            return json_encode(['code'=>1001,'meg'=>'获取成功','data'=>$data]);
        }
        return json_encode(['code'=>1025,'meg'=>'获取失败','data'=>null]);

    }

}
?>