<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 11:19
 */

namespace app\admin\controller;
use think\Cookie;
use think\Loader;
use app\admin\controller\Base;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Category as CategoryModel;
use app\admin\model\BranchStore as BranchStoreModel;
use app\admin\model\BucketCategory as BucketCategoryModel;

class StoreGoods extends Base
{
    /**
     * @return mixed
     * 查看所有产品
     */

    public function index(){
        parent::CheckAdminLogin();
        //查询管理员是哪个分店
        $branchStore = new BranchStoreModel();
        $where['admin_id'] = Cookie::get('AdminUserId');
        $store = $branchStore->GetOneInfo($where);
        $goods = new GoodsModel();
        $rs = $goods->getAllGoods($store['id']);
        $page = $rs->render();
        $this->assign('store',$store);
        $this->assign('rs',$rs);
        $this->assign('page',$page);
        return $this->fetch('StoreGoods/index');
    }

    /**
     * 商品添加页面
     * @Author   CarLos(wang)
     * @DateTime 2018-06-04
     * @Email    carlos0608@163.com
     */
    public function add()
    {   $bucketCategory = new BucketCategoryModel();
        $bucketList = $bucketCategory->GetDataAll();
        $data = CategoryModel::GetDataAll();
        return $this->fetch('StoreGoods/add',[
            'list'=>$data,
            'bucketList'=>$bucketList
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
//        if (request()->file('thumb_img')) {
//            $data['thumb_img'] = parent::UploadTirImg('thumb_img');
//        }else{
//            echo json_encode(["code"=>2,"meg"=>"请选择要上传的图片"]);
//            die;
//        }

        $data['belong_store'] = GoodsModel::getStoreId();
        $data['create_time'] = time();
        $data['update_time'] = time();
        $result = GoodsModel::AddData($data);
        echo $result;
    }

    /**
     * 显示修改
     * @Author   CarLos(wang)
     * @DateTime 2018-06-04
     * @Email    carlos0608@163.com
     * @param    [type]             $id [description]
     * @return   [type]                 [description]
     */
    public function update($id)
    {
        $bucketCategory = new BucketCategoryModel();
        $bucketList = $bucketCategory->GetDataAll();
        $data = CategoryModel::GetDataAll();
        $update = GoodsModel::GetOne($id);
        $where['id'] = $update['bucket_category'];
        $bucke = $bucketCategory->findCategory($where);
        return $this->fetch('StoreGoods/update',[
            'list'=>$data,
            'update'=>$update,
            'bucketList'=>$bucketList,
            'bucke'=>$bucke
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
        $id = $_GET['id'];
        $data = $_POST;
        if (request()->file('file')) {
            $data = parent::UploadTirImg('file');
            echo $data;
        }
        if (request()->file('thumb_img')) {
            $data['thumb_img'] = parent::UploadTirImg('thumb_img');
        }

        $data['update_time'] = time();
        $result = GoodsModel::UpdateData($id,$data);

        echo $result;
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
        $result = GoodsModel::DeleteData($id);
        if ($result) {
            echo json_encode(["code"=>0,"meg"=>"操作成功"]);
        }else{
            echo json_encode(["code"=>1,"meg"=>"操作失败"]);
        }
    }
    /**
     * 展示查看
     * @Author   CarLos(wang)
     * @DateTime 2018-06-04
     * @Email    carlos0608@163.com
     * @param    [type]             $id [description]
     * @return   [type]                 [description]
     */
    public function show($id)
    {
        $data = CategoryModel::GetDataAll();
        $update = GoodsModel::GetOne($id);
        //查询空桶归类
        $bucketCategory = new BucketCategoryModel();
        $where['id'] = $update['bucket_category'];
        $bucketType = $bucketCategory->findCategory($where);
        if(empty($bucketType))$bucketType = '暂无分类';
        return $this->fetch('StoreGoods/show',[
            'list'=>$data,
            'update'=>$update,
            'bucketType' => $bucketType

        ]);
    }

}