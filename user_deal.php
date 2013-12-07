<?php

	//$userid="232120114,240636336,250853896";   
	$userIds=$_POST["frm"];    
	$token=$_POST["token"]; 
	$city=$_POST["city"];    
	$id=$_POST["id"];   
	$userbatch="https://api.renren.com/v2/user/batch?access_token=".$token."&userIds=".$userIds;    
    	
    	//调取api获取已选择的好友信息
	$friend_info=file_get_contents($userbatch);
	$arr=json_decode($friend_info, TRUE);

	//echo "<pre>";
	//var_dump($arr);exit;
	//引入用户类文件
	require_once('People.php');
	
	//每个用户构造成新一个对象，存在list中，待用
	$peopleList=array();
	foreach ($arr['response'] as $value) {
		$i=0;
		$people=new People();
		$people->set_Id($i);
		$people->set_Uid($value['id']);
		$people->set_Name($value['name']);
		$people->set_Pic($value['avatar'][0]['url']);
		$people->set_College($value['education'][0]['name']);
		$i++;
		array_push($peopleList,$people);
	}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

<style type="text/css">
body, html,#allmap {width: 100%;height: 94%;overflow: hidden;margin:0;}
#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;margin-top: -65px;}
#r-result{height:100%;width:20%;float:left;}
</style>
<link href="css/default.css" rel="stylesheet">
<link href="css/user_deal.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Gorditas:700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.4/src/SearchInfoWindow_min.js"></script>
</head>
<body id="all">   
    <!--<div class="graph"> 
        <strong id="bar" style="width:1%;"></strong> 
    </div>-->  
	<div id="cover"></div>
	<div id="footer"></div>
    <div id="l-map"></div>
    <div id="result">
    <input type="text" id="keyword" style="display:none;" >
    <input type="submit" class="banner" id="range" onclick="setPolygon();" value="范围定位" >
    <input type="submit" class="banner" id="search" onclick="calPmid();" style="display:none;" value="Search" >
    <form id="resinfo" method="POST" action="shop_result.php">
		<input type="hidden" id="json" name="json"/>
		<input type="hidden" id="city" name="city" value="<?php echo $city;?>"/>
	</form>
	<div id="coverMap"> test</div>
</div>
</body>
</html>
<script type="text/javascript">
var EARTH_RADIUS = 6378137.0;    //单位M
var PI = Math.PI;
    
function getRad(d){
	return d*PI/180.0;
}

// 百度地图API功能
var map = new BMap.Map("l-map");
map.centerAndZoom(new BMap.Point(116.404, 39.915), 12);
var index = 0;
var myGeo = new BMap.Geocoder();
var arrLng = new Array();
var arrLat = new Array();
var adds = [
    <?php
    	foreach ($peopleList as $value) {
    		echo "\"".$value->p_College."\",";
    	}
    ?>
];
var namelist = [
    <?php
    	foreach ($peopleList as $value) {
    		echo "\"".$value->p_Name."\",";
    	}
    ?>
];
var avatarlist = [
    <?php
    	foreach ($peopleList as $value) {
    		echo "\"".$value->p_Pic."\",";
    	}
    ?>
];


bdGEO();

function bdGEO(){
    var add = adds[index];
    var name = namelist[index];
    var pic = avatarlist[index];
    geocodeSearch(add,name,pic);
    index++;
}

