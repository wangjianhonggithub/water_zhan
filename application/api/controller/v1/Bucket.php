<?php 
namespace app\api\controller\v1;
/**
* 桶租金接口
*/
use think\Controller;
use think\Db;
use app\admin\model\Bucket as BucketModel;
use app\api\controller\v1\Base;
class Bucket extends Base
{
	/**
	 * 通租金列表
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-05
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function getList()
	{

		$uid = $_GET['uid'];
		if (!$uid) {
			echo json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		$order  = ['substitution'=>'desc','bStatus' => 'desc','createTime' => 'desc','id' => 'desc'];
		$data = BucketModel::where(['status'=>1, 'uid'=>$uid])->order($order)->select();//getALl();
	
		$list = collection($data)->toArray();

		if ($list) {
			foreach ($list as $key => $value) {
				# code...
				$list[$key]['day']  = (int)(($value['validity'] - time()) / 60 / 60 /24);

				if ($value['bucketType'] == 2) {
					$list[$key]['day'] = 1;
				}

				$list[$key]['key']  = $key;

				$list[$key]['selected']  = 0;
				
				$list[$key]['time'] = date('Y-m-d H:i:s',$value['createTime']);		
			}
		}

		echo json_encode(['code'=>'1001','meg'=>'获取成功','data'=>$list]);
	}

	//申请置换
	public function substitution()
	{	
		$bucket = new BucketModel();
		$ids = $_POST['ids'];
		if (!$ids) {
			return json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		if ($ids) {
			$buckets         = [];
            $bucketId        = explode (',',$ids);
            for ($i = 0; $i < count($bucketId); $i++) {
                $buckets[$i]['id']         = $bucketId[$i];
                $buckets[$i]['subStatus']  = 2;
            }

            $res = $bucket->saveAll($buckets);

            if ($res) {
            	return json_encode(['code'=>'1001','meg'=>'申请成功']);
            } else {
            	return json_encode(['code'=>'1025','meg'=>'申请失败']);
            }
		}

	}

	//终止置换租金
	public function setSubStatus()
	{	
		$bucket = new BucketModel();
		$id = $_POST['id'];
		if (!$id) {
			return json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		if ($id) {

			$res = $bucket->find($id);

			if ($res) {
				if($res['validity'] != 0){
					 //判断租金是否过期
					$validity = ($res['validity'] - time()) / 24 / 60 / 60;

					if ((int)$validity < 0) {
	                	return json_encode(['code'=>'1025','meg'=>'已逾期，请先补齐租金！']);
	                }
            	}	
                $result = Db::name('bucket')->where('id',$id)->update(['status'=>0,'subStatus'=>3]);

	            if ($result) {
	            	return json_encode(['code'=>'1001','meg'=>'申请成功']);
	            } else {
	            	return json_encode(['code'=>'1025','meg'=>'申请失败']);
	            }
			} else {
				return json_encode(['code'=>'1025','meg'=>'申请失败']);
			}
           
		}
	}

	//终止租金
	public function setBucketStatus()
	{
		$bucket = new BucketModel();
		$id = $_POST['id'];
		if (!$id) {
			return json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		if ($id) {

			$res = $bucket->find($id);

			if ($res) {

				if($res['validity'] != 0){
					//判断租金是否过期

					$validity = ($res['validity'] - time()) / 24 / 60 / 60;

					if ((int)$validity < 0) {
	                	return json_encode(['code'=>'1025','meg'=>'已逾期，请先补齐租金！']);
	                }
				}

                $result = Db::name('bucket')->where('id',$id)->update(['validity'=>0,'bucketType'=>2]);

	            if ($result) {
	            	return json_encode(['code'=>'1001','meg'=>'申请成功']);
	            } else {
	            	return json_encode(['code'=>'1025','meg'=>'申请失败']);
	            }
			} else {
				return json_encode(['code'=>'1025','meg'=>'申请失败']);
			}
           
		}
	}

	


	/**
	 * 通租金置换列表
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-05
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
	public function getLists()
	{

		$uid = $_GET['uid'];
		if (!$uid) {
			echo json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		$order  = ['substitution'=>'desc','bStatus' => 'desc','createTime' => 'desc','id' => 'desc'];
		$data = BucketModel::where(['status'=>0, 'uid'=>$uid, 'substitution'=>2,'subStatus'=>2])->order($order)->select();//getALl();
	
		$list = collection($data)->toArray();

		if ($list) {
			foreach ($list as $key => $value) {
				# code...
				$list[$key]['day']  = (int)(($value['validity'] - time()) / 60 / 60 /24);

				$list[$key]['key']  = $key;

				$list[$key]['selected']  = 0;
				
				$list[$key]['time'] = date('Y-m-d H:i:s',$value['createTime']);		
			}
		}

		echo json_encode(['code'=>'1001','meg'=>'获取成功','data'=>$list]);
	}

	public function bucketInfo()
	{
		
		if (!isset($_GET['uid']) || !$_GET['uid']) {
			echo json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		
		if ((!isset($_GET['id']) || !$_GET['id'])) {
			echo json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
		}

		$uid = $_GET['uid'];

		$id  = $_GET['id'];

		$info = BucketModel::where(['id'=>$id,'uid'=>$uid])->find();//getALl();

		if ($info) {

			if ($info['bucketType'] == 2) {
				$info['day']  = 0;
				$info['time'] = date('Y-m-d',$info['createTime']);	
			} else {
				# code...
				$info['day']  = (int)(($info['validity'] - time()) / 60 / 60 /24);
				
				$info['time'] = date('Y-m-d',$info['createTime']);		
			}

			

			echo json_encode(['code'=>'1001','meg'=>'获取成功','data'=>$info]);
	
		} else {
			echo json_encode(['code'=>'1025','meg'=>'获取失败','data'=>null]);
		}
	}

	public function testA()
	{
        $where = [];

        $where['status'] = 1;

        $result = Db::name('bucket')->where($where)->select();
        // $result = BucketModel::where($where)->order('substitution desc','validity asc')->select();

        if ($result) {
            foreach ($result as $key => $value) {

                $userInfo = Db::name('user')->where('id',$value['uid'])->find();

                $validity = ($value['validity'] - time()) / 24 / 60 / 60;

                $result[$key]['userName']   = $userInfo['nickname'];

                $result[$key]['mobile']     = $userInfo['mobile'];

                $result[$key]['createTime'] = date('Y-m-d H:i:s', $value['createTime']);

                $result[$key]['validity']    = (int)$validity;
                $result[$key]['validitys']   = $value['validity'];
   
                if ((int)$validity >= 0) {
                    unset($result[$key]);
                }

            }
        }
        // halt($result);
        $data = [];
        foreach ($result as $kk => $vv) {
        	$timeNumber = (0 - $vv['validity']) + 30;
        	$abc = $timeNumber * 24 * 60 * 60;
        	$data[$kk]['validity'] = $abc + $vv['validitys'];
        	$data[$kk]['id'] = $vv['id'];
        }
        // halt($data);
        $a = new BucketModel();
        $aaa = $a->saveAll($data);
        // halt($result);
	}


    //	二期  增加水桶遗失
    public function loseBucket()
    {
        Db::startTrans();

        try {
            if (!isset($_GET['uid']) || !$_GET['uid']) {
                return json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
            }

            if (!isset($_GET['ids']) || !$_GET['ids']) {
                return json_encode(['code'=>'1025','meg'=>'参数错误','data'=>null]);
            }



            $bucket = new BucketModel();
            $id = explode(',',$_GET['ids']);
            $uid = $_GET['uid'];

            $res  = Db::name('user_address')->where(['uid'=>$uid,'is_default'=>1])->find();
            if (!$res) {
                return json_encode(['code'=>'1025','meg'=>'请先设置默认收货地址','data'=>null]);
            }

            foreach ($id as $v) {
                $res = $bucket->find($v);
                if (!$res) {
                    return json_encode(['code'=>'1025','meg'=>'参数错误']);
                }
                //  核销押桶记录，并记录日志
                $result = Db::name('bucket')->where('uid',$uid)->where('id',$v)->update(['status'=>0]);
                if ($result) {
                    $log['user_id'] = $uid;
                    $log['for_user_id'] = $v;
                    $log['time'] = time();
                    $log['num'] = 1;
                    $log['goods_name'] = '用户遗失水桶';
                    $log['type'] = 3;
                    Db::name('logs')->insert($log);


                }
            }

            // 统计表记录
            $statistical_time = strtotime(date('Y-m-d',time()));
            $count = count($id);
            $revenue_day = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$res['belong_store'])->find();
            if($revenue_day) {
                $profit = json_decode($v['profit'],true);
                $profit['lose_bucket'] += $count;
                $profit = json_encode($profit);
                $res = Db::name('revenue_day')->where('statistical_time',$statistical_time)->where('store_id',$res['belong_store'])->update(['profit'=>$profit]);
            }


            Db::commit();
            return json_encode(['code'=>'1001','meg'=>'操作成功']);

        } catch (\Exception $e) {

             Db::rollback();
            return json_encode(['code'=>'1025','meg'=>$e->getMessage()]);
        }


    }
}

?>