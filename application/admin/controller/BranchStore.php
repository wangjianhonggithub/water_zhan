<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\BranchStore as BranchStoreModel;
use app\admin\model\Region as RegionModel;
use app\admin\model\RevenueDay as RevenueDayModel;
use app\admin\model\AdminUsers as AdminUsersModel;
use app\admin\model\Order as OrderModel;
use app\admin\model\User as UserModel;
use app\admin\model\RevenueDay;
use think\Cookie;
use think\Db;

/**
* 商品分类
*/
class BranchStore extends Base
{
	/**
	 * 商品分类展示页面
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-04
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function index()
	{
		parent::CheckAdminLogin();
		$data = BranchStoreModel::GetAll();
//		return $this->fetch('BranchStore/index',[
//			'list'=>$data,
//		]);
	}
	/**
	 * 显示添加页面
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-04
	 * @Email    carlos0608@163.com
	 */
	public function add()
	{
        $list = RegionModel::getAll();
		return $this->fetch('BranchStore/add',[
            'list'=>$list,
        ]);
	}
	/**
	 * 执行添加
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-04
	 * @Email    carlos0608@163.com
	 */
	public function DoAdd()
	{
		$data = $_POST;
//		  if (request()->file('pic')) {
//             $data['pic'] = parent::UploadTirImg('pic');
//         }else{
//             echo json_encode(["code"=>2,"meg"=>"请选择要上传的图片"]);
//             die;
//         }

		$data['createTime'] = time();
		$result = BranchStoreModel::AddData($data);
		// dump($result);die();
		echo $result;
	}
	/**
	 * 显示修改页面
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-04
	 * @Email    carlos0608@163.com
	 * @param    [type]             $id [description]
	 * @return   [type]                 [description]
	 */
	public function update()
	{
	    $admin_id = Cookie::get('AdminUserId');
	    $admin = Db::name('admin_users')->where('id',$admin_id)->field('salary,royalty')->find();
	    $salary = $admin['salary'];
	    $royalty = $admin['royalty'];
	    $where['admin_id'] = $admin_id;
	    $store = BranchStoreModel::GetOneInfo($where);
		$data = BranchStoreModel::GetOne($store['id']);
		return $this->fetch('BranchStore/update',[
			'update'=>$data,
            'salary'=>$salary,
            'royalty'=>$royalty
		]);
	}
	/**
	 * 执行修改
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-04
	 * @Email    carlos0608@163.com
	 */
	public function DoUpdate()
	{
		$data = $_POST;

		$result = Db::name('branch_store')->where('id',$data['store_id'])->update(['charge_for_water'=>$data['charge_for_water'],'electricity_fees'=>$data['electricity_fees']]);
		
		if ($result) {
            echo json_encode(["code"=>1,"meg"=>"操作成功"]);
        } else {
            echo json_encode(["code"=>0,"meg"=>"操作失败"]);
        }
	}
	/**
	 * 执行删除
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-04
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function delete()
	{
		$id = $_GET['id'];
        $result = BranchStoreModel::DeleteData($id);
        if ($result) {
            echo json_encode(["code"=>0,"meg"=>"操作成功"]);
        }else{
            echo json_encode(["code"=>1,"meg"=>"操作失败"]);
        }
	}

	public function order()
	{
		$id = $_GET['id'];
		$order = $_GET['order'];
		$data = [];
		$data['order'] = $order;
        $result = BranchStoreModel::UpdateData($id,$data);
        if ($result) {
            echo json_encode(["code"=>0,"meg"=>"操作成功"]);
        }else{
            echo json_encode(["code"=>1,"meg"=>"操作失败"]);
        }
	}
    //加载分配页面
    public function distribution()
    {
        $id = $_GET['id'];
        $old_admin_id = $_GET['old_admin_id'];
        $store = BranchStoreModel::GetOne($id);
        // 获取所有店主
        $Shopkeeper = db('admin_users')->where('type',2)->select();
        return $this->fetch('empty_bucket/fenpei',[
            'list'=>$Shopkeeper,
            'store_id'=>$id,
            'store_name'=>$store['name'],
            'old_admin_id'=>$old_admin_id
        ]);
    }
    //   分配店主操作
    public function DoShopkeeper()
    {
        $data = $_POST;

        $result = db('branch_store')->where('id',$data['store_id'])->update(['admin_id'=>$data['admin_id']]);
        if ($result) {
            echo json_encode(["code"=>0,"meg"=>"操作成功"]);
        }else{
            echo json_encode(["code"=>1,"meg"=>"操作失败"]);
        }
    }
    // 加载分配片区页面
    public function DistributionArea()
    {
        $id = $_GET['id'];
        $store = BranchStoreModel::GetOne($id);
        $list = RegionModel::getAll();
        return $this->fetch('BranchStore/fenpei',[
            'list'=>$list,
            'store'=>$store,
            'store_name'=>$store['name'],
            'store_id'=>$id,
        ]);
    }
    //处理分配片区
    public function DoArea()
    {
        $data = $_POST;
        $result = db('branch_store')->where('id',$data['store_id'])->update(['region'=>$data['region']]);
        if ($result) {
            echo json_encode(["code"=>0,"meg"=>"操作成功"]);
        }else{
            echo json_encode(["code"=>1,"meg"=>"操作失败"]);
        }
    }

    // 分店收益
    public function profit()
    {
        $where = ' 1 = 1 '; // 搜索条件
        $pageParam    = ['query' =>[]];
        if (isset($_GET['time']) && $_GET['time']) {
            $begin_time = strtotime($_GET['time']);
            $end_time = strtotime(date("$_GET[time]-01", strtotime(date("Y-m-d"))) . " +1 month -1 day");
            $where .= "and statistical_time > $begin_time";
            $where .= " and statistical_time < $end_time";
            $pageParam['query']['time'] = $_GET['time'];

        }

        $admin_type = Cookie::get('AdminUserType');
        if ($admin_type == 1) {
            // 总管理员 获取全部分店
            $data = RevenueDayModel::GetList($where,$pageParam);
        } else {
            $admin_id = Cookie::get('AdminUserId');
            $store_id = db('branch_store')->where('admin_id',$admin_id)->value('id');
            $data = RevenueDayModel::GetStoreList($store_id,$where,$pageParam);
        }


        $parame = [
            'begin_time' => isset($_GET['time']) ? $_GET['time'] : '',
        ];
        $this->assign('parame', $parame);// 赋值分页输出


        return $this->fetch('BranchStore/profit',[
            'list'=>$data,
            'admin_type'=>$admin_type,
        ]);

    }

    //    总后台修改分店信息
    public function edit()
    {

        $id = $_GET['id'];
        $data = BranchStoreModel::GetOne($id);
        return $this->fetch('BranchStore/edit',[
            'data'=>$data,
        ]);
    }

    public function DoEdit()
    {
        $data = $_POST;
        $result = Db::name('branch_store')->where('id',$data['store_id'])->update(['name'=>$data['name'],'belong_area'=>$data['belong_area'],'intro'=>$data['intro'],'belong_area'=>$data['belong_area'],'rent_cost'=>$data['rent_cost']]);

        if ($result) {
            echo json_encode(["code"=>1,"meg"=>"操作成功"]);
        } else {
            echo json_encode(["code"=>0,"meg"=>"操作失败"]);
        }
    }


    public function bucketkucun()
    {
        $admin_id = Cookie::get('AdminUserId');
        $store_id = Db::name('branch_store')->where('admin_id',$admin_id)->value('id');
        if($store_id) {
            $kucun = Db::name('empty_barrey')->where('userId',$store_id)->select();
            return $this->fetch('BranchStore/kucun',[
               'kucun'=>$kucun,
                'store_id'=>$store_id
            ]);
        }

    }


//    店面管理
    public function management()
    {
        parent::CheckAdminLogin();
        $id = $_GET['id'];
        $admin_id = BranchStoreModel::GetOne($id);
        return $this->fetch('BranchStore/management',[
            'id'=>$id,
            'admin_id'=>$admin_id['admin_id'],
            'user_name'=>$admin_id['name']
        ]);
    }


//    分店自取订单列表
    public function storeOrder()
    {
        $store_id = $_GET['store_id'];
        $store_name = $_GET['store_name'];

        $where['belong_store'] = $store_id;
        $where['deliverType'] = 2;

        $data = Db::name('order')->where($where)->paginate('15');


        return $this->fetch('BranchStore/storeOrder',[
            'list'=>$data,
            'id'=>$store_id,
            'store_name'=>$store_name

        ]);

    }

    //    分店退款自取订单列表
    public function storeOrderTui()
    {
        $store_id = $_GET['store_id'];
        $store_name = $_GET['store_name'];
        $where['belong_store'] = $store_id;
        $where['orderStatus'] = 5;

        $data = Db::name('order')->where($where)->paginate('15');


        return $this->fetch('BranchStore/storeOrderTui',[
            'list'=>$data,
            'id'=>$store_id,
            'store_name'=>$store_name
        ]);

    }

    //   分店押桶记录
    public function storeOrderY()
    {
        parent::CheckAdminLogin();
        $store_id = $_GET['store_id'];
        $store_name = $_GET['store_name'];
        $type = $_GET['type'];
        $where['belong_store'] = $store_id;
        $where['orderCate'] = $type;

        $data = Db::name('order')->where($where)->paginate('15');


        return $this->fetch('BranchStore/depositRecord',[
            'list'=>$data,
            'id'=>$store_id,
            'store_name'=>$store_name,
            'type'=>$type
        ]);


    }

//    分店送水员
    public function storeuser()
    {

        parent::CheckAdminLogin();
        $store_id = $_GET['store_id'];
        $store_name = $_GET['store_name'];
        $where['identity'] = 3;
        $where['belong_to_store'] = $store_id;

        $data = Db::name('user')->where($where)->paginate('15');
        return $this->fetch('BranchStore/Song_index',[
            'list'=>$data,
            'id'=>$store_id,
            'store_name'=>$store_name
        ]);

    }

    public function goodsSale()
    {
        parent::CheckAdminLogin();
        $store_id = $_GET['store_id'];
        $store_name = $_GET['store_name'];

        $data = Db::name('commodity_sales_statistics')->where('store_id',$store_id)->order('statistical_time','desc')->paginate('15');
        return $this->fetch('BranchStore/goodsSale',[
            'list'=>$data,
            'id'=>$store_id,
            'store_name'=>$store_name
        ]);
    }
    public function zhichu()
    {
        parent::CheckAdminLogin();
        $store_id = $_GET['store_id'];
        $store_name = $_GET['store_name'];
        $where = ' 1 = 1 '; // 搜索条件
        $pageParam    = ['query' =>[]];

        $data = RevenueDay::GetStoreList($store_id,$where,$pageParam);
        return $this->fetch('BranchStore/zhichu',[
            'list'=>$data,
            'id'=>$store_id,
            'store_name'=>$store_name
        ]);
    }



}