<?php 
namespace app\api\controller\v1;
/**
* 用户接口
*/
use think\Controller;
use think\Db;
use app\admin\model\Address as AddressModel;
use app\admin\model\User as UserModel;
use app\api\service\UserToken;
use app\admin\model\Order as OrderModel;
use app\admin\model\BranchStore as BranchStoreModel;
class User extends Controller
{
	/**
	 * 小程序登录接口
	 * @Author   CarLos(翟)
	 * @DateTime 2018-06-01
	 * @Email    carlos0608@163.com
	 * @param    string             $code      [description]
	 * @param    string             $nickName  [description]
	 * @param    string             $avatarUrl [description]
	 */
	public function UserToken($code='',$nickName='',$avatarUrl='')
	{
		$wx = new UserToken($code,$nickName,$avatarUrl);
        $user_id = $wx->get();
        return json_encode($user_id);
	}

	// 获取所有的有效分店
	public function GetAddress()
	{
		$Adds = Db::name('branch_store')->where('status', 1)->group('belong_area')->column('belong_area');

        echo json_encode(['code'=>'1001','meg'=>'获取成功','data'=>$Adds]);

	}

	// 获取默认的地址
	public function getDefault($uid) {

		$info = [];
		$info['id'] = 0;

		$res  = Db::name('user_address')->where(['uid'=>$uid,'is_default'=>1])->find();//value('id');
		
		if ($res) {
			$res['cname'] = Db::name('branch_store')->where('id',$res['belong_store'])->value('name');
			return json_encode($res);
		}
		
		return json_encode($info);
	}


	// 获取用户的地址
	public function AddressInfo($uid)
	{
		// 用户收货地址
		$Adds = Db::name('user_address')
                    ->where("uid=$uid")
                    ->order('create_time desc')
                    ->select();
        if ($Adds) {
        	foreach ($Adds as $k => $v) {
        	$Adds[$k]['key'] = $k;
        }
        }
        
		
		echo json_encode($Adds);
	}

	// 修改用户地址 地址详情
	public function AddressDetail($id)
	{

		if ($id == 'undefined') {
			$id = 0;
		} 
		// 用户收货地址
		$Adds = Db::name('user_address')
                    ->where("id=$id")
                    ->find();

        if ($Adds) {
        	
        	$Adds['cname'] = Db::name('branch_store')->where('id',$Adds['belong_store'])->value('name');
        	$Adds['belong_area'] = Db::name('branch_store')->where('id',$Adds['belong_store'])->value('belong_area');
        }
        
		echo json_encode($Adds);
	}


	// 设置默认收货地址、
	public function AddressDefault($id, $uid)
	{
		if (!$id && !$uid) {
			echo json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}
		try {
			Db::name('user_address')->where('uid',$uid)->update(['is_default'=>0]);

			Db::name('user_address')->where('id',$id)->update(['is_default'=>1]);

		} catch (\Exception $e) {
			
			echo json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
		
		}

	}

