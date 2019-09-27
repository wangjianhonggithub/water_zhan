<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Loader;
// 应用公共文件
//数据Excel导如
function inserExcel($excel = 'excel')
    {
        Loader::import('PHPExcel.Classes.PHPExcel');
        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel5');
        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
        //获取表单上传文件
        $file = request()->file('excel');
        $info = $file->validate(['ext' => 'xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $exclePath = $info->getSaveName();  //获取文件名
            $file_name = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;   //上传文件的地址
            $objReader =\PHPExcel_IOFactory::createReader('Excel5');
            $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
            $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            // foreach($excel_array as $k=>$v) {
            //     $city[$k]['Id'] = $v[0];
            //     $city[$k]['code'] = $v[1];    //数据展现形式
            //     $city[$k]['path'] = $v[2];
            //     $city[$k]['pcode'] = $v[3];
            //     $city[$k]['name'] = $v[4];
            // }
            return $excel_array;
        } else {
            echo $file->getError();
        }
}

//地址请求
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}


//后台无限积分类数据结构
function tree($arr,$pid=0,$lev=1)
{

    static $subs = [];
    foreach ($arr as $value) {
        if ($value['pid'] == $pid){
            $value['lev'] = $lev;
            $subs[] = $value;
            $subs = tree($arr,$value['id'],$lev+1);
        }
    }
    return $subs;
}

//后台无限级分类数据结构
function generateTree($items){  
    $tree = array();  
    foreach($items as $item){  
        //判断是否有数组的索引==  
        if(isset($items[$item['pid']])){     //查找数组里面是否有该分类  如 isset($items[0])  isset($items[1])  
            $items[$item['pid']]['son'][] = &$items[$item['id']]; //上面的内容变化,$tree里面的值就变化  
        }else{  
            $tree[] = &$items[$item['id']];   //把他的地址给了$tree  
        }    
    }  
    return $tree;  
}   

//无限级分类数据层级
function unlimitedForLayer($m,$name='child',$p_id = 0) {
    $arr = array();
    foreach ($m as $v) {
        if ($v['pid'] == $p_id) {
            $v[$name] = unlimitedForLayer($m, $name, $v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}