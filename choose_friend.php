<?php

	$id_1=$_REQUEST['id'];
  $city=$_REQUEST['city'];
  $token=$_REQUEST['token'];
	$frieng_api="https://api.renren.com/v2/user/friend/list?access_token=".$token."&userId=".$id_1."&pageSize=100";
 //file_get 方法
  $friend=file_get_contents($frieng_api);

//处理数据
	$arr=json_decode($friend, TRUE);
	$obj=json_decode($friend);

 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <style>
  .scroll-pane { overflow: auto; width: 99%; float:left; }
  .scroll-content { width: 2440px; float: left; }
  .scroll-content-item { width: 100px; height: 105px; float: left; margin: 10px; font-size: 3em; line-height: 96px; text-align: center;display: block; }
  .scroll-bar-wrap { clear: left; padding: 0 4px 0 2px; margin: 0 -1px -1px -1px; }
  .scroll-bar-wrap .ui-slider { background: none; border:0; height: 2em; margin: 0 auto;  }
  .scroll-bar-wrap .ui-handle-helper-parent { position: relative; width: 100%; height: 100%; margin: 0 auto; }
  .scroll-bar-wrap .ui-slider-handle { top:.2em; height: 1.5em; }
  .scroll-bar-wrap .ui-slider-handle .ui-icon { margin: -8px auto 0; position: relative; top: 50%; }
  .username{font-size: 10px;}
  .userhead{width:50px;height:50px;}
  #a{display:none; 
  }
  </style>
  <script>
  $(function() {
    //scrollpane parts
    var scrollPane = $( ".scroll-pane" ),
      scrollContent = $( ".scroll-content" );
 
    //build slider
    var scrollbar = $( ".scroll-bar" ).slider({
      slide: function( event, ui ) {
        if ( scrollContent.width() > scrollPane.width() ) {
          scrollContent.css( "margin-left", Math.round(
            ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
          ) + "px" );
        } else {
          scrollContent.css( "margin-left", 0 );
        }
      }
    });
    //set the max value of slider
    //append icon to handle
    var handleHelper = scrollbar.find( ".ui-slider-handle" )
    .mousedown(function() {
      scrollbar.width( handleHelper.width() );
    })
    .mouseup(function() {
      scrollbar.width( "100%" );
    })
    .append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
    .wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
 
    //change overflow to hidden now that slider handles the scrolling
    scrollPane.css( "overflow", "hidden" );
 
    //size scrollbar and handle proportionally to scroll distance
    function sizeScrollbar() {
      var remainder = scrollContent.width() - scrollPane.width();
      var proportion = remainder / scrollContent.width();
      var handleSize = scrollPane.width() - ( proportion * scrollPane.width() );
      scrollbar.find( ".ui-slider-handle" ).css({
        width: handleSize,
        "margin-left": -handleSize / 2
      });
      handleHelper.width( "" ).width( scrollbar.width() - handleSize );
    }
 
    //reset slider value based on scroll content position
    function resetValue() {
      var remainder = scrollPane.width() - scrollContent.width();
      var leftVal = scrollContent.css( "margin-left" ) === "auto" ? 0 :
        parseInt( scrollContent.css( "margin-left" ) );
      var percentage = Math.round( leftVal / remainder * 100 );
      scrollbar.slider( "value", percentage );
    }
 
    //if the slider is 100% and window gets larger, reveal content
    function reflowContent() {
        var showing = scrollContent.width() + parseInt( scrollContent.css( "margin-left" ), 10 );
        var gap = scrollPane.width() - showing;
        if ( gap > 0 ) {
          scrollContent.css( "margin-left", parseInt( scrollContent.css( "margin-left" ), 10 ) + gap );
        }
    }
 
    //change handle position on window resize
    $( window ).resize(function() {
      resetValue();
      sizeScrollbar();
      reflowContent();
    });
    //init scrollbar size
    setTimeout( sizeScrollbar, 10 );//safari wants a timeout
  });
  </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/default.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Gorditas:700' rel='stylesheet' type='text/css'>
