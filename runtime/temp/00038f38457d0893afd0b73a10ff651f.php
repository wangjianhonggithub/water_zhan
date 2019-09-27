<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\t_order.html";i:1566785322;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>个人中心</title>
 <!--    <link rel="stylesheet" href="/static/home/song/css/my.css">
    <link rel="stylesheet" href="/static/home/song/css/index.css">
    <link rel="stylesheet" href="/static/home/song/css/login.css">
    <link rel="stylesheet" href="/static/home/song/css/order.css">
    <link rel="stylesheet" href="/static/home/song/css/payroll_records.css">
    <link rel="stylesheet" href="/static/home/song/css/phone.css">
    <link rel="stylesheet" href="/static/home/song/css/salary.css"> -->
    <!-- <link rel="stylesheet" href="/static/home/song/css/index.css"> -->
    <script src="/static/home/song/js/jquery-3.2.1.min.js"></script>
    <script src="/static/home/song/js/index.js"></script>

    <style>
        .active{color:#000;}
    </style>

</head>
<body>
<div class="my">
    <div class="head">
        <div class="content">
            <img src="<?php echo $userInfo['photo']; ?>" class="img-left">
            <div class="information">
                <div class="name"><?php echo $userInfo['nickname']; ?></div>
                <div class="xinxi"><span>手机：<?php echo $userInfo['mobile']; ?></span><span>接单数：<?php echo $userInfo['num']; ?>单 <img src="/static/home/song/images/jian.png"></span></div>
            </div>
        </div>
    </div>
    
<link rel="stylesheet" href="/static/home/song/css/order.css">

<div class="tab">
    <div class="all">
        <div class="content">
            <a href="/Index/Order/TOrderLists">
                <span>我的订单</span>
                <span>查看全部 <img src="/static/home/song/images/jian1.png"></span>
            </a>
        </div>
    </div>
    <div class="title">
        <div class="content">
            <ul>
                <li class="active"><a href="javascript:;">待接单</a></li>
                <li><a href="javascript:;">取桶中</a></li>
                <li><a href="javascript:;">已收桶</a></li>
                <li><a href="javascript:;">已完成</a></li>
                <li><a href="javascript:;">已取消</a></li>
            </ul>
        </div>
    </div>
    <div class="big">
        <div class="center active">
            <div class="content">
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span><?php echo date('Y-m-d H:i:s', $vo['createTime']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span><b><?php echo $vo['num']; ?></b>只</span></div>
                        <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="Receipt" data-id="<?php echo $vo['id']; ?>">接单</a>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="center">
            <div class="content">
                <?php if(is_array($Yfhlist) || $Yfhlist instanceof \think\Collection || $Yfhlist instanceof \think\Paginator): $i = 0; $__LIST__ = $Yfhlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span><?php echo date('Y-m-d H:i:s', $vo['createTime']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span><b><?php echo $vo['num']; ?></b>只</span></div>
                        <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                    </div>
                    <div class="item-bot delivery">
                        <a href="javascript:;" class="giveUp" data-id="<?php echo $vo['id']; ?>">放弃</a>
                        <a href="javascript:;" class="Buckets" data-id="<?php echo $vo['id']; ?>">已收桶</a>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="center">
            <div class="content">
                <?php if(is_array($Ysdlist) || $Ysdlist instanceof \think\Collection || $Ysdlist instanceof \think\Paginator): $i = 0; $__LIST__ = $Ysdlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span><?php echo date('Y-m-d H:i:s', $vo['createTime']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span><b><?php echo $vo['num']; ?></b>只</span></div>
                        <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已收桶</a>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="center">
            <div class="content">
                <?php if(is_array($Ywclist) || $Ywclist instanceof \think\Collection || $Ywclist instanceof \think\Paginator): $i = 0; $__LIST__ = $Ywclist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span><?php echo date('Y-m-d H:i:s', $vo['createTime']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span><b><?php echo $vo['num']; ?></b>只</span></div>
                        <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已完成</a>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="center">
            <div class="content">
                <?php if(is_array($Yqxlist) || $Yqxlist instanceof \think\Collection || $Yqxlist instanceof \think\Paginator): $i = 0; $__LIST__ = $Yqxlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span><?php echo date('Y-m-d H:i:s', $vo['createTime']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span><b><?php echo $vo['num']; ?></b>只</span></div>
                        <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已取消</a>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="/static/layui/layui.all.js"></script>
<link rel="stylesheet" href="/static/layui/css/layui.css">    
<script>
    //公海选项卡
    $(".title ul li").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        var a =$(this).index();
        $(".big .center").eq(a).addClass("active").siblings().removeClass("active");
    });

    $('.Receipt').click(function(){
        var myUrl  = "/Index/Order/Receipt";
        var orderId = $(this).attr('data-id');
        $.ajax({
          url: myUrl,
          type: 'get',
          dataType: 'json',
          data:{orderId:orderId},
          timeout: 1000,
          success: function (data, status) {
            if (data.code == '1001'){
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
                setTimeout(function(){
                     window.location.reload();
                  },1500);
            } else {
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
            }
          },
          fail: function (err) {
            layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
          }
        }) 
    })

    $('.giveUp').click(function(){
        var myUrl  = "/Index/Order/giveUp";
        var orderId = $(this).attr('data-id');
       
        $.ajax({
          url: myUrl,
          type: 'get',
          dataType: 'json',
          data:{orderId:orderId},
          timeout: 1000,
          success: function (data, status) {
            if (data.code == '1001'){
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
                setTimeout(function(){
                    window.location.reload();
                  },1500);
            } else {
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
            }
          },
          fail: function (err) {
            layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
          }
        }) 
    })

    $('.Buckets').click(function(){
        var myUrl  = "/Index/Order/Buckets";
        var orderId = $(this).attr('data-id');
       
        $.ajax({
          url: myUrl,
          type: 'get',
          dataType: 'json',
          data:{orderId:orderId},
          timeout: 1000,
          success: function (data, status) {
            if (data.code == '1001'){
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
                setTimeout(function(){
                    window.location.reload();
                  },1500);
            } else {
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
            }
          },
          fail: function (err) {
            layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
          }
        }) 
    })



</script>



    <div class="footer">
        <div class="title">
            <ul>
                <li>
                    <a href="/Index/Index/Song" >
                        <img src="/static/home/song/images/shouji-h.png" class="tab1" alt="">
                        <p>首页</p>
                    </a>
                </li>
                <li class="tab">
                    <a href="/Index/User/Xinzi" >
                        <img src="/static/home/song/images/jine-h.png" class="tab2" alt="">
                        <p>薪资</p>
                    </a>
                </li>
                <li class="tab">
                    <a href="/Index/User/index" >
                        <img src="/static/home/song/images/my-h.png" class="tab3" alt="">
                        <p>我的</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>