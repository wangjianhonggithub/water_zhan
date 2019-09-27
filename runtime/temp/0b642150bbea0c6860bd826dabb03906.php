<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\salary.html";i:1563256878;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
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
    
<link rel="stylesheet" href="/static/home/song/css/salary.css">
<div class="tab">
    <div class="all">
        <div class="content">
            我的薪资
        </div>
    </div>
    <div class="title">
        <div class="content">
            <div class="tit">当月薪资</div>
            <div class="tit-con">￥<?php echo $list['xinzi']; ?></div>
            <div class="tit-bot"><a href="/index/User/XinziList">查看薪资记录</a></div>
        </div>
    </div>
    <div class="big">
        <div class="big-tit">当月订单的薪资记录</div>
        <div class="center">
            <?php if($list['data']): if(is_array($list['data']) || $list['data'] instanceof \think\Collection || $list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="item">
                <div class="item-con">
                    <?php if(is_array($vo['goodsList']) || $vo['goodsList'] instanceof \think\Collection || $vo['goodsList'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['goodsList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ve): $mod = ($i % 2 );++$i;?>
                    <div class="list"><span>商品名称:</span><span><?php echo $ve['goodsName']; ?></span><span>数量: <?php echo $ve['goodsNum']; ?>桶</span></div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="list"><span>收货人:</span><span><?php echo $vo['userName']; ?>,<?php echo $vo['userMobile']; ?></span><span></span></div>
                    <div class="list"><span>地址:</span><span><?php echo $vo['userAddress']; ?></span><span></span></div>
                </div>
                <div class="item-bot">
                    <span><?php echo $vo['times']; ?></span>
                    <span>提成：￥<b><?php echo $vo['ticheng']; ?></b></span>
                </div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
<!--             <div class="item">
                <div class="item-con">
                    <div class="list"><span>商品名称:</span><span>哇哈哈纯净水</span><span>数量: 3桶</span></div>
                    <div class="list"><span>商品名称:</span><span>哇哈哈纯净水</span><span>数量: 1桶</span></div>
                    <div class="list"><span>收货人:</span><span>王女士,1573574777</span><span></span></div>
                    <div class="list"><span>地址:</span><span>北京市朝阳区十里河大洋路333号微沃办公区B座112室</span><span></span></div>
                </div>
                <div class="item-bot">
                    <span>2018-05-05</span>
                    <span>提成：￥<b>50.00</b></span>
                </div>
            </div> -->
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('.tab1').prop('src','/static/home/song/images/shouji-h.png');
    $('.tab2').prop('src','/static/home/song/images/jine.png');
    $('.tab3').prop('src','/static/home/song/images/my-h.png');
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