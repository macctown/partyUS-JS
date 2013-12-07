<?php
	Class Business{
		var $b_Id="";	
		var $b_Name="";
		var $b_Address="";
		var $b_Avg_Star="";
		var $b_Pic="";
		var $b_Coupon=array();
		var $b_Score="";
		var $b_Url="";
		var $b_Distance="";
		var $b_Product_Star="";
		var $b_Service_Star="";
		var $b_Decoration_Star="";
		var $b_Review_Count="";
		var $b_Deal=array();
		
		function set_Decoration_Star($dstar)
		{
			$this->b_Decoration_Star=$dstar; 
		}
		
		function get_Decoration_Star()
		{
			return $this->b_Decoration_Star;
		}

		function set_Deal($deal)
		{
			$this->b_Deal=$deal; 
		}
		
		function get_Deal()
		{
			return $this->b_Deal;
		}

		function set_Review_Count($review)
		{
			$this->b_Review_Count=$review; 
		}
		
		function get_Review_Count()
		{
			return $this->b_Review_Count;
		}

		function set_Service_Star($sstar)
		{
			$this->b_Service_Star=$sstar; 
		}
		
		function get_Service_Star()
		{
			return $this->b_Service_Star;
		}

		function set_Product_Star($pstar)
		{
			$this->b_Product_Star=$pstar; 
		}
		
		function get_Product_Star()
		{
			return $this->b_Product_Star;
		}

		function set_Id($id)
		{
			$this->b_Id=$id; 
		}
		
		function get_Id()
		{
			return $this->b_Id;
		}
		
		function set_Name($name)
		{
			$this->b_Name=$name; 
		}
		
		function get_Name()
		{
			return $this->b_Name;
		}
		
		function set_Address($address)
		{
			$this->b_Address=$address; 
		}
		
		function get_Address()
		{
			return $this->b_Address;
		}
		
		function set_Avg_Star($star)
		{
			$this->b_Avg_Star=$star; 
		}
		
		function get_Avg_Star()
		{
			return $this->b_Avg_Star;
		}
		
		function set_Pic($pic)
		{
			$this->b_Pic=$pic; 
		}
		
		function get_Pic()
		{
			return $this->b_Pic;
		}
		
		function set_Coupon($coupon)
		{
			$this->b_Coupon=$coupon; 
		}
		
		function get_Coupon()
		{
			return $this->b_Coupon;
		}
		
		function set_Score($score)
		{
			$this->b_Score=$score; 
		}
		
		function get_Score()
		{
			return $this->b_Score;
		}
		
		function set_Url($url)
		{
			$this->b_Url=$url; 
		}
		
		function get_Url()
		{
			return $this->b_Url;
		}
		
		function set_Distance($dis)
		{
			$this->b_Distance=$dis; 
		}
		
		function get_Distance()
		{
			return $this->b_Distance;
		}
	}
?>