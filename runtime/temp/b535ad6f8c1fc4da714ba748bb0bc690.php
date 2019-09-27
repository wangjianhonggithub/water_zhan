<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/admin\view\BranchStore\management.html";i:1568714134;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/admin\view\Public\base.html";i:1563256854;}*/ ?>
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

                
<style>
    .panel-a{
        width: 100%;
        /*height: 38px;*/
        line-height: 38px;
    }
    .panel-a:hover{
        width: 100%;
        line-height: 38px;
        display: block;
        background: #dddddd;
    }
</style>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title"><a href="/Admin/bucketStore">分店列表</a>><?php echo $user_name; ?></h3>
    </div>



    <div class="panel-body">
        <table id="demo-dt-addrow" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <div class="main" style="width: 225px;">
                <div class="box" style="width: 100%;">
                    <h4 style="line-height: 38px;background: #eeeeee;padding-left: 4px;padding-left: 20px"><p>分店信息</p></h4>
                    <ul  style="display: none;padding-left: 35px">
                        <li style="margin-top: 5px;"><a href="/Admin/Branch_store/edit?id=<?php echo $id; ?>"  class="panel-a">修改分店信息</a></li>
                        <li style="margin-top: 5px;"><a href="/Admin/Branch_store/distribution?id=<?php echo $id; ?>&old_admin_id=<?php echo $admin_id; ?>"  class="panel-a">分配店长</a></li>
                    </ul>
                </div>
                <div class="box" style="margin-top: 8px;width: 100%;">
                    <h4 style="line-height: 38px;background: #eeeeee;padding-left: 4px;padding-left: 20px"><p>商品库存管理</p></h4>
                    <ul style="display: none;padding-left: 35px">
                        <li style="margin-top: 5px;"><a href="<?php echo url('EmptyBucket/assignBucket',array('id'=>$id,'username'=>$user_name)); ?>" class="panel-a">空桶库存</a></li>
                        <li style="margin-top: 5px;"><a href="/Admin/StoreGoodsInfo?store_id=<?php echo $id; ?>" class="panel-a">商品库存</a></li>

                    </ul>
                </div>
                <div class="box" style="margin-top: 8px;width: 100%;">
                    <h4 style="line-height: 38px;background: #eeeeee;padding-left: 4px;padding-left: 20px"><p>订单管理表</p></h4>
                    <ul style="display: none;padding-left: 35px">
                        <li style="margin-top: 5px;"><a href="/Admin/Branch_store/storeOrder?store_id=<?php echo $id; ?>&store_name=<?php echo $user_name; ?>" class="panel-a">客户自取订单</a></li>
                        <li style="margin-top: 5px;"><a href="/Admin/Branch_store/storeOrderTui?store_id=<?php echo $id; ?>&store_name=<?php echo $user_name; ?>" class="panel-a">退款订单</a></li>
                        <li style="margin-top: 5px;"><a href="/Admin/Branch_store/storeOrderY?store_id=<?php echo $id; ?>&type=2&store_name=<?php echo $user_name; ?>"  class="panel-a">押桶记录</a></li>
                        <li style="margin-top: 5px;"><a href="/Admin/Branch_store/storeOrderY?store_id=<?php echo $id; ?>&type=3&store_name=<?php echo $user_name; ?>"  class="panel-a">退桶记录</a></li>

                    </ul>
                </div>
                <div class="box" style="margin-top: 8px;width: 100%;">
                    <h4 style="line-height: 38px;background: #eeeeee;padding-left: 4px;padding-left: 20px"><a href="/Admin/Branch_store/storeuser?store_id=<?php echo $id; ?>&store_name=<?php echo $user_name; ?>" class="panel-a">送水员管理</a></h4>

                </div>
                <div class="box" style="margin-top: 8px">
                    <h4 style="line-height: 38px;background: #eeeeee;padding-left: 4px;padding-left: 20px"><a href="/Admin/Branch_store/goodsSale?store_id=<?php echo $id; ?>&store_name=<?php echo $user_name; ?>" class="panel-a">品牌销售</a></h4>

                </div>
                <div class="box" style="margin-top: 8px">
                    <h4 style="line-height: 38px;background: #eeeeee;padding-left: 4px;padding-left: 20px"><a href="/Admin/Branch_store/zhichu?store_id=<?php echo $id; ?>&store_name=<?php echo $user_name; ?>" class="panel-a">分店支出统计</a></h4>

                </div>
            </div>

            </thead>
            <tbody>

        </table>
        <div>
            <tr class="content">
                <td colspan="3" bgcolor="#FFFFFF"><div class="pages">

                </div></td>
            </tr>
        </div>
    </div>
</div>

<script>
    $("h4 p").click(function(){
        // $(this).parent().parent().find("ul").toggle();//无动画显示隐藏
        // $(this).parent().parent().find("ul").fadeToggle();// 透明度变化 淡入淡出
        $(this).parent().parent().find("ul").slideToggle(); //有个上下滑动动画的展开收起效果 推荐
    });
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
