<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/admin\view\user\update.html";i:1563256854;s:78:"E:\PHPTutorial\WWW\jjzs\jjzs\public/../application/admin\view\Public\base.html";i:1563256854;}*/ ?>
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
    <h3 class="panel-title">修改</h3>
  </div>
  <div id="demo-custom-toolbar2" class="table-toolbar-left">
        <a href="javascript:;" id="demo-dt-addrow-btn" class="btn btn-primary" onClick="javascript:history.back()">返回列表</a> 
  </div>
  <br/>
  <br/>
  <!-- Panel body -->
  <form id="demo-bv-errorcnt" class="form-horizontal bv-form" action="" method="POST" novalidate="novalidate">
    <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
    <div class="panel-body">
      <div class="tab-content">
        <!--SHOWING ERRORS IN TOOLTIP-->
        <!--===================================================-->
        <div id="demo-tabs-box-1" class="tab-pane fade in active">
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">用户类型</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" '' name="identity" disabled value="<?php echo $update['identity']; ?>" placeholder="用户类型" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
                   <!--  <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">用户名称</label>
            <div class="col-lg-4">
              <input type="number" step="0.01" class="form-control"  '' name="username" value="<?php echo $update['username']; ?>" placeholder="用户名称" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div> -->
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">昵称</label>
            <div class="col-lg-4">
              <input type="text" class="form-control"  '' name="nickname" value="<?php echo $update['nickname']; ?>" placeholder="昵称" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">用户头像</label>
            <div class="col-lg-4">
              <img src="<?php echo $update['photo']; ?>" alt="" style="width: 150px;height: 120px;">
            </div>
          </div>
