<?php
  $Authorization_Code = $_REQUEST ['code'];
  $APP_KEY = 'aa6b987151744b549324dd0773cb61f8';
  $SecretKey = '1f57ff33521545df9901c6f5a223bd2b';
  $CALLBACK_URL='http://198.52.103.212/renren/united/choose_city.php';
  $base_url="https://graph.renren.com/oauth/token?grant_type=authorization_code&client_id=".$APP_KEY."&redirect_uri=".urlencode($CALLBACK_URL)."&client_secret=".$SecretKey."&code=".$Authorization_Code;
    
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $base_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  $result = curl_exec($ch);  
  curl_close($ch);
  

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
    <title>选择城市</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
	<link href="css/default.css" rel="stylesheet">
  <link href="css/choose_city.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Gorditas:700' rel='stylesheet' type='text/css'>
  </head>
  <body style="width:740px">
    <div class="container" id="main">
      <div class="banner" id="upleft">
          <span id="title">选择城市</span>
      </div>
      
      <div id="daocha1">
        <img src="image/daocha.png">
      </div>
    
      <div id="content">
        <fieldset style="text-align:center;"> 
          <legend style="font-size:25px;color:yellow;">聚会神器(Party.Us)-选择你所在的城市</legend>
             <select id="citySelect" onchange="cityChange()">
             <option value="北京">北京</option>
             <option value="上海">上海</option>
             <option value="广州">广州</option>
             <option value="武汉">武汉</option>
             <option value="深圳">深圳</option>
             <option value="天津">天津</option>
             <option value="青岛">青岛</option>
             <option value="南京">南京</option>
             <option value="西安">西安</option>
             </select>
        </fieldset>
      </div>

      <form id="resinfo" method="POST" action="choose_friend.php">
        <input type="hidden" id="token" name="token" value="<?php echo $token;?>"/>
        <input type="hidden" id="id" name="id" value="<?php echo $id_1;?>"/>
        <input type="hidden" id="city" name="city" value="北京" />
      </form>

      <div class="banner" id="downright" style="margin-top:105px;">
        <a style="CURSOR: hand" onclick="submit()">Next</a>
      </div>
      
      <div id="daocha2" style="margin-top:53px;">
        <img src="image/daocha.png">
      </div>
    </div>



  </body>
<script language='javascript'>
function cityChange()
{
    var city=$("#citySelect  option:selected").text();
    $("#city").val(city);
}

function submit()
{
  var resinfo=document.getElementById("resinfo");
  resinfo.submit();

}
</script>
  
</html>