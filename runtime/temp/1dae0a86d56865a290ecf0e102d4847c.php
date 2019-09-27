<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"E:\PHPTutorial\WWW\jjzs\public/../application/admin\view\Goods\index.html";i:1564039976;s:73:"E:\PHPTutorial\WWW\jjzs\public/../application/admin\view\Public\base.html";i:1563256854;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理系统</title>
    <!--Open Sans Font [ OPTIONAL ]-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="/static/admin/css/bootstrap.min.css" rel="stylesheet">
    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="/static/admin/css/nifty.min.css" rel="stylesheet">
    <!--Nifty Premium Icon [ DEMONSTRATION ]-->
    <link href="/static/admin/css/demo/nifty-demo-icons.min.css" rel="stylesheet">
 	<link href="/static/admin/plugins/ionicons/css/ionicons.min.css" rel="stylesheet">
    <!--Demo [ DEMONSTRATION ]-->
    <link href="/static/admin/css/demo/nifty-demo.min.css" rel="stylesheet">
    <link href="/static/admin/css/mypage.css" rel="stylesheet">
    <!--Morris.js [ OPTIONAL ]-->
    <link href="/static/admin/plugins/morris-js/morris.min.css" rel="stylesheet">
    <!--Magic Checkbox [ OPTIONAL ]-->
    <link href="/static/admin/plugins/magic-check/css/magic-check.min.css" rel="stylesheet">
    <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="/static/admin/plugins/pace/pace.min.css" rel="stylesheet">
    <link href="/static/admin/plugins/fooTable/css/footable.core.css" rel="stylesheet">
    <link href="/static/admin/plugins/pace/pace.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/static/webuploader/jekyll/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/static/webuploader/jekyll/css/demo.css"
    <script src="/static/admin/plugins/pace/pace.min.js"></script>
    <script src="/static/admin/plugins/pace/pace.min.js"></script>
    <!--jQuery [ REQUIRED ]-->
    <script src="/static/admin/js/jquery-2.2.4.min.js"></script>
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="/static/admin/js/bootstrap.min.js"></script>
    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="/static/admin/js/nifty.min.js"></script>
    <script src="/static/admin/js/demo/nifty-demo.min.js"></script>
    <!--Icons [ SAMPLE ]-->
    <script src="/static/admin/js/demo/icons.js"></script>
    <!--=================================================-->
    <!--Demo script [ DEMONSTRATION ]-->
    <script src="/static/admin/js/demo/nifty-demo.min.js"></script>
    <!--Morris.js [ OPTIONAL ]-->
	<script src="/static/admin/plugins/morris-js/raphael-js/raphael.min.js"></script>
    <!--Sparkline [ OPTIONAL ]-->
    <script src="/static/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Specify page [ SAMPLE ]-->
    <script src="/static/admin/plugins/fooTable/dist/footable.all.min.js"></script>
    <script src="/static/layui/layui.all.js"></script>
    <!--FooTable Example [ SAMPLE ]-->
    <script src="/static/admin/js/demo/tables-footable.js"></script>
    <script type="text/javascript" src="/static/webuploader/jekyll/js/webuploader.js"></script>

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
<body>
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
        
        <!--NAVBAR-->
        <!--===================================================-->
        <header id="navbar">
            <div id="navbar-container" class="boxed">

                <!--Brand logo & name-->
                <!--================================-->
                <div class="navbar-header">
                    <a href="javascript:;" class="navbar-brand">
                        <img src="/static/admin/img/logo.png" alt="公司 Logo" title="公司LOGO" class="brand-icon">
                        <div class="brand-title">
                            <span class="brand-text">鼎智诚</span>
                        </div>
                    </a>
                </div>
                <!--================================-->
                <!--End brand logo & name-->


                <!--Navbar Dropdown-->
                <!--================================-->
                <div class="navbar-content clearfix">
                    <ul class="nav navbar-top-links pull-left">

                        <!--Navigation toogle button-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li class="tgl-menu-btn">
                            <a class="mainnav-toggle" href="/static/admin/#">
                                <i class="demo-pli-view-list"></i>
                            </a>
                        </li>

                    </ul>
                </div>
                <!--================================-->
                <!--End Navbar Dropdown-->

            </div>
        </header>
        <!--===================================================-->
        <!--END NAVBAR-->

        <div class="boxed">

            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-content">

                
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">列表</h3>
    </div>