<!--             <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">用户头像</label>
            <div class="col-lg-4">
              <input type="file" class="form-control" name="photo" placeholder="用户头像" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div> -->
           <div class="form-group has-femobileedback">
            <label class="col-lg-3 control-label">手机号码</label>
            <div class="col-lg-4">
              <input type="number" class="form-control"  '' name="mobile" value="<?php echo $update['mobile']; ?>" placeholder="手机号码" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
           <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">会员类型</label>
            <div class="col-lg-4">
              <input type="text" class="form-control"  disabled name="identification" value="<?php echo $update['identification']; ?>" placeholder="会员类型" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">状态</label>
            <div class="col-lg-7">
              <input type="radio" name="level" value="1" <?php echo $update['level'] == 1 ? "checked" : ''; ?>>普通会员
              <input type="radio" name="level" value="2" <?php echo $update['level'] == 2 ? "checked" : ''; ?>>银卡会员
              <input type="radio" name="level" value="3" <?php echo $update['level'] == 3 ? "checked" : ''; ?>>金卡会员

            </div>
          </div>

           <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">账户余额</label>
            <div class="col-lg-4">
              <input type="number" step="0.01" class="form-control" disabled  name="money" value="<?php echo $update['money']; ?>" placeholder="账户余额" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">帐户不可提现金额</label>
            <div class="col-lg-4">
              <input type="number" step="0.01" class="form-control" disabled name="noMoney" value="<?php echo $update['noMoney']; ?>" placeholder="帐户不可提现金额" data-bv-field="name">
              <i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
            </div>
        
        </div>
      
        <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">状态</label>
            <div class="col-lg-7">
              <input type="radio" name="status" value="0" <?php echo $update['status'] == 0 ? "checked" : ''; ?>>冻结
              <input type="radio" name="status" value="1" <?php echo $update['status'] == 1 ? "checked" : ''; ?>>正常

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
      $('.delData').click(function(){
         var src = $(this).attr('src');
         var goods_img = $("#goods_img").val();
         var str1 = goods_img.replace(src+',', '');
         $("#goods_img").val(str1);
         $(this).css('display','none');
      });
      $('#CreateSubmit').click(function(){
        var formData = new FormData($('#demo-bv-errorcnt')[0]);
        $.ajax({
          type: 'POST',
          url:'/Admin/User/DoUpdate?id=<?php echo $update['id']; ?>',
          data:formData,
          contentType: false,
          processData: false,
          success: function(data){
              var data= eval('('+data+')');
              if (data.code == 1) {
                  layer.msg(data.meg, function(){
                    //关闭后的操作
                  });
                  setTimeout(function(){
                    window.location.href=document.referrer;
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
      jQuery(function() {
        var $ = jQuery,

        $wrap = $('#uploader'),

        // 图片容器
        $queue = $('<ul class="filelist"></ul>')
            .appendTo( $wrap.find('.queueList') ),

        // 状态栏，包括进度和控制按钮
        $statusBar = $wrap.find('.statusBar'),

        // 文件总体选择信息。
        $info = $statusBar.find('.info'),

        // 上传按钮
        $upload = $wrap.find('.uploadBtn'),

        // 没选择文件之前的内容。
        $placeHolder = $wrap.find('.placeholder'),

        // 总体进度条
        $progress = $statusBar.find('.progress').hide(),

        // 添加的文件数量
        fileCount = 0,

        // 添加的文件总大小
        fileSize = 0,

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 110 * ratio,
        thumbnailHeight = 110 * ratio,

        // 可能有pedding, ready, uploading, confirm, done.
        state = 'pedding',

        // 所有文件的进度信息，key为file id
        percentages = {},



        // WebUploader实例
        uploader;

        if ( !WebUploader.Uploader.support() ) {
            alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
            throw new Error( 'WebUploader does not support the browser you are using.' );
        }

        // 实例化
        uploader = WebUploader.create({
            pick: {
                id: '#filePicker',
                label: '点击选择图片'
            },
            dnd: '#uploader .queueList',
            paste: document.body,
            formData: {
            // 这里的token是外部生成的长期有效的，如果把token写死，是可以上传的。
            // 我想上传时再请求服务器返回token，改怎么做呢？反复尝试而不得。谢谢大家了！
            //uptoken_url: '127.0.0.1:8080/examples/upload_token.php'
            },
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'
            },
            disableGlobalDnd: true,
            chunked: true,
            // server: 'http://webuploader.duapp.com/server/fileupload.php',
            server: '/Admin/Goods/AddGoodsImg',
            fileNumLimit: 300,
            fileSizeLimit: 5000 * 1024 * 1024,    // 200 M
            fileSingleSizeLimit: 1000 * 1024 * 1024    // 50 M
        });

         // 添加“添加文件”的按钮，
        uploader.addButton({
            id: '#filePicker2',
            label: '继续添加'
        });

        // 当有文件添加进来时执行，负责view的创建
        function addFile( file ) {
            var $li = $( '<li id="' + file.id + '">' +
                    '<p class="title">' + file.name + '</p>' +
                    '<p class="imgWrap"></p>'+
                    '<p class="progress"><span></span></p>' +
                    '</li>' ),

                $btns = $('<div class="file-panel">' +
                    '<span class="cancel">删除</span>' +
                    '<span class="rotateRight">向右旋转</span>' +
                    '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li ),
                $prgress = $li.find('p.progress span'),
                $wrap = $li.find( 'p.imgWrap' ),
                $info = $('<p class="error"></p>'),

                showError = function( code ) {
                    switch( code ) {
                        case 'exceed_size':
                            text = '文件大小超出';
                            break;

                        case 'interrupt':
                            text = '上传暂停';
                            break;

                        default:
                            text = '上传失败，请重试';
                            break;
                    }

                    $info.text( text ).appendTo( $li );
                };

            if ( file.getStatus() === 'invalid' ) {
                showError( file.statusText );
            } else {
                // @todo lazyload
                $wrap.text( '预览中' );
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $wrap.text( '不能预览' );
                        return;
                    }

                    var img = $('<img src="'+src+'">');
                    $wrap.empty().append( img );
                }, thumbnailWidth, thumbnailHeight );

                percentages[ file.id ] = [ file.size, 0 ];
                file.rotation = 0;
            }

            file.on('statuschange', function( cur, prev ) {
                if ( prev === 'progress' ) {
                    $prgress.hide().width(0);
                } else if ( prev === 'queued' ) {
                    $li.off( 'mouseenter mouseleave' );
                    $btns.remove();
                }

                // 成功
                if ( cur === 'error' || cur === 'invalid' ) {
                    console.log( file.statusText );
                    showError( file.statusText );
                    percentages[ file.id ][ 1 ] = 1;
                } else if ( cur === 'interrupt' ) {
                    showError( 'interrupt' );
                } else if ( cur === 'queued' ) {
                    percentages[ file.id ][ 1 ] = 0;
                } else if ( cur === 'progress' ) {
                    $info.remove();
                    $prgress.css('display', 'block');
                } else if ( cur === 'complete' ) {
                    $li.append( '<span class="success"></span>' );
                }

                $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
            });

            $li.on( 'mouseenter', function() {
                $btns.stop().animate({height: 30});
            });

            $li.on( 'mouseleave', function() {
                $btns.stop().animate({height: 0});
            });

            $btns.on( 'click', 'span', function() {
                var index = $(this).index(),
                    deg;

                switch ( index ) {
                    case 0:
                        uploader.removeFile( file );
                        return;

                    case 1:
                        file.rotation += 90;
                        break;

                    case 2:
                        file.rotation -= 90;
                        break;
                }

                if ( supportTransition ) {
                    deg = 'rotate(' + file.rotation + 'deg)';
                    $wrap.css({
                        '-webkit-transform': deg,
                        '-mos-transform': deg,
                        '-o-transform': deg,
                        'transform': deg
                    });
                } else {
                    $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                }


            });

            $li.appendTo( $queue );
        }

        // 负责view的销毁
        function removeFile( file ) {
            var $li = $('#'+file.id);

            delete percentages[ file.id ];
            updateTotalProgress();
            $li.off().find('.file-panel').off().end().remove();
        }

        function updateTotalProgress() {
            var loaded = 0,
                total = 0,
                spans = $progress.children(),
                percent;

            $.each( percentages, function( k, v ) {
                total += v[ 0 ];
                loaded += v[ 0 ] * v[ 1 ];
            } );

            percent = total ? loaded / total : 0;

            spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
            spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
            updateStatus();
        }


        uploader.on('uploadSuccess', function (file, response) {
             var goods_img = $("#goods_img").val();
             goods_img += response._raw+",";
             $('#goods_img').val(goods_img);
             console.log(goods_img);
        });


        function updateStatus() {
            var text = '', stats;

            if ( state === 'ready' ) {
                text = '选中' + fileCount + '张图片，共' +
                        WebUploader.formatSize( fileSize ) + '。';
            } else if ( state === 'confirm' ) {
                stats = uploader.getStats();
                if ( stats.uploadFailNum ) {
                    text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+
                        stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                }

            } else {
                stats = uploader.getStats();
                text = '共' + fileCount + '张（' +
                        WebUploader.formatSize( fileSize )  +
                        '），已上传' + stats.successNum + '张';

                if ( stats.uploadFailNum ) {
                    text += '，失败' + stats.uploadFailNum + '张';
                }
            }

            $info.html( text );
        }

        function setState( val ) {
            var file, stats;

            if ( val === state ) {
                return;
            }

            $upload.removeClass( 'state-' + state );
            $upload.addClass( 'state-' + val );
            state = val;

            switch ( state ) {
                case 'pedding':
                    $placeHolder.removeClass( 'element-invisible' );
                    $queue.parent().removeClass('filled');
                    $queue.hide();
                    $statusBar.addClass( 'element-invisible' );
                    uploader.refresh();
                    break;

                case 'ready':
                    $placeHolder.addClass( 'element-invisible' );
                    $( '#filePicker2' ).removeClass( 'element-invisible');
                    $queue.parent().addClass('filled');
                    $queue.show();
                    $statusBar.removeClass('element-invisible');
                    uploader.refresh();
                    break;

                case 'uploading':
                    $( '#filePicker2' ).addClass( 'element-invisible' );
                    $progress.show();
                    $upload.text( '暂停上传' );
                    break;

                case 'paused':
                    $progress.show();
                    $upload.text( '继续上传' );
                    break;

                case 'confirm':
                    $progress.hide();
                    $upload.text( '开始上传' ).addClass( 'disabled' );

                    stats = uploader.getStats();
                    if ( stats.successNum && !stats.uploadFailNum ) {
                        setState( 'finish' );
                        return;
                    }
                    break;
                case 'finish':
                    stats = uploader.getStats();
                    if ( stats.successNum ) {
                        alert( '上传成功' );
                    } else {
                        // 没有成功的图片，重设
                        state = 'done';
                        location.reload();
                    }
                    break;
            }

            updateStatus();
        }

        uploader.onUploadProgress = function( file, percentage ) {
            var $li = $('#'+file.id),
                $percent = $li.find('.progress span');

            $percent.css( 'width', percentage * 100 + '%' );
            percentages[ file.id ][ 1 ] = percentage;
            updateTotalProgress();
        };

        uploader.onFileQueued = function( file ) {
            fileCount++;
            fileSize += file.size;

            if ( fileCount === 1 ) {
                $placeHolder.addClass( 'element-invisible' );
                $statusBar.show();
            }

            addFile( file );
            setState( 'ready' );
            updateTotalProgress();
        };

        uploader.onFileDequeued = function( file ) {
            fileCount--;
            fileSize -= file.size;

            if ( !fileCount ) {
                setState( 'pedding' );
            }

            removeFile( file );
            updateTotalProgress();

        };

        uploader.on( 'all', function( type ) {
            var stats;
            switch( type ) {
                case 'uploadFinished':
                    setState( 'confirm' );
                    break;

                case 'startUpload':
                    setState( 'uploading' );
                    break;

                case 'stopUpload':
                    setState( 'paused' );
                    break;

            }
        });

        uploader.onError = function( code ) {
            alert( 'Eroor: ' + code );
        };

        $upload.on('click', function() {
            if ( $(this).hasClass( 'disabled' ) ) {
                return false;
            }

            if ( state === 'ready' ) {
                uploader.upload();
            } else if ( state === 'paused' ) {
                uploader.upload();
            } else if ( state === 'uploading' ) {
                uploader.stop();
            }
        });

        $info.on( 'click', '.retry', function() {
            uploader.retry();
        } );

        $info.on( 'click', '.ignore', function() {
            alert( 'todo' );
        } );
        uploader.refresh();
        $upload.addClass( 'state-' + state );
        updateTotalProgress();
      });
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