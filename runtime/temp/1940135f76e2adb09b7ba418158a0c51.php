<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/admin\view\Config\kefu.html";i:1563256848;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/admin\view\Public\base.html";i:1563256854;}*/ ?>
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
  <!-- Panel heading -->
  <div class="panel-heading">
    <div class="panel-control">
     
    </div>
    <h3 class="panel-title">修改</h3></div>
  <!-- Panel body -->
  <form id="demo-bv-errorcnt" class="form-horizontal bv-form" action="" method="POST" novalidate="novalidate">
    <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
    <div class="panel-body">
      <div class="tab-content">
        <!--SHOWING ERRORS IN TOOLTIP-->
        <!--===================================================-->
        <div id="demo-tabs-box-1" class="tab-pane fade in active">

          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">公司名称</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" name="company" value="<?php echo $update['company']; ?>" placeholder="公司名称" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">工作时间</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" name="working" value="<?php echo $update['working']; ?>" placeholder="工作时间" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">客服电话</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" name="mobile" value="<?php echo $update['mobile']; ?>" placeholder="客服电话" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">客服QQ</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" name="qq" value="<?php echo $update['qq']; ?>" placeholder="客服QQ" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">客服微信</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" name="wx" value="<?php echo $update['wx']; ?>" placeholder="客服微信" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">公司地址</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" name="address" value="<?php echo $update['address']; ?>" placeholder="商品名称" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>

        </div>


       </div>
    </div>
    <div class="panel-footer clearfix">
      <div class="col-lg-7 col-lg-offset-3">
        <button type="button" class="btn btn-mint" id="CreateSubmit" value="点击修改">点击修改</button></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/static/ueditor/ueditor.all.js"></script>
<script>
     $(function(){
    $('#CreateSubmit').click(function(){
      var company =  $("input[name='company']").val();
      var working =  $("input[name='working']").val();
      var mobile  =  $("input[name='mobile']").val();
      var qq      =  $("input[name='qq']").val();
      var wx      =  $("input[name='wx']").val();
      var address =  $("input[name='address']").val();

      $.ajax({
        type: 'POST',
        url:'/Admin/Config/DoUpdate',
        data:{
            company:company,
            working:working,
            mobile:mobile,
            qq:qq,
            wx:wx,
            address:address,
        },
        success: function(data){
            var data= eval('('+data+')');
            if (data.code == 1) {
                layer.msg(data.meg, function(){
                  //关闭后的操作
                });
                setTimeout(function(){
                  window.location.reload();//hrefwindow.location.reload()=document.referrer;
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