	/**
	 * 添加收货地址 @todo userid  
	 * @Author   CarLos(翟)
	 * @DateTime 2018-06-13
	 * @Email    carlos0608@163.com
	 */
	public function AddAddress()
	{	
		try {
			$data = array();
			// id
			if (isset($_GET['userid']) && $_GET['userid']) {
				$data['uid'] = $_GET['userid'];
			}
			// 姓名
			if (isset($_POST['name']) && $_POST['name']) {
				$data['name'] = $_POST['name'];
			}
			// 电话
			if (isset($_POST['mobile']) && $_POST['mobile']) {
				$data['mobile'] = $_POST['mobile'];
			}
			// 分店
			if (isset($_POST['belong_store']) && $_POST['belong_store']) {
			    $data['belong_store'] = $_POST['belong_store'];

			}
			// 详细地址
			if (isset($_POST['address']) && $_POST['address']) {
				$data['address'] = $_POST['address'];
			}
			self::CheckInfo($data);

			if (isset($_GET['id']) && $_GET['id'] && $_GET['id'] != 'undefined') {
				
				$id = $_GET['id'];

				$result = Db::name('user_address')->where('id', $id)->update($data);

			} else {
				
				$data['create_time'] = time();
				$result = Db::name('user_address')->insert($data);
			}
 
			if (!$result) {
				throw new \Exception("操作失败");# code...
			}else{
				echo json_encode(['code'=>'1001','meg'=>'操作成功','data'=>$result]);
			}
		} catch (\Exception $e) {
			echo json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
		}
	}
	/**
	 * 验证数据
	 * @Author   CarLos(翟)
	 * @DateTime 2018-06-13
	 * @Email    carlos0608@163.com
	 * @param    [type]             $data [description]
	 */
	private function CheckInfo($data)
	{
		if ($data['uid'] == null) {
			throw new \Exception("没有用户标识");# code...
		}
		if ($data['name'] == null) {
			throw new \Exception("填写收获人姓名");# code...
		}
		if ($data['mobile'] == null) {
			throw new \Exception("手机号没有写");# code...
		}
        if (!intval($data['mobile'])) {
            throw new \Exception("手机号有非法字符");# code...
        }
        if (!preg_match("/^1[34578]{1}\d{9}$/",$_POST['mobile'])) {
            throw new \Exception("手机号格式不对");# code...
        }
		if ($data['belong_store'] == null) {
			throw new \Exception("缺少分店");# code...
		}
		if ($data['address'] == null) {
			throw new \Exception("缺少详细地址");# code...
		}
	}

