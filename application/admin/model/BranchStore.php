<?php
namespace app\admin\model;
use think\Model;
class BranchStore extends Model
{
    //获取所有的数据
    public static function GetAll()
    {
    	$result = BranchStore::where('status',1)->order(['id'=>'desc'])->paginate(15);
    	return $result;
    }
     //礼盒分类的所有数据
    public static function GetBoxAll()
    {
        $result = BranchStore::where('status',0)->order('id', 'desc')->paginate(15);
        return $result;
    }
    //数据包
    public static function GetDataAll()
    {
        $result = BranchStore::all(['status'=>1]);
        return $result;
    }
    //礼盒分类数据包
    public static function GetBoxDataAll()
    {
        $result = BranchStore::all(['status'=>0]);
        return $result;
    }
    /**
     * 查找用户的单个数据
     */
    public static function GetOne($id)
    {
        $result = BranchStore::find($id);
        return $result;
    }
    //执行添加
    public static function AddData($data)
    {
        $BranchStore = New BranchStore;

        $result = $BranchStore->validate('BranchStoreValidate')->save($data);
        if ($result === false) {
            return  json_encode(["code"=>0,"meg"=>$BranchStore->getError()]);
        }else{
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }
    }
    //执行修改
    public static function UpdateData($id,$data)
    {
        $BranchStore = New BranchStore;

        $result = $BranchStore->validate('BranchStoreValidate')->save($data,['id'=>$id]);
        // halt($BranchStore->getLastSql());
        if ($result) {
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }else{
            return json_encode(["code"=>0,"meg"=>"操作失败"]);
        }


    }
    //执行删除
    public static function DeleteData($id)
    {
        $result = BranchStore::destroy($id);
        return $result;
    }

    //二期

    /**
     * 查找用户的单个数据
     */
    public static function GetOneInfo($where)
    {
        $result = BranchStore::where($where)->find();
        return $result;
    }

}