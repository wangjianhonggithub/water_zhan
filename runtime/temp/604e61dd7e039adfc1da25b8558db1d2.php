<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\songshuiyuan\head.html";i:1563256878;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/index\view\Public\base.html";i:1563256864;}*/ ?>
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
    
<link rel="stylesheet" href="/static/layui/css/layui.css">   
<script src="/static/layui/layui.all.js"></script>

<!-- <link rel="stylesheet" href="/static/home/song/css/phone.css"> -->
<div class="con4">
    <canvas id="cvs" width="200" height="200"></canvas>
    <span class="btn upload">更换头像<input type="file" class="upload_pic" id="upload" /></span>
    <link rel="stylesheet" href="/static/home/song/css/head.css">
</div>



<script src="/static/home/song/js/jquery-3.2.1.min.js"></script>
<script src="/static/home/song/js/index.js"></script>
<script>
    //获取上传按钮
    var input1 = document.getElementById("upload");

    if(typeof FileReader==='undefined'){
        //result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
        input1.setAttribute('disabled','disabled');
    }else{
        input1.addEventListener('change',readFile,false);
        /*input1.addEventListener('change',function (e){
         console.log(this.files);//上传的文件列表
         },false); */
    }
    function readFile(){
        var file = this.files[0];//获取上传文件列表中第一个文件
        if(!/image\/\w+/.test(file.type)){
            //图片文件的type值为image/png或image/jpg
            layer.msg('文件必须为图片！', function(){
                    //关闭后的操作
                    
                  });
            return false;
            alert("文件必须为图片！");
            // return false;
        }
        // console.log(file);
        var reader = new FileReader();//实例一个文件对象
        reader.readAsDataURL(file);//把上传的文件转换成url
        //当文件读取成功便可以调取上传的接口
        reader.onload = function(e){
            // console.log(this.result);//文件路径
            // console.log(e.target.result);//文件路径
            var data = e.target.result.split(',');
             var tp = (file.type == 'image/png')? 'png': 'jpg';
             var imgUrl = data[1];//图片的url，去掉(data:image/png;base64,)
             //需要上传到服务器的在这里可以进行ajax请求
             var myUrl  = "/Index/User/DoupdateImage";
            

             $.ajax({
                  url: myUrl,
                  type: 'post',
                  dataType: 'json',
                  data:{'photo':e.target.result},
                  timeout: 1000,
                  success: function (data, status) {
                    if (data.code == '1001'){

                        layer.msg(data.msg, function(){
                            
                          });

                        setTimeout(function(){
                        window.location.href=document.referrer;
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


             // console.log(imgUrl);
             // 创建一个 Image 对象
             var image = new Image();
             // 创建一个 Image 对象
             // image.src = imgUrl;
             image.src = e.target.result;
             image.onload = function(){
             // document.body.appendChild(image);
             }

            var image = new Image();
            // 设置src属性
            image.src = e.target.result;
            var max=200;
            // 绑定load事件处理器，加载完成后执行，避免同步问题
            image.onload = function(){
                // 获取 canvas DOM 对象
                var canvas = document.getElementById("cvs");
                // 如果高度超标 宽度等比例缩放 *=
                /*if(image.height > max) {
                 image.width *= max / image.height;
                 image.height = max;
                 } */
                // 获取 canvas的 2d 环境对象,
                var ctx = canvas.getContext("2d");
                // canvas清屏
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                // 重置canvas宽高
                /*canvas.width = image.width;
                 canvas.height = image.height;
                 if (canvas.width>max) {canvas.width = max;}*/
                // 将图像绘制到canvas上
                // ctx.drawImage(image, 0, 0, image.width, image.height);
                ctx.drawImage(image, 0, 0, 200, 200);
                // 注意，此时image没有加入到dom之中
            };
        }
    };
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