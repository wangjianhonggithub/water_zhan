<?php
namespace app\admin\controller;
use think\Db;

class Supplier extends Base
{
    //供应商页面
    public function index()
    {
        parent::CheckAdminLogin();
        $data = Db::name('supplier')->where('status','1')->paginate(15);

        return $this->fetch('/Supplier/index',[
            'list'=>$data,
        ]);

    }

    public function add()
    {
        parent::CheckAdminLogin();

        return $this->fetch('/Supplier/add');
    }
    // 添加
    public function DoAdd()
    {
        $data = $_POST;
        $arr['supplier_name'] = $data['supplier_name'];
        $arr['created_at'] = time();
        $arr['updated_at'] = time();
        if(empty($arr['supplier_name'])) {
            return  json_encode(["code"=>0,"meg"=>"供应商名称不能为空"]);
        }
        $data = Db::name('supplier')->where('supplier_name',$arr['supplier_name'])->select();
        if(!empty($data)) {
            return  json_encode(["code"=>0,"meg"=>"供应商名称已存在"]);
        }

        $result = Db::name('supplier')->insert($arr);
        if ($result === false) {
            return  json_encode(["code"=>0,"meg"=>"操作失败"]);
        }else{
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }
    }

    // 供应商上货日志记录
    public function giveLogs()
    {
        $id = $_GET['id'];
        $supplier_name = $_GET['supplier_name'];
        $data = Db::name('store_stock_logs')
                    ->alias('ssl')
                    ->join('branch_store bs','ssl.store_id = bs.id','LEFT')
                    ->where('ssl.supplier_id',$id)
                    ->order('ssl.create_time','desc')
                    ->field('ssl.goods_name,ssl.add_num,ssl.total_money,ssl.create_time,bs.name')
                    ->paginate(15);

        return $this->fetch('/Supplier/logs',[
            'list'=>$data,
            'supplier_name'=>$supplier_name,
        ]);
    }

    public function delete()
    {
        $id = $_GET['id'];
        $data = Db::name('supplier')->where('id',$id)->find();
        if (!$data) {
            return json_encode(["code"=>0,"meg"=>"数据错误"]);
        }
        $result = Db::name('supplier')->where('id',$id)->update(['status'=>0,'updated_at'=>time()]);
        if ($result === false) {
            return  json_encode(["code"=>0,"meg"=>"操作失败"]);
        }else{
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }
    }
}