</head>
<body style="width:740px">
    <div class="container" id="main">
        <div class="banner" id="upleft">
            <span id="title">选择好友</span>
        </div>
        <div id="daocha1">
            <img src="image/daocha.png">
        </div>
        <div class="scroll-pane ui-widget ui-widget-header ui-corner-all" id="content">
            <div class="scroll-content" id="friendsList" style="height:691px;">
                <?php
                    if($arr["error"]["message"]=="非法的测试用户，无法调用接口。")
                    {
                      echo "<div id=\"errormessage\" style=\"margin-left: 95px;margin-top: 300px;\">抱歉，应用审核尚未通过，所以您还不能选择好友。耐心等待。。马上上线~</div>";
                    }else{
                    if (is_array($arr)){
      	               foreach($arr['response'] as $value)
      	                   {
  			                   echo "<div id=\"".$value['id']."box\" class=\"scroll-content-item ui-widget-header\"  onclick=\"selectUser(".$value['id'].",".$id_1.")\">";
  			                   echo "<img class=\"userhead\" src=\"";
  			                   echo $value['avatar'][0]['url']; 
  			                   echo "\">";
  			                   echo "<br><span class=\"username\">".$value['name']."</span>";
  			                   echo "</div>";
      	                    }
                    }
                  }
                ?> 
            </div>
            <div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
                <div class="scroll-bar"></div>
            </div>
        </div>
            <form id="resinfo" method="post" action="user_deal.php" onsubmit="gerFrdId()">
                <input type="hidden" id="token" name="token" value="<?php echo $token;?>"/>
                <input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
                <input type="hidden" id="city" name="city" value="<?php echo $city;?>" />
                <?php echo  "<input id =\"a\"type=\"text\" name=\"frm\" class=\"userid\" value=\"\">";?>
                <div class="banner" id="downright">
                <?php
                    if($arr["error"]["message"]=="非法的测试用户，无法调用接口。")
                    {
                      echo "<a style=\"CURSOR:hand;\" href=\"http://198.52.103.212/renren/united/\" />等等看</a>";
                    }else{
                ?>
                <a style="CURSOR:hand;" onclick="submit()"/>Next</a>
                <?php
                       }
                ?>
                </div>
            </form>
        <div id="daocha2" style="margin-top: -225px;margin-right: 44px;">
            <img src="image/daocha.png">
        </div>
    </div>
</body>
<script type="text/javascript">
function submit()
{
  var resinfo=document.getElementById("resinfo");
  resinfo.submit();

}

function changeColor(userid)
{
	   var color="#66CC33";
	var selected="#"+userid+"box";
	//alert('before');
	$(selected).css({ "background": color });
	//alert('green');
}

function colorBack(userid){
    var color="";
    var selected="#"+userid+"box";
    $(selected).css({ "background": color });
}

function selectUser(userId,id_1){
    var e=document.getElementById("a");
//    e.value=e.value+e.value.indexOf(userId);
    //上面语句显示，e.value.indexOf(userId)的值为-1
    //通过id找到input的位置
    
    if( e.value.indexOf(userId) == -1){
        //看是不是input里面已经含有该用户id
        e.value=e.value+userId+',';
        changeColor(userId);
        if(e.value.indexOf(id_1) == -1)
        {
            e.value=e.value+id_1+',';
        }
        //如果没有含有，那么在input位置加上新的id和逗号
 //       alert(userId+'have been added into invitation list');
 //       alert(name+"已经添加到邀请列表");
	}
	else{
	    e.value=e.value.replace(userId+',','');  
        //如果input已经含有了该id那么就把这个id从input里面除去
        colorBack(userId);
	}	 
}
function getFrdId(){
    return document.getElementById("a").value;
}
</script>
</html>