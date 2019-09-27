<?php
namespace app\admin\controller;
use think\Loader;
use think\Db;
use app\admin\controller\Base;
use app\admin\model\Goods as GoodsModel;
use think\Request;


class EmptyBucket extends Base
{
    public function index(){
    }
    public function emptyBucketList()
    {	
        $user_id = cookie('AdminUserId');
        $user_name = db('admin_users')->field('username,nickname')->where('id='.$user_id)->find();
        if($user_name['username'] == 'admin'){
            $name = '';
        }else{
            $name = $user_name['nickname'];
        }
        $list = db('empty_bucket')
            ->alias('e')
            ->join('branch_store u',"u.id=e.user_id")
            ->where('e.user_id='.$user_id)
            ->field('e.*,u.name')
            ->paginate(5);
        $this->assign('list',$list);
        $this->assign('user_name',$name);
        $this->assign('user_id',$user_id);
        $this->assign('flag','o');
        //parent::CheckAdminLogin();

        return view('list');
    }

    //空桶分类下，店铺列表
    public function bucketStoreList(){
        $list = db('branch_store')
                ->alias('b')
                ->join('admin_users a',"b.admin_id=a.id",'LEFT')
                ->where('b.status',1)
                ->field('b.*,a.username')
                ->paginate(20)->toArray();
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
        $nowTime = time();


        foreach ($list['data'] as $k=>$v) {
            $list['data'][$k]['profit'] = 0;
            $list['data'][$k]['expenditure'] = 0;
            $data = DB::name('revenue_day')->where('store_id',$v['id'])->where('statistical_time','>=',$beginThismonth)->where('statistical_time','<=',$nowTime)->select();
            foreach ($data as $key=>$value) {
                $a = json_decode($value['profit'],true);
                unset($a['lose_bucket']);
                $list['data'][$k]['profit'] += array_sum($a);
                $list['data'][$k]['expenditure'] += array_sum(json_decode($value['expenditure'],true));
            }
            $list['data'][$k]['net_profit'] = $list['data'][$k]['profit']-$list['data'][$k]['expenditure'];
        }
        $this->assign('list',$list);
        return view('user_list');
    }

    //分配空桶
    public function assignBucket(){
        $id = input('id') ? input('id'):'';
        $user_name = input('username') ? input('username') : '';
        if(empty($id)){
            $aa = '';
        }else{
            $aa = db('bucket_category')
                ->alias('g')
                ->join('empty_barrey e',"e.goodsName=g.name and e.userId=".$id,'LEFT')
                ->field('g.name as goods_name,e.number as num')
                ->where('g.is_type=1')
                ->paginate(10);
        }


        $this->assign('user_name',$user_name);
        $this->assign('list',$aa);
        $this->assign('user_id',$id);
        $this->assign('flag','a');
        return view('list');
    }

    //分配空桶的页面
    public function addBucket(){
        $user_id = input('user_id') ? input('user_id') : 0;
        $name = input('name') ? input('name') : '';
        $name = str_replace('+',' ',$name);

        $now_num = db('empty_bucket')->where('user_id='.$user_id.' and goods_name="'.$name.'"')->value('num');
        if(is_null($now_num)){
            $this->assign('now_num',0);
        }else{
            $this->assign('now_num',$now_num);
        }
        $this->assign('user_id',$user_id);
        $this->assign('name',$name);
        return view('add');
    }

    //分配空桶
    public function doAddBucket(){
        $user_id = input('user_id') ? input('user_id') : 0;
        $name = input('name') ? input('name') : '';
        $num = input('num') ? input('num') : 0;
        if($user_id == 0 || $name == '' || $num == 0){
            $return['code'] = 201;
            $return['msg'] = '系统错误';
            exit(json_encode($return));
        }
        $data['user_id'] = $user_id;
        $data['goods_name'] = $name;
        $data['num'] = $num;

        $if_exists = db('empty_bucket')->where('user_id='.$user_id.' and goods_name="'.$name.'"')->count();
        if($if_exists > 0){
            $res = db('empty_bucket')->where('user_id='.$user_id.' and goods_name="'.$name.'"')->setField('num',$num);
        }else{
            $res = db('empty_bucket')->insert($data);
        }

        $empty_barrey = db('empty_barrey')->where('userId='.$user_id.' and goodsName="'.$name.'"')->value('number');
        
        $datas = [];
        $datas['userId'] = $user_id;
        $datas['goodsName'] = $name;
        $datas['number'] = $num;


        if($empty_barrey){
            $empty_barrey_number = $empty_barrey + $num;
            $res = db('empty_barrey')->where('userId='.$user_id.' and goodsName="'.$name.'"')->setField('number',$empty_barrey_number);
        }else{
            $res = db('empty_barrey')->insert($datas);
        }

        if($res){
            //改变是否申请状态，俩表都有
            db('empty_bucket')->where('user_id='.$user_id.' and goods_name="'.$name.'"')->setField('if_apply',0);
            $apply_count = db('empty_bucket')->where('if_apply=1 and user_id='.$user_id)->count();
            if($apply_count == 0){
                db('admin_users')->where('id='.$user_id)->setField('if_apply_bucket',0);
            }
            //操作记录--
            $log['user_id'] = cookie('AdminUserId');
            $log['for_user_id'] = $user_id;
            $log['type'] = 1;
            $log['time'] = time();
            $log['goods_name']= $name;
            $log['num'] = $num;
            db('logs')->insert($log);
            //--
            $return['code'] = 200;
            $return['msg'] = '添加成功';
        }else{
            $return['code'] = 202;
            $return['msg'] = '系统错误';
        }
        exit(json_encode($return));
    }

    //查询分配空桶记录
    public function assignBucketLogs(){
        $for_user_id = input('user_id') ? input('user_id') : 0;
        $bucket_name = input('name') ? input('name') : '';
        $bucket_name = str_replace('+',' ',$bucket_name);

        $where['l.for_user_id'] = $for_user_id;
        $where['l.goods_name'] = $bucket_name;
        $list = db('logs')
            ->alias('l')
            ->join('branch_store a','l.for_user_id=a.id','LEFT')
            ->join('admin_users au','l.user_id=au.id','LEFT')
            ->where($where)
            ->whereIn('l.type',[1,2])
            ->field('l.*,a.name,au.username')
            ->paginate(10);
        $this->assign('list',$list);
        return view('log_list');
    }

    //申请空桶
    public function applyForBucket(){
        $id = input('id') ? input('id') : 0;
        if($id == 0){
            $return['code'] = 201;
            $return['msg'] = '系统错误';
        }else{
            $res1 = db('empty_bucket')->where('id='.$id)->setField('if_apply',1);
            $res2 = db('admin_users')->where('id='.cookie('AdminUserId'))->setField('if_apply_bucket',1);
            if($res1){
                $return['code'] = 200;
                $return['msg'] = '申请成功';
            }else{
                $return['code'] = 202;
                $return['msg'] = '系统错误';
            }
        }
        exit(json_encode($return));
    }


    //二期

    /**
     * @param Request $request store_id
     * @return mixed
     * @throws \think\exception\DbException
     * 获取分店的商品列表信息
     */
    public function storeGoodsInfo(Request $request){
        $store_id = $request->get('store_id');

        $goods = new GoodsModel();
        //通过分店id查询商品
        $rs = $goods->getAllGoods($store_id);

        //分页
        $page = $rs->render();
        $this->assign('rs',$rs);
        $this->assign('page',$page);
        $this->assign('store_id',$store_id);
        return $this->fetch('store_goods_info');
    }
}
