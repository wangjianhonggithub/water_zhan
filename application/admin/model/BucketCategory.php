<?php
namespace app\admin\model;
use think\Model;
class BucketCategory extends Model
{
    //获取所有的数据
    public static function GetAll()
    {
    	$result = BucketCategory::where('is_type',1)->order(['order'=>'desc', 'id'=>'desc'])->paginate(15);
    	return $result;
    }
     //礼盒分类的所有数据
    public static function GetBoxAll()
    {
        $result = BucketCategory::where('is_type',0)->order('id', 'desc')->paginate(15);
        return $result;
    }
    //数据包
    public static function GetDataAll()
    {
        $result = BucketCategory::all(['is_type'=>1]);
        return $result;
    }
    //礼盒分类数据包
    public static function GetBoxDataAll()
    {
        $result = BucketCategory::all(['is_type'=>0]);
        return $result;
    }
    /**
     * 查找用户的单个数据
     */
    public static function GetOne($id)
    {
        $result = BucketCategory::find($id);
        return $result;
    }
    //执行添加
    public static function AddData($data)
    {
        $BucketCategory = New BucketCategory;

        $result = $BucketCategory->validate('BucketCategoryValidate')->save($data);
        if ($result === false) {
            return  json_encode(["code"=>0,"meg"=>$BucketCategory->getError()]);
        }else{
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }
    }
    //执行修改
    public static function UpdateData($id,$data)
    {
        $BucketCategory = New BucketCategory;

        $result = $BucketCategory->validate('BucketCategoryValidate')->save($data,['id'=>$id]);
        // halt($BucketCategory->getLastSql());
        if ($result) {
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }else{
            return json_encode(["code"=>0,"meg"=>"操作失败"]);
        }


    }
    //执行删除
    public static function DeleteData($id)
    {
        $result = BucketCategory::destroy($id);
        return $result;
    }

    //二期

    /**
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 查找单个空桶归类
     */
    public function findCategory($whre){
        return BucketCategory::where($whre)->find();
    }

    /**
     * @param $whre
     * @param $date
     * @return BucketCategory
     * 修改归类信息
     */
    public function updataCategory($whre,$date){
        return BucketCategory::where($whre)
            ->update($date);
    }
}