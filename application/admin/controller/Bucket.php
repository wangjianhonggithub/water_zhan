<?php
namespace app\admin\controller;
use think\Loader;
use think\Db;
use app\admin\controller\Base;
use app\admin\model\Order as OrderModel;
use app\admin\model\Bucket as BucketModel;
class Bucket extends Base
{
	/**
	 * 订单列表
	 * @Author   CarLos(wang)
	 * @DateTime 2018-06-06
	 * @Email    carlos0608@163.com
	 * @return   [type]             [description]
	 */
    public function index()
    {	
    	parent::CheckAdminLogin();
    	$data = BucketModel::GetBucketList();
    	return $this->fetch('Bucket/bucketList',[
    		'list'=>$data,
    	]);
    }


    /*
     * 提醒
     */
    public function Tixing()
    {

        if (!isset($_GET['id']) || !$_GET['id']) {
            return json_encode(["code"=>1,"meg"=>"操作失败，参数错误"]);
        }

        $id = $_GET['id'];
        
        $result = BucketModel::Tixing($id);

        return $result;
    }

    /**
     * 水桶置换列表
     */
    public function substitution()
    {
        parent::CheckAdminLogin();
        $data = BucketModel::Substitution();
        return $this->fetch('Bucket/substitution',[
            'list'=>$data,
        ]);
    }

    /**
     * 水桶置换
     */
    public function substitutionAction($id)
    {
        parent::CheckAdminLogin();
        $data = BucketModel::substitutionAction($id);
        return $this->fetch('Bucket/substitutionAction',[
            'info'=>$data,
        ]);
    }

    /**
     * 水桶置换
     */
    public function Doshenhe($id)
    {
        parent::CheckAdminLogin();
        $data = BucketModel::Doshenhe($id);
        return $data;
    }
    

} 
