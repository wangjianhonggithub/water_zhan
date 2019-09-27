<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\phone.html";i:1563256878;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
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
    
<script src="/static/layui/layui.all.js"></script>
<link rel="stylesheet" href="/static/layui/css/layui.css">      
<link rel="stylesheet" href="/static/home/song/css/phone.css">

<form action="">
    <div>
        <div class="con phone">
            <input type="text" id="mobile" placeholder="请输入您的手机号">
            <div class="inp1 msgs">获取验证码</div>
        </div>
        <div class="con">
            <input type="text" id="recode" placeholder="请输入验证码">
        </div>
        <div class="con btn">
            <input type="button"  class="btns" value="确认绑定">
        </div>
    </div>
</form>
<script type="text/javascript">
$(function(){

    $('.btns').click(function(){
        var myUrl  = "/Index/Login/UpdatePhone";
        var mobile = $('#mobile').val();
        var recode = $('#recode').val();
        $.ajax({
          url: myUrl,
          type: 'get',
          dataType: 'json',
          data:{mobile:mobile,'recode':recode},
          timeout: 1000,
          success: function (data) {
            if(data.code == '1001'){
                layer.msg(data.msg, function(){
                    //关闭后的操作
                  });
                  setTimeout(function(){
                    window.location.href=document.referrer;
                  },1500);
                // alert(data.msg);
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