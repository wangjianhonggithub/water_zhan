<?php
namespace app\admin\model;
use think\Model;
class AdminUsers extends Model
{
    //获取所有的数据
    public static function GetAll()
    {
    	$result = AdminUsers::alias('a')
                    ->join('branch_store bs','bs.admin_id = a.id','left')
                    ->order('a.id', 'desc')
                    ->field('a.*,bs.name as store_name')
                    ->paginate(15);
    	return $result;
    }
    /**
     * 查找用户的单个数据
     */
    public static function GetOne($id)
    {
        $result = AdminUsers::find($id);
        return $result;
    }
    //执行添加
    public static function AddData($data)
    {
        $AdminUsers = New AdminUsers;
        $result = $AdminUsers->validate('AdministratorValidate')->save($data);
        if ($result === false) {
            return  json_encode(["code"=>0,"meg"=>$AdminUsers->getError()]);
        }else{
            return json_encode(["code"=>1,"meg"=>"操作成功"]);
        }
    }
    //执行修改
    public static function UpdateData($id,$data)
    {
        $AdminUsers = New AdminUsers;
        $result = $AdminUsers->save($data,['id'=>$id]);
        return $result;
    }
    //执行删除
    public static function DeleteData($id)
    {
        $result = AdminUsers::destroy($id);
        return $result;
    }

    public function getWhereAll($where){
       return AdminUsers::where($where)
            ->select();
    }


}