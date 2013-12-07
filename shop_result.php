<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <script type="text/javascript" src="renren.js"></script>
  <head>
    <title>WELCOME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
	<link href="css/default.css" rel="stylesheet">
  <link href="css/shopResult.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Gorditas:700' rel='stylesheet' type='text/css'>
  <?php include('handleres.php'); ?>
  </head>
  <body style="width:740px">
<input type="hidden" value="聚会！" id="title"/><br/>
<input type="hidden" value="我找到了一个很好的聚会地点，快来看看！" id="description"/><br/>
<input type="hidden" value="<?php $shopArray[1]->b_Pic?>" id="image" /><br/>
<input type="hidden" value="http://apps.renren.com/partyus" id="url" /><br/>
<input type="hidden" value="我选了几个地方作为聚会地点！！" id="message" /><br/>
<input type="hidden" id="action_name" value="通过聚会神器发布" /><br>
<input type="hidden" id="action_link" value="http://http://apps.renren.com/partyus/" /><br>
<!--点击确定或取消后跳转的url：<input type="text" value="http://127.0.0.1" id="redirect_uri" /><br/>-->
<script type="text/javascript">
    function sendFeed() {
        var title=document.getElementById("title").value;
        var description=document.getElementById("description").value;
        var image=document.getElementById("image").value;
        var url=document.getElementById("url").value;
        var message=document.getElementById("message").value;
        var action_name=document.getElementById("action_name").value;
        var action_link=document.getElementById("action_link").value;
        //var redirect_uri=document.getElementById("redirect_uri").value;
        var style={
              top:100,
              left:100,
              height:400,
              width:500
      };/*用于设置弹层的位置和大小*/
        var uiOpts = {
          url : "feed",
          display : "popup",
          method : "post",
          params : {
            "url":url,
            "name":title,
            "description":description,
            "image":image,
            "message":message,
            "action_name":action_name,
            "action_link":action_link
          },
          //style : style,
          onSuccess: function(r){/*alert("success!");*/},
          onFailure: function(r){/*alert("fail");document.getElementById("ttt").value="111";*/} 
      };
      Renren.ui(uiOpts);
    }
</script>
    <div class="container" id="main" style="position: relative;margin-top: -110px;">
      <div class="banner" id="upleft">
          <span id="title">TOP-10</span>
      </div>
      
      <div id="daocha1" style="top: 2px;">
        <img src="image/daocha.png">
      </div>
      
      <div id="content">
        <table>
        <tr><td><img src="image/dazhonglogo.png">大众点评提供数据</td></tr>
        <?php
          //显示获取到的商家信息
        if(count($shopArray)>0){
           for($i=0;$i<10;$i++)
           {
              echo "<tr class='shop'>";
              echo "<td><img class='shopPic' src='".$shopArray[$i]->b_Pic."'></td>";
              echo "<td>";
              echo "<td><span class='shopName'>【".$shopArray[$i]->b_Name."】</span>";
              echo "<span class='shopScore'>".$shopArray[$i]->b_Score."分</span><br>";
              if($shopArray[$i]->b_Deal['deal_exist']==1){
                echo "<br><span class='dealUrl'>这个店有团购~</span>";
              }
              if($shopArray[$i]->b_Coupon['coupon_exist']==1){
                echo "<br><span class='dealUrl'>这个店优惠券链接~</span>";
              }
              echo "</td></tr>";
              echo "</td></tr>";

           }
         }
         else{
              echo "<span id='nores'>亲，木有你要找的店，要不你再试试？~</span>";
         }
        ?>
        </table>
      </div>

      <div class="banner" id="downright" style="right: 0px;margin-top: 25px;">
         <script type="text/javascript">Renren.init({appId:<?=243058?>});</script>
  <a onclick="sendFeed()" href="javascript:;">通知好友</a><br>
      </div>
      
      <div id="daocha2" style="margin-top: -27px;margin-right: 47px;">
        <img src="image/daocha.png">
      </div>
    </div>



  </body>

</script>
  
</html>