function geocodeSearch(add,name,pic){
    if(index < adds.length){
        setTimeout(window.bdGEO,500);
    } 
    myGeo.getPoint(add, function(point){
      if (point) {
        //document.getElementById("result").innerHTML +=  index + "、" + add + ":" + point.lng + "," + point.lat + "</br>";
        
		var avatar = new BMap.Icon(pic, new BMap.Size(50,50));
        var marker = new BMap.Marker(new BMap.Point(point.lng, point.lat),{icon:avatar});
        arrLng.push(point.lng);
		arrLat.push(point.lat);
        map.addOverlay(marker);
        var label = new BMap.Label(name,{offset:new BMap.Size(20,-10)});
		//marker.setLabel(label);
		marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
      }
    }, "<?php echo $city; ?>");
}
function $(obj){ 
    return document.getElementById(obj); 
} 
function go(){ 
    $("bar").style.width = parseInt($("bar").style.width) + 1 + "%"; 
    $("bar").innerHTML = $("bar").style.width; 
    if($("bar").style.width == "100%"){ 
    window.clearInterval(bar); 
    $("graph").style.display = 'none';
} 

} 
var bar = window.setInterval("go()",50); 
window.onload = function(){ 
    bar; 
} 

	
function calPmid()
{
	document.getElementById("search").style.display ="none";
	document.getElementById("keyword").style.display ="none";
	document.getElementById("l-map").style.height ="740px";
	arrLng.sort(function(a,b){return a>b?1:-1});//从小到大排序
	//alert(arrLng);
	arrLat.sort(function(a,b){return a>b?1:-1});//从小到大排序
	//alert(arrLat);
	//alert(arrLng[arrLng.length-1]-arrLng[0]+" "+arrLat[arrLat.length-1]-arrLat[0]);
	var Pmid=new BMap.Point((arrLng[arrLng.length-1]+arrLng[0])/2,(arrLat[arrLat.length-1]+arrLat[0])/2);
	var marker2 = new BMap.Marker(Pmid);  // 创建标注
	map.addOverlay(marker2);  
	map.centerAndZoom(Pmid, 12); 
	var local = new BMap.LocalSearch(map, {
	  renderOptions:{map: map, panel:"",autoViewport:true,selectFirstResult: false},onSearchComplete : function(results){
	  if (local.getStatus() == BMAP_STATUS_SUCCESS){ 
	  	var str=""
			str+="{";
			for (var i = 0; i < results.getCurrentNumPois(); i ++){ 
					var distance=0;
					for(var j=0;j<arrLng.length;j++)
					{
						distance+=getDistance(results.getPoi(i).point.lat,results.getPoi(i).point.lng,arrLat[j],arrLng[j]);
					}
				
				if(i==0)
				{
					str+="\""+i+"\":{\"name\":\""+results.getPoi(i).title+"\",\"distance\":"+"\""+distance.toString()+"\"}";
				}
				else{
					str+=",\""+i+"\":{\"name\":\""+results.getPoi(i).title+"\",\"distance\":"+"\""+distance.toString()+"\"}";
				}
			}  
			str+="}";
			 
			 //document.getElementById("log").innerHTML += str; 
			 document.getElementById("json").value +=str;
			 
		}else{
			document.getElementById("json").value ="null";
		}
		var resinfo=document.getElementById("resinfo");
			resinfo.submit();
		}
	});
	local.setPageCapacity(80);
	var obj=document.getElementById('keyword');
	var val=obj.value;
	local.searchNearby(val, Pmid);
}


function setPolygon()
{
	//.getElementById("result").innerHTML += arrLng[0];
	var arrBP=new Array();
	var Lng=arrLng[0];
	var Lat=arrLat[0];
	for(var i=0;i<arrLng.length;i++)
	{
		if(i>0)
		{
			if(arrLng[i]>Lng)
			{
				Lng=arrLng[i];
				Lat=arrLat[i];
				count=i;
				//alert(Lng+" "+Lat+" "+count);
			}
		}
	}
	var BPLeft=new BMap.Point(Lng,Lat);
	var arrRes=new Array();
	var arrSin=new Array();
	for(var j=0;j<arrLng.length;j++)
	{
		if((arrLng[j]!=Lng)&&(arrLat[j]!=Lat))
		{
			//alert(j);
			//getSin();
			var x=(arrLng[j]-Lng)*(arrLng[j]-Lng);
			var y=(arrLat[j]-Lat)*(arrLat[j]-Lat);
			var r=Math.sqrt(x+y);                 
			var sin=(arrLat[j]-Lat)/r;
			arrRes.push(sin,arrLng[j],arrLat[j]);
			arrSin.push(sin);
			//var r=;
			//alert(Math.sqrt2(9));
		}
	}
	arrSin.sort(function(a,b){return a<b?1:-1});//从大到小排序
	var poloPoint=new Array();
	poloPoint.push(BPLeft);
	for(var n=0;n<arrSin.length;n++)
	{
		for(var m=0;m<arrRes.length;m++)
		{
			if(arrSin[n]==arrRes[m])
			{
				//document.getElementById("result").innerHTML += "("+arrRes[m+1]+","+arrRes[m+2]+")"+"<br>";
				var BP=new BMap.Point(arrRes[m+1],arrRes[m+2]);
				poloPoint.push(BP);
			}
		}
	}
	var polygon = new BMap.Polygon(poloPoint, {strokeColor:"blue", strokeWeight:6, strokeOpacity:0.5});
	map.addOverlay(polygon);
	document.getElementById("search").style.display ="block";
	document.getElementById("keyword").style.display ="block";
	document.getElementById("range").style.display ="none";
}

function getDistance(lat1,lng1,lat2,lng2)
{
	var f = getRad((lat1 + lat2)/2);
	var g = getRad((lat1 - lat2)/2);
	var l = getRad((lng1 - lng2)/2);
	
	var sg = Math.sin(g);
	var sl = Math.sin(l);
	var sf = Math.sin(f);
	
	var s,c,w,r,d,h1,h2;
	var a = EARTH_RADIUS;
	var fl = 1/298.257;
	
	sg = sg*sg;
	sl = sl*sl;
	sf = sf*sf;
	
	s = sg*(1-sl) + (1-sf)*sl;
	c = (1-sg)*(1-sl) + sf*sl;
	
	w = Math.atan(Math.sqrt(s/c));
	r = Math.sqrt(s*c)/w;
	d = 2*w*a;
	h1 = (3*r -1)/2/c;
	h2 = (3*r +1)/2/s;
	
	return d*(1 + fl*(h1*sf*(1-sg) - h2*(1-sf)*sg));
}

</script>
