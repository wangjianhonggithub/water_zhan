<?php
namespace app\admin\validate;
use think\Validate;
class BranchStoreValidate extends Validate
{
    protected $rule = [
        'name'  =>  'require|unique:branch_store',
    ];
    
    protected $message = [
        'name.require'  =>  '分店名称必填',
        'name.unique'  =>  '分店名称已存在',
    ];
}