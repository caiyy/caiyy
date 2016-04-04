<?php

include('common.php');

$act = $_GET['act'];

if($act == 'login'){

    include('dbClass.php');

    $user = $_POST['user'];

    $pass = md5($_POST['pass']);

    echo yzuser($user,$pass);

    exit;

}elseif($act == 'logout'){

    include('dbClass.php');

    yzuser('','','logout');

}

?>



<!DOCTYPE html>

<html>

<head lang="en">

    <meta charset="UTF-8">

    <title><?php echo $xt_name ?>-后台登陆</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="format-detection" content="telephone=no">

    <meta name="renderer" content="webkit">

    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">

    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>

    <link rel="stylesheet" href="css/login.css"/>

    <script src="assets/js/jquery.min.js"></script>

    <script src="assets/js/amazeui.min.js"></script>

<script type="text/javascript">  
$(function(){
  if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){ 
    if(window.location.href.indexOf("?mobile")<0){ 
        try{ 
            $(".main-container,.header .am-g p,.downnn").hide();
            $(".header .am-g h1").css({"font-size":"150%"});
            $(".am-g .am-u-sm-centered").removeClass('am-u-sm-centered');
            $(".am-g .am-panel-secondary").removeClass('am-panel');
            $("[class*=am-u-]").css({"padding-left":"0","padding-right":"0"});
            $("body,input").css("text-align","center");
            $(".am-btn").removeClass('am-btn-sm').addClass('am-btn-xl');
            $(".am-form").css({"width":"200px","margin":"0 auto"});
        }catch(e){} 
    } 
  } 
})

</script> 
</head>

<body class="am-monospace">

<div class="main-container">

    <div class="wrapper">

        <ul class="bg-bubbles">

          <li></li>

          <li></li>

          <li></li>

          <li></li>

          <li></li>

          <li></li>

          <li></li>

          <li></li>

          <li></li>

          <li></li>

        </ul>

    </div>

</div>





<div class="header">

  <div class="am-g">

    <h1>Welocme To <?php echo $xt_name ?></h1>

    <p><br/></p>

  </div>

</div>

<div class="am-g">

  <div class="am-u-lg-3 am-u-md-8 am-u-sm-centered">

    <section class="am-panel am-panel-secondary">

      <header class="am-panel-hd">

        <h3 class="am-panel-title">用户登录</h3>

      </header>

      <div class="am-panel-bd">

      <img src="/images/theatre.png" alt="..." class="img-circle" style="margin-bottom:20px; width:100px; height:100px;">

        <form method="post" class="am-form" action="login.php?act=login">

          <input class="input" placeholder="请输入您的账号" type="text" name="user" value="">

          <br />

          <input class="input" placeholder="请输入您的密码" type="password" name="password" value="">

          <br />

          <div class="am-btn-group" style="margin-bottom: 10px;">

          <button type="submit" class="am-btn am-btn-secondary am-btn-sm am-fr" style="width:80px;">登录</button>

          <button type="reset" class="am-btn am-btn-secondary am-btn-sm am-fr" style="width:80px;">重置</button>

          </div>

      </div>

      <div class="am-panel-footer">

        <div class="am-cf">

          <div style="color: #31708f;text-align:center;">本站由<a style="margin:0 5px" target="_blank" href="http://www.caiyy.cn/">Caiyy</a>提供技术支持

        </div>

        </form>

      </div>

    </section>

  </div>



  <p class="downnn">© 2015 <a href="http://www.caiyy.cn/" target="_blank">Caiyy</a>, Inc.</p>

</div>



<div class="am-modal am-modal-no-btn" tabindex="-1" id="your-modal">

  <div class="am-modal-dialog">

    <div class="am-modal-hd">

      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>

    </div>

    <div class="am-modal-bd">

    </div>

  </div>

</div>



<script>

$(function(){

  $(".am-form button[type=submit]").click(function(){

    var user_ = $(".am-form input[name=user]");

    var pass_ = $(".am-form input[name=password]");

    if(user_.val().length < 5 || pass_.val().length < 5){

      $(".am-panel").addClass("am-animation-shake");

      setTimeout(function(){

        $(".am-panel").removeClass("am-animation-shake");

        $("#your-modal .am-modal-bd").html("帐号或密码输入错误<br/>请查正后重试.");

        $("#your-modal").modal({width:300});

      },300);

      user_.val("");

      pass_.val("");

    }else{

      $("#your-modal .am-modal-bd").html("登录中,请稍候.");

      $.post("?act=login",

      {

        user:user_.val(),

        pass:pass_.val()

      },

      function(data,zt){

          $(".am-panel").removeClass("am-animation-shake").addClass("am-animation-scale-up am-animation-reverse");

            var xs = "<h1>登陆失败</h1><br/>帐号或密码错误";

          if(data == "success"){

            var xs = "<h1>登陆成功</h1><br/>三秒后进入管理界面<br/>如果您的浏览器无法跳转,请点击 <a href='admin.php?act=index'>这里</a>";

          }

          $("#your-modal .am-modal-bd").html(xs);

          $("#your-modal .am-close-spin").hide();

          $("#your-modal").modal({width:300,closeViaDimmer:0});

          if(data == "success"){

            setTimeout(function(){

              window.location.href="admin.php?act=index";

            },3000);

          }

      })

    }

  return false;

  })

})

</script>

</body>

</html>