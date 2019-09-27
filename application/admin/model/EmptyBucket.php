<?php
namespace app\admin\model;
use think\Model;
class EmptyBucket extends Model
{
    //获取所有的数据
    public static function GetAll()
    {
    	$result = EmptyBucket::where('status',1)->order(['order'=>'desc', 'id'=>'desc'])->paginate(15);
    	return $result;
    }
     //礼盒分类的所有数据
    public static function GetBoxAll()
    {
        $result = EmptyBucket::where('status',0)->order('id', 'desc')->paginate(15);
        return $result;
    }
    //数据包
    public static function GetDataAll()
    {
        $result = EmptyBucket::all(['status'=>1]);
        return $result;
    }
    //礼盒分类数据包
    public static function GetBoxDataAll()
    {
        $result = EmptyBucket::all(['status'=>0]);
        return $result;
    }
    /**
     * 查找用户的单个数据
     */
    public static function GetOne($id)
    {
        $result = EmptyBucket::find($id);
        return $result;
    }
    //执行添加
    public static function AddData($data)
    {
        $EmptyBucket = New EmptyBucket;

        $result = $EmptyBucket->validate('EmptyBucketValidate')->save($data);
        if ($result === false) {
            return  json_encode(["code"=>0,"meg"=>$EmptyBucket->getError()]);
        }else{
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }
    }
    //执行修改
    public static function UpdateData($id,$data)
    {
        $EmptyBucket = New EmptyBucket;

        $result = $EmptyBucket->validate('EmptyBucketValidate')->save($data,['id'=>$id]);
        // halt($EmptyBucket->getLastSql());
        if ($result) {
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }else{
            return json_encode(["code"=>0,"meg"=>"操作失败"]);
        }


    }
    //执行删除
    public static function DeleteData($id)
    {
        $result = EmptyBucket::destroy($id);
        return $result;
    }
}