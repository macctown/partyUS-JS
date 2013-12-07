<?php
  session_start ();
  //声明将要用到的一些变量
  $APP_KEY = 'aa6b987151744b549324dd0773cb61f8';
  $SecretKey = '1f57ff33521545df9901c6f5a223bd2b';
  $CALLBACK_URL='http://198.52.103.212/renren/united/choose_city.php';
  $scope="publish_feed send_invitation read_user_photo";
  //这是要用https访问的一个接口，功能：进行授权
  $base_url="https://graph.renren.com/oauth/authorize?client_id=".$APP_KEY."&redirect_uri=".urlencode($CALLBACK_URL)."&response_type=code&scope=".urlencode($scope)."&display=page";
?>

<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <title>说明</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
	<link href="css/default.css" rel="stylesheet">
  <link href="css/instruction.css" rel="stylesheet">  
  <link href='http://fonts.googleapis.com/css?family=Gorditas:700' rel='stylesheet' type='text/css'>
  </head>
  <body style="width:730px">
    <div class="container" id="main">
      <div class="banner" id="upleft">
          <span id="title">说  明</span>
      </div>
      
      <div id="daocha1">
        <img src="image/daocha.png">
      </div>
      
      <div id="content">
        <fieldset> 
          <legend style="font-size:25px;color:yellow;">聚会神器(Party.Us)-使用说明书</legend> 
           <ul> 
             <br><li>选择你所在的城市（此版本只提供有限个数城市），点击Next</li> 
             <br><li>选择这次聚会的好友，一定要是与你在同一城市的哟！点击Next</li> 
             <br><li>输入聚会想去的地点类别（如：烧烤、KTV、家常菜等），点击Search</li> 
             <br><li>查看“聚会神器”秘制算法计算出来的TOP-10，点击分享，告诉你的好友</li> 
           </ul> 
        </fieldset>
      </div>

      <div class="banner" id="downright" style="margin-top:23px;">
        <a href="<?=$base_url?>">Next</a>
      </div>
      
      <div id="daocha2" style="margin-top:-28px;">
        <img src="image/daocha.png">
      </div>
    </div>



  </body>

</script>
  
</html>