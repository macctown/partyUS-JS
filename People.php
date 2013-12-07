<?php
	Class People{
		var $p_Id="";
		var $p_Uid="";	
		var $p_Name="";
		var $p_College="";
		var $p_Pic="";
		
		function set_Id($id)
		{
			$this->p_Id=$id; 
		}
		
		function get_Id()
		{
			return $this->p_Id;
		}

		function set_Uid($uid)
		{
			$this->p_Uid=$uid; 
		}
		
		function get_Uid()
		{
			return $this->p_Uid;
		}
		
		function set_Name($name)
		{
			$this->p_Name=$name; 
		}
		
		function get_Name()
		{
			return $this->p_Name;
		}
		
		function set_College($college)
		{
			$this->p_College=$college; 
		}
		
		function get_College()
		{
			return $this->p_College;
		}
		
		function set_Pic($pic)
		{
			$this->p_Pic=$pic; 
		}
		
		function get_Pic()
		{
			return $this->p_Pic;
		}
	}
?>