<!--     <div id="demo-custom-toolbar2" class="table-toolbar-left">
        <a href="/Admin/Goods/add" id="demo-dt-addrow-btn" class="btn btn-primary"><i class="demo-pli-plus"></i> 添加</a>
        <li>搜索：</li>
          <form>
              <input type="text" placeholder="请输入搜索姓名" name="title" value="" class="input" style="width:183px; line-height:17px;display:inline-block" />
            <select name="minute"  required class="select input" style="width:183px; line-height:17px;display:inline-block">
                   <option value="selected">主持时间</option>
                   <option value="1" 1 == 1 ?'selected':''}>上午</option>
                   <option value="2" 1 == 2 ?'selected':''}>下午</option>
                   <option value="3" 1 == 3 ?'selected':''}>晚上</option>
            </select>

             <a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()" > 搜索</a> 
                <input type="submit" class="button border-main icon-search"  value="查询">
            </form>
         </li> 
        <div class="col-m-5">
        </div>
    </div> -->
    <div class="padding border-bottom" >
      <ul class="search" style="padding:10px;">
        <li style="float: left;padding-bottom: 10px"> <a href="/Admin/Goods/add" id="demo-dt-addrow-btn" class="btn btn-primary"><i class="demo-pli-plus"></i> 添加</a> </li>
        <li ></li>
<!--           <form style="float: right;padding-bottom: 10px">
              <input type="text" placeholder="请输入搜索姓名" name="title" value="" class="input" style="width:183px; line-height:30px;display:inline-block;height: 30px;border-radius:3px;font-size: 16px" />
            <select name="minute"  required class="select input" style="width:183px; line-height:30px;display:inline-block;height: 30px;border-radius:3px;font-size: 16px">
                   <option value="selected">主持时间</option>
                   <option value="1" 1 == 1 ?'selected':''}>上午</option>
                   <option value="2" 1 == 2 ?'selected':''}>下午</option>
                   <option value="3" 1 == 3 ?'selected':''}>晚上</option>
            </select>

              <!-- <a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()" > 搜索</a> 
                <input style="width:70px; line-height:30px;display:inline-block;height: 30px;border-radius:3px;background-color: #38a0f4;border-color: #38a0f4;color: #fff;font-size: 16px" type="submit" class="button border-main icon-search"  value="查询">
            </form> -->
         </li>
      </ul>
    </div>
    <div class="panel-body">
        <table id="demo-dt-addrow" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>所属分类</th>
                    <th>商品名称</th>
                    <th class="min-tablet">价格</th>
                    <th class="min-tablet">缩略图</th>
                    <th class="min-tablet">运费</th>
                    <th class="min-tablet">月销量</th>
                    <th class="min-tablet">库存</th>
                    <th class="min-tablet">图片</th>
                    <th class="min-tablet">标识</th>
                    <th class="min-tablet">状态</th>
                    <th class="min-tablet">创建时间</th>
                    <th class="min-tablet">修改时间</th>
                    <th class="min-desktop">操作</th>
                </tr>
            </thead>
            <tbody>
               <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td style="color:red"><?php echo $vo['name']; ?></td>
                    <td><?php echo $vo['goods_name']; ?></td>
                    <td>￥<?php echo $vo['goods_pic']; ?></td>
                    <td><img src="<?php echo $vo['thumb_img']; ?>" alt="" style="width:80px;height: 80px;"></td>
                    <td>￥<?php echo $yunfei; ?></td>
                    <td>50</td>
                    <td><?php echo $vo['stock']; ?></td>
                    <td>
                        <?php foreach(explode(',',$vo['goods_img']) as $goods){ if(!empty($goods)){?>
                            <img src="<?php echo $goods; ?>" alt="" style="width: 80px;height:80px;">
                        <?php } } ?>
                    </td>
                    <?php if($vo['is_recom'] == 0){ ?>
                    <td data-id="<?php echo $vo['id']; ?>" class="label label-table Recommed label-success">热销</td>
                    <?php }else{?>
                    <td data-id="<?php echo $vo['id']; ?>" class="label label-table UnRecommed label-danger">取消热销</td>
                    <?php }?>
                    <td style="color:red"><?php echo $vo['status'] == 0 ? "下架" : "正常"; ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$vo['update_time']); ?></td>
                    <td>
                        <a href="/Admin/Goods/show/<?php echo $vo['id']; ?>" class="btn btn-xs btn-rounded btn-mint">查看</a>
                    	<a href="/Admin/Goods/update/<?php echo $vo['id']; ?>" class="btn btn-xs btn-rounded btn-warning">修改</a>
                        <!-- <a href="javascript:;" data-id="<?php echo $vo['id']; ?>" class="btn btn-xs DeleteSubmit btn-rounded Delete btn-danger">删除</a> -->
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <div>
             <tr class="content">
                <td colspan="3" bgcolor="#FFFFFF"><div class="pages">
                    <?php echo $list->render(); ?>
                </div></td>  
            </tr>
        </div>
    </div> 
