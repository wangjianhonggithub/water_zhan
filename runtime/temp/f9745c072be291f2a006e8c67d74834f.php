<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\t_q_order.html";i:1563256878;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
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
            <a href="javascript:;">
                <span style="width: 100%;text-align: center; color: #666;">我的订单</span>
            </a>
        </div>
    </div>
    <div class="big">
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="center active">
            <div class="content">
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span><?php echo date('Y-m-d H:i:s', $vo['createTime']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>联系人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span><b><?php echo $vo['num']; ?></b>只</span></div>
                        <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                    </div>

                    <?php switch($vo['orderStatus']): case "1": ?>
                        <div class="item-bot">

                            <a href="javascript:;">接单</a>

                        </div>
                        <?php break; case "2": ?>
                        <div class="item-bot delivery">
                            <a href="javascript:;" class="giveUp" data-id="<?php echo $vo['id']; ?>">放弃</a>
                            <a href="javascript:;" class="Buckets" data-id="<?php echo $vo['id']; ?>">已收桶</a>
                        </div>
                        <?php break; case "3": ?>
                        <div class="item-bot">
                            <a href="javascript:;" class="complete">已送达</a>
                        </div>
                        <?php break; case "4": ?>
                        <div class="item-bot">
                            <a href="javascript:;" class="complete">已完成</a>
                        </div>
                        <?php break; case "5": ?>
                        <div class="item-bot">
                            <a href="javascript:;" class="complete">已取消</a>
                        </div>
                        <?php break; endswitch; ?>
                </div>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
   <!--      <div class="center active">
            <div class="content">
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span>2018-05-05 14:00:00</span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span><b>1</b>只</span></div>
                        <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已送达</a>
                    </div>
                </div>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span>2018-05-05 14:00:00</span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span><b>1</b>只</span></div>
                        <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已送达</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="center active">
            <div class="content">
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span>2018-05-05 14:00:00</span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span><b>1</b>只</span></div>
                        <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已完成</a>
                    </div>
                </div>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span>2018-05-05 14:00:00</span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span><b>1</b>只</span></div>
                        <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已完成</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="center active">
            <div class="content">
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span>2018-05-05 14:00:00</span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span><b>1</b>只</span></div>
                        <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已取消</a>
                    </div>
                </div>
                <div class="item">
                    <div class="item-title"><span>退桶押金订单</span><span>2018-05-05 14:00:00</span></div>
                    <div class="item-con">
                        <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span><b>1</b>只</span></div>
                        <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                    </div>
                    <div class="item-bot">
                        <a href="javascript:;" class="complete">已取消</a>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<script src="/static/layui/layui.all.js"></script>
<link rel="stylesheet" href="/static/layui/css/layui.css"> 
<script>
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