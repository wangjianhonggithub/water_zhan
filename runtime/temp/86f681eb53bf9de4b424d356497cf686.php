<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:92:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\bucket_order.html";i:1566801718;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
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
                <span style="width: 100%;text-align: center; color: #666;">我的回桶</span>
            </a>
        </div>
    </div>
    <div class="big">
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="center active">
            <div class="content">
                <div class="item">
                    <div class="item-title"><span>完成时间</span><span><?php echo date('Y-m-d H:i:s',$vo['completeDate']); ?></span></div>
                    <div class="item-con">
                        <div class="list"><span>订单号:</span><span><?php echo $vo['qiantong_orderNo']; ?></span><span></span></div>
                        <?php if(is_array($vo['bucket']) || $vo['bucket'] instanceof \think\Collection || $vo['bucket'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['bucket'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?>
                        <div class="list"><span>空桶品牌:</span><span><?php echo $vs['bucket_name']; ?></span><span><b><?php echo $vs['bucket_num']; ?></b>桶</span></div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>

                        <?php if(($vo['waterman_owe_bucket'] == 0)): ?>
                        <div class="item-bot">

                            <a href="javascript:;" class="complete">已回桶</a>

                        </div>
                        <?php else: ?>
                        <div class="item-bot">

                            <a href="javascript:;">未回桶</a>

                        </div>
                        <?php endif; ?>



                        

                </div>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
</div>
<script src="/static/layui/layui.all.js"></script>
<link rel="stylesheet" href="/static/layui/css/layui.css">   
<script>

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