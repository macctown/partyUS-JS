<?php
	//获取提交来的json格式数据，包含商家名字、地点和距离
	$json=$_REQUEST["json"];
	$city=$_REQUEST["city"];
	if($json!="null"){
	//去掉json中多余字符
	$json=str_replace("\\\"", "\"", $json);

	//解码json
	$data=json_decode($json,true);

	//引入商家类文件
	require_once('Business.php');
	
	//遍历并调用大众点评api获取商家信息--需改为一次性获取，减少api获取次数
	$shopArray=array();
	for($i=0;$i<count($data);$i++)
	{
		$shop=new Business;
		$shop=dianpingCall($i,$data[$i]['distance'],$data[$i]['name'],$city);
		array_push($shopArray,$shop);
	}
	

	$shopArray=_multi_array_sort($shopArray,"b_Distance",SORT_ASC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}

	$shopArray=_multi_array_sort($shopArray,"b_Product_Star",SORT_DESC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}

	$shopArray=_multi_array_sort($shopArray,"b_Service_Star",SORT_DESC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}

	$shopArray=_multi_array_sort($shopArray,"b_Decoration_Star",SORT_DESC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}

	$shopArray=_multi_array_sort($shopArray,"b_Avg_Star",SORT_DESC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}

	$shopArray=_multi_array_sort($shopArray,"b_Review_Count",SORT_DESC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}


	foreach($shopArray as $value)
	{
		if($value->b_Deal['deal_exist']==1)
		{
			$value->b_Score+=5;
		}
	}

	foreach($shopArray as $value)
	{
		if($value->b_Coupon['has_coupon']==1)
		{
			$value->b_Score+=10;
		}
	}

	foreach($shopArray as $value)
	{
		$value->b_Score*=1.3;
	}

	$shopArray=_multi_array_sort($shopArray,"b_Score",SORT_DESC);
	$j=10;
	for($i=0;$i<10;$i++)
	{
		$shopArray[$i]->b_Score+=$j;
		$j--;
	}
}else{

	$shopArray=array();
}

	//显示获取到的商家信息
	//foreach($shopArray as $key=>$value)
	//{
	//	echo "<br>".$key.":<br>";
	//	foreach($value as $k=>$v)
	//	{
	//		echo "|-".$k.":".$v."<br>";
	//	}
	//} 


	/**
	 * 调用大众点评api获取商家信息
	 *
	 * @params	str		$name		商家名字
	 * @params	str		$need		想获取的信息类型1：星级、2：高清图片链接、3：评分、4：团购地址、5：商家链接、6：小图片链接
	 * @params	str		$city		所在城市
	 * @params	str		$type		商家类型
	 * @return	obj	
	 *
	 * @author Zhangwei
	 * @date 2013-10-25
	 */
	function dianpingCall($id,$distance,$name,$city='北京')
	{
		 // 定义申请获得的appKey和appSecret
		 $appkey = "43110682";
		 $secret = "5c9c211e9d7144d591159836152bee72";
		 $apiUrl = "http://api.dianping.com/v1/business/find_businesses";
		
		 // 签名算法如下： 
			// 1. 对除appkey以外的所有请求参数进行字典升序排列； 
			// 2. 将以上排序后的参数表进行字符串连接，如key1value1key2value2key3value3...keyNvalueN； 
			// 3. 将app key作为前缀，将app secret作为后缀，对该字符串进行SHA-1计算，并转换成16进制编码； 
			// 4. 转换为全大写形式后即获得签名串 
	
		$condition_url='city'.$city.'formatjsonkeyword'.$name.'limit1platform1';
		$secret=$appkey.$condition_url.$secret;
		$secret=sha1($secret,false);
		$secret=strtoupper($secret);
		$base_url='http://api.dianping.com/v1/business/find_businesses?&appkey=43110682&sign='.$secret.'';
		$urlcity=urlencode($city);
		$urlname=urlencode($name);
		$condition_url='&city='.$urlcity.'&format=json&keyword='.$urlname.'&limit=1&platform=1';


		// 运行cURL，请求API
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $base_url.$condition_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
		$data = curl_exec($ch);
		curl_close($ch);
		
		$data=json_decode($data,true);

		$shop=new Business;
		$shop->set_Id($id);
		$shop->set_Score(0);
		$shop->set_Name($name);
		$shop->set_Distance($distance);
		$shop->set_Avg_Star($data['businesses'][0]['avg_rating']);
		$shop->set_Pic($data['businesses'][0]['photo_url']);
		$shop->set_Coupon(array("coupon_exist"=>$data['businesses'][0]['has_coupon'],"coupon_des"=>$data['businesses'][0]['coupon_description'],"coupon_url"=>$data['businesses'][0]['coupon_url']));
		$shop->set_Url($data['businesses'][0]['business_url']);
		$shop->set_Product_Star($data['businesses'][0]['product_grade']);	
		$shop->set_Service_Star($data['businesses'][0]['service_grade']);
		$shop->set_Decoration_Star($data['businesses'][0]['decoration_grade']);
		$shop->set_Review_Count($data['businesses'][0]['review_count']);
		$shop->set_Deal(array("deal_exist"=>$data['businesses'][0]['has_deal'],"deal_des"=>$data['businesses'][0]['deals.description'],"deal_url"=>$data['businesses'][0]['deals.url']));

		return $shop;
	}

	function _multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC) {
		
		foreach ($multi_array as $row_array) {
			$key_array[] = $row_array->$sort_key;
		}
		array_multisort($key_array, $sort, $multi_array);
		return $multi_array;
	}

?>