	// 提现申请
	public function tixian() 
	{

		try {
				$data = array();
				// id
				if (isset($_GET['userid']) && $_GET['userid']) {
					$data['uid'] = $_GET['userid'];
				}
				// 提现金额
				if (isset($_POST['money']) && $_POST['money']) {
					$data['money'] = $_POST['money'];
				}
				// 验证支付密码
				if (isset($_POST['password']) && $_POST['password']) {
					$res = Db::name('user')->where(['id'=>$data['uid'],'payment'=>md5($_POST['password'])])->find();
					if (!$res) {
						throw new \Exception("支付密码错误");
					}
				} else {
					throw new \Exception("请输入支付密码");
				}

				// 验证余额
				if (isset($_POST['money']) && $_POST['money']) {
					
					//正则验证
					
					if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', trim($_POST['money']))) {
						throw new \Exception("提现金额格式错误");
					}

					$money = Db::name('user')->where(['id'=>$data['uid']])->value('money');
					if ($money < $data['money']) {
						throw new \Exception("余额不足");
					}
				}

				$data['username']  = Db::name('user')->where('id',$data['uid'])->value('nickname');

				$data['mobile']    = Db::name('user')->where('id',$data['uid'])->value('mobile');

				$data['cardId']    = Db::name('card')->where(['uid'=>$data['uid'],'is_default'=>1])->value('id');

				self::TixianCheckInfo($data);

				$data['createTime'] = time();
			
				$result = Db::name('put_forward')->insert($data);

				// 扣除用户账户金额，生成账单明细
				$oldMoney = Db::name('user')->where('id',$data['uid'])->value('money');

				$newsMoney = $oldMoney - $data['money'];

				$userRes = Db::name('user')->where('id',$data['uid'])->update(['money'=>$newsMoney]);
				
				// 生成账单明细
				//线下消费
	            $detail    = '提现需求已申请24小时内会转到您提交卡号内'; 
	            $results    =  OrderModel::AddBill($data['uid'], 0 - $data['money'], $detail);

				if (!$result) {
					throw new \Exception("操作失败");# code...
				}else{
					echo json_encode(['code'=>'1001','meg'=>'申请成功','data'=>$result]);
				}
			} catch (\Exception $e) {
				echo json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
			}
	}


	public function yanzheng() 
	{
		try {
				$data = array();
				// id
				if (isset($_POST['uid']) && $_POST['uid']) {
					$data['uid'] = $_POST['uid'];
				}

				// 验证支付密码
				if (isset($_POST['password']) && $_POST['password']) {
					$data = Db::name('user')->where(['id'=>$data['uid']])->value('payment');
					if (!$data) {
						return json_encode(['code'=>'1080','meg'=>'您尚未设置支付密码']);
					}
				}

				// 验证支付密码
				if (isset($_POST['password']) && $_POST['password']) {
					$data = Db::name('user')->where(['id'=>$_POST['uid'],'payment'=>md5($_POST['password'])])->find();
					if (!$data) {
						throw new \Exception("支付密码错误");
					}
				} else {
					throw new \Exception("请输入支付密码");
				}
				return json_encode(['code'=>'1001','meg'=>'成功','data'=>$data]);
			} catch (\Exception $e) {
				return json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
			}
	}

	public function cacheStatus() 
	{
		try {
				$data = array();
				// id
				if (isset($_POST['uid']) && $_POST['uid']) {
					$data['uid'] = $_POST['uid'];
				}

				$data = Db::name('user')->where(['id'=>$data['uid']])->value('status');

				if ($data == 1) {
					return json_encode(['code'=>'1001','meg'=>'成功']);
				}
				return json_encode(['code'=>'1025','meg'=>'账号被冻结请与管理员联系！','data'=>$data]);
			} catch (\Exception $e) {
				return json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
			}
	}





	/**
	 * 验证数据 tixian
	 * @Author   CarLos(翟)
	 * @DateTime 2018-06-13
	 * @Email    carlos0608@163.com
	 * @param    [type]             $data [description]
	 */
	private function TixianCheckInfo($data)
	{
		if ($data['uid'] == null) {
			throw new \Exception("没有用户标识");# code...
		}
		if ($data['money'] == null) {
			throw new \Exception("填写提现金额");# code...
		}
	}

	public function UserInfo()
	{

		try {
			    $id = $_GET['id'];

			    if (!$id) {
					throw new \Exception("缺少商家标识");# code...
				}

				$userInfo = Db::name('user')->where(['id'=>$id,'status'=>1,'identity'=>2])->find();

				if (!$userInfo) {
					throw new \Exception("获取商家信息失败");# code...
				}

				$result = Db::name('info_show')->where('uid',$id)->field('uid,title,mobile,address,pic')->find();

				return json_encode(['code'=>'1001','meg'=>'成功','data'=>$result]);

			} catch (\Exception $e) {
				return json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
			}
	}

	public function billList()
	{

		try {
			    $Uid = $_GET['uid'];

			    if (!$Uid) {
					throw new \Exception("缺少用户标识");# code...
				}

				$result = Db::name('bill')->where(['uid'=>$Uid])->order('createTime desc')->select();

				if ($result) {
					foreach ($result as $key => $value) {
						$result[$key]['createTime'] = date('Y-m-d H:i:s',$value['createTime']);
					}
				}

				if (!$result) {
					throw new \Exception("获取信息失败");# code...
				}

				return json_encode(['code'=>'1001','meg'=>'成功','data'=>$result]);

			} catch (\Exception $e) {
				return json_encode(['code'=>'1025','meg'=>$e->getMessage(),'data'=>null]);
			}
	}
	
	public function SetUserLevel()
	{
		// 查询数据库所有会员信息
		$userList = Db::name('user')->where(['status'=>1,'identity'=>1,'identification'=>2])->select();
		// halt(Db::name('user')->getLastSql());
		if ($userList) {
			foreach ($userList as $key => $value) {

				// $newTime = ((($value['validity'] * 24*60*60) + strtotime($value['create_time'])) - time())/24/60/60;
				$newTime = $value['validity'] * 24*60*60 + $value['create_time'] - time();//((($value['validity'] * 24*60*60) + strtotime($value['create_time'])) - time())/24/60/60;
				$newsTime = $newTime / 24 / 60 / 60;

	            if ((int)$newsTime <= 0 ) {
	                //修改用户状态
	                Db::name('user')->where('id',$value['id'])->update(['level'=>1,'identification'=>1]);
	            }

			}
		}
		
	}
	

    //二期  根据用户所选地区返回对应门店
    public function GetStore($belong_area)
    {
        if (empty($belong_area)) {
            echo json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
        }
        $branch_store = Db::name('branch_store')->where('belong_area',$belong_area)->field('id,name,belong_area')->select();
        if ($branch_store) {
            echo json_encode(['code'=>'1001','meg'=>'获取成功','data'=>$branch_store]);
        } else {
            echo json_encode(['code'=>'1025','meg'=>'获取失败','data'=>null]);
        }

    }










	
}

?>