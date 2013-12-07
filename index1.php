<?php
  $Authorization_Code = $_REQUEST ['code'];
  $APP_KEY = 'aa6b987151744b549324dd0773cb61f8';
  $SecretKey = '1f57ff33521545df9901c6f5a223bd2b';
  $CALLBACK_URL='http://198.52.103.212/renren/united/choose_city.php';
  //��ϻ�ȡtoken�Ľӿ�����
  $base_url="https://graph.renren.com/oauth/token?grant_type=authorization_code&client_id=".$APP_KEY."&redirect_uri=".urlencode($CALLBACK_URL)."&client_secret=".$SecretKey."&code=".$Authorization_Code;
    
  //���ʽӿ�
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $base_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  $result = curl_exec($ch);  
  curl_close($ch);
  //ȡ�����
  
  //������з����userid��access token
  $info=explode(",",$result);

  $pos=strrpos($result,"access_token");
  $token=substr($result,$pos+15);
  $token=str_replace("\"}","",$token);
  
  $pos_1=strcspn($token, "-");
  $id_1=substr($token, $pos_1+1);
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <title>WELCOME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/welcome.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Gorditas:700' rel='stylesheet' type='text/css'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://code.jquery.com/jquery.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>-->
  </head>
  <body>

    <div class="container" id="main">
         <image id="mainpic" src="image/mainBack.jpg">
    </div>
  <div class="container" id="title">
      <span>Party.Us</span>
  </div>
  <div class="container" id="start">
      <a class="welcome" href="instruction.php">START</a>
  </div>
    <form id="resinfo" method="POST" action="choose_friend.php" style="display: none">
        <input type="hidden" id="token" name="token" value="<?php echo $token;?>"/>
        <input type="hidden" id="id" name="id" value="<?php echo $id_1;?>"/>
        <input type="hidden" id="city" name="city" value="北京" />
      </form>


  </body>

</script>
  <script language='javascript'>


function submit()
{
  var resinfo=document.getElementById("resinfo");
  resinfo.submit();

}
</script>
</html>