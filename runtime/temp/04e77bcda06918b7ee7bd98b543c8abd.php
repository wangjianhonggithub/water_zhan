<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\login.html";i:1563256878;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>商家登录</title>
    <link rel="stylesheet" href="/static/home/song/css/login.css">
    <!-- <link rel="stylesheet" href="/static/home/song/css/login.css"> -->
</head>
<body>

<form action="/index/Login/DoLogin" method="POST">
    <input type="hidden" name="identity" value="3">
    <img src="/static/home/song/images/logo.png" class="img-top">
    <div>
        <div class="con">
            <input type="text" name="userName" placeholder="请输入您的账号">
        </div>
        <div class="con">
            <input type="password" name="password" placeholder="请输入您的密码">
        </div>
        <div class="con forgot">
            <a href="/index/Login/updatePass">忘记登录密码？</a>
        </div>
        <div class="con btn">
            <input type="submit" value="登录">
        </div>
    </div>
</form>

<script src="/static/home/song/js/jquery-3.2.1.min.js"></script>
<script src="/static/home/song/js/index.js"></script>
</body>
</html>