<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/26
 * Time: 10:03
 */

namespace app\admin\controller;


use app\admin\model\AdminUsers;

class AdminStoreStock extends Base
{
    public function index(){
        $adminUsers = new AdminUsers();
        $where['identity'] = 1;
        $rs = $adminUsers->getWhereAll($where);
        $this->assign('rs',$rs);
        return $this->fetch('AdminStoreStock/index');
    }
}