</div>
<script>
    $(function(){
        $('.Recommed').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: '/Admin/Goods/Recommed',
                data: {
                    id:id,
                },
                success: function(data){
                    var data= eval('('+data+')');
                    if (data.code == 1) {
                        layer.msg(data.meg, function(){
                            //关闭后的操作
                        });
                        setTimeout(function(){
                           location.reload();
                        },1500);
                    }else{
                        layer.msg(data.meg, function(){
                            //关闭后的操作
                        });
                        return false;
                    }
                },
            });
        });
        $('.UnRecommed').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: '/Admin/Goods/UnRecommed',
                data: {
                    id:id,
                },
                dataType: 'json',
                success: function(data){
                    if (data.code == 1) {
                        layer.msg(data.meg, function(){
                            //关闭后的操作
                        });
                        setTimeout(function(){
                           location.reload();
                        },1500);
                    }else{
                        layer.msg(data.meg, function(){
                            //关闭后的操作
                        });
                        return false;
                    }
                },
            });
        });
        $('.DeleteSubmit').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: '/Admin/Goods/delete',
                data: {
                    id:id,
                },
                dataType: 'json',
                success: function(data){
                    if (data.code == 0) {
                        layer.msg(data.meg, function(){
                            //关闭后的操作
                        });
                        setTimeout(function(){
                           location.reload();
                        },1500);
                    }else{
                        layer.msg(data.meg, function(){
                            //关闭后的操作
                        });
                        return false;
                    }
                },
            });
        })
    })
</script>


                </div>
                <footer id="footer">
            <?php 
                $time = time();
             ?>
            <div class="hide-fixed pull-right pad-rgt">
                <strong><?php echo date('Y-m-d',$time); ?></strong>
            </div>
            <p class="pad-lft">&#0169; 技术支持-鼎智成科技发展有限公司</p>
        </footer>
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->


            
            <!--ASIDE-->
            <!--===================================================-->
            <aside id="aside-container">
                <div id="aside">
                    <div class="nano">
                        <div class="nano-content">
                            
                            <!--Nav tabs-->
                            <!--================================-->
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="/Admin/#demo-asd-tab-1" data-toggle="tab">
                                        <i class="demo-pli-speech-bubble-7"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="/Admin/#demo-asd-tab-2" data-toggle="tab">
                                        <i class="demo-pli-information icon-fw"></i> Report
                                    </a>
                                </li>
                                <li>
                                    <a href="/Admin/#demo-asd-tab-3" data-toggle="tab">
                                        <i class="demo-pli-wrench icon-fw"></i> Settings
                                    </a>
                                </li>
                            </ul>
                            <!--================================-->
                            <!--End nav tabs-->



                            <!-- Tabs Content -->
                            <!--================================-->
                        </div>
                    </div>
                </div>
            </aside>
            <!--===================================================-->
            <!--END ASIDE-->

            
            <!--MAIN NAVIGATION-->
            <!--===================================================-->
            <nav id="mainnav-container">
                <div id="mainnav">
                    <?php 
                        $UserId = cookie('AdminUserId');
                        $Db = new think\Db;
                        $UserInfo = $Db::name('admin_users')->where("id=$UserId")->find();
                        $role = rtrim($UserInfo['role'],',');
                        $res = $Db::name('column')->where("id in($role)")->select();
                        function GetTree($m,$name='child',$p_id = 0) {
                            $arr = array();
                            foreach ($m as $v) {
                                if ($v['pid'] == $p_id) {
                                    $v['child'] = GetTree($m, $name, $v['id']);
                                    $arr[] = $v;
                                }
                            } 
                            return $arr;
                        }
                        $column = GetTree($res,$name='child',$p_id = 0);
                     ?>
                    <!--Menu-->
                    <!--================================-->
                    <div id="mainnav-menu-wrap">
                        <div class="nano">
                            <div class="nano-content">
                                <!--================================-->
                                <div id="mainnav-profile" class="mainnav-profile">
                                    <div class="profile-wrap">
                                        <div class="pad-btm">
                                            <img class="img-circle img-sm img-border" src="/static/admin/img/profile-photos/1.png" title="管理员头像" alt="Profile Picture">
                                        </div>
                                        <a href="/Admin/#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
                                            <span class="pull-right dropdown-toggle">
                                                <i class="dropdown-caret"></i>
                                            </span>
                                            <p class="mnp-name"><?php echo $UserInfo['nickname']; ?></p>
                                        </a>
                                    </div>
                                    <div id="profile-nav" class="collapse list-group bg-trans">
                                        <a href="/Admin/Administrator/password" class="list-group-item">
                                            <i class="ion-ios-gear icon-lg icon-fw"></i> 修改密码
                                        </a>
                                        <a href="/Admin/Login/LoginOut" id="LoginOutNow" class="list-group-item">
                                            <i class="demo-pli-unlock icon-lg icon-fw"></i> 退出
                                        </a>
                                    </div>
                                </div>
                                <ul id="mainnav-menu" class="list-group">
                                    <li class="active-link">
                                        <a href="/Admin/Column">
                                            <i class="demo-psi-home"></i>
                                            <span class="menu-title">
                                                <strong>栏目管理</strong>
                                            </span>
                                        </a>
                                    </li>
                                    <?php foreach($column as $val){ ?>
                                    <!--Category name-->
                                    <li class="list-header"><?php echo $val['name']; ?></li>
                                    <!--Menu list item-->
                                    <?php foreach($val['child'] as $cal){ ?>
                                        <li>
                                            <a href="<?php if($cal['url'] != ''){echo '';}?><?php echo $cal['url']; ?>">
                                                <i class="<?php echo $cal['icon']; ?>"></i>
                                                <span class="menu-title">
                                                    <strong><?php echo $cal['name']; ?></strong>
                                                </span>
                                                <?php if(!empty($cal['child'])){ ?>
                                                <i class="arrow"></i>
                                                <?php } ?>
                                            </a>
                                            <!--Submenu-->
                                            <?php foreach($cal['child'] as $eal){ ?>
                                            <ul class="collapse">
                                                <li><a href="<?php echo $eal['url']; ?>"><?php echo $eal['name']; ?></a></li>
                                            </ul>
                                            <?php } ?>
                                        </li>
                                    <?php } } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
    </div>
</body>
</html>
