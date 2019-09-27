<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\merchants\my.html";i:1563256864;s:79:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\shang.html";i:1563256864;}*/ ?>
<!DOCTYPE html>
<html lang="en">


    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>个人中心</title>
    <link rel="stylesheet" href="/static/home/shang/css/my.css">
</head>
<body>
<div class="my">
    <div class="head">
        <div class="content">
            <img src="<?php echo $userInfo['photo']; ?>" class="img-left">
            <div class="information">
                <div class="name"><?php echo $userInfo['nickname']; ?></div>
                <div class="xinxi"><span>手机：<?php echo $userInfo['mobile']; ?></span><span>金额：￥<?php echo $userInfo['money']; ?> <img src="/static/home/shang/images/jian.png"></span></div>
            </div>
        </div>
    </div>
    <div class="list">
        <ul>
            <li>
                <a href="/Index/Suser/yuE">
                    <img class="img-left" src="/static/home/shang/images/yue.png" alt="">
                    <span>账户余额</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/Suser/Record">
                    <img class="img-left" src="/static/home/shang/images/tixian.png" alt="">
                    <span>提现记录</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/Suser/Phone">
                    <img class="img-left" src="/static/home/shang/images/shouji.png" alt="">
                    <span>绑定手机</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/Suser/Head">
                    <img class="img-left" src="/static/home/shang/images/tou.png" alt="">
                    <span>更换头像</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/Suser/Erweima">
                    <img class="img-left" src="/static/home/shang/images/erweima.png" alt="">
                    <span>商家二维码</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="/index/Suser/Password">
                    <img class="img-left" src="/static/home/shang/images/mima.png" alt="">
                    <span>修改密码</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
            <li>
                <a href="tel://15735717777">
                    <img class="img-left" src="/static/home/shang/images/lianxi.png" alt="">
                    <span>联系总部</span>
                    <img class="img-right" src="/static/home/shang/images/jian1.png" alt="">
                </a>
            </li>
        </ul>
    </div>


<div class="footer">
    <div class="content">
        <ul>
            <li>
                <a href="/index/Suser/index">
                    <img src="/static/home/shang/images/shouyi.png" alt="">
                    <p>收益记录</p>
                </a>
            </li>
            <li>
                <a href="/index/Suser/Suser">
                    <img src="/static/home/shang/images/my.png" alt="">
                    <p>个人中心</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="/static/home/shang/js/jquery-3.2.1.min.js"></script>
<script src="/static/home/shang/js/index.js"></script>
</body>
</html>