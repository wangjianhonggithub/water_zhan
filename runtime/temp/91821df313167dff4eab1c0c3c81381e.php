<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\my.html";i:1563256878;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
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
    
<link rel="stylesheet" href="/static/home/song/css/my.css">
    <div class="list">
        <ul>
            <li>
                <a href="/index/User/bandPhone">
                    <img class="img-left" src="/static/home/song/images/shouji2.png" alt="">
                    <span>绑定手机</span>
                    <img class="img-right" src="/static/home/song/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/User/updateImage">
                    <img class="img-left" src="/static/home/song/images/tou.png" alt="">
                    <span>更换头像</span>
                    <img class="img-right" src="/static/home/song/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/User/Password">
                    <img class="img-left" src="/static/home/song/images/mima.png" alt="">
                    <span>修改密码</span>
                    <img class="img-right" src="/static/home/song/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="tel://15735717777">
                    <img class="img-left" src="/static/home/song/images/lianxi.png" alt="">
                    <span>联系总部</span>
                    <img class="img-right" src="/static/home/song/images/jian1.png" alt="">
                </a>
            </li>
        </ul>
    </div>
<script type="text/javascript">
$(function(){
    $('.tab1').prop('src','/static/home/song/images/shouji-h.png');
    $('.tab2').prop('src','/static/home/song/images/jine-h.png');
    $('.tab3').prop('src','/static/home/song/images/my.png');
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