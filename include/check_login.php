<?php 
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	if(isset($_SESSION['valid']) && $_SESSION['valid'])
	{
		// user is logged in.
		$ul = true;
		$un = $_SESSION['user'];
		$uid = $_SESSION['uid'];
		//echo 'username:'.$un;
		$us = $_SESSION['super'];
	}
	else
	{
		// user is not logged in.
		$ul = false;
		$un = 'NOTLOGGEDIN';
		$uid = 'NOTLOGGEDIN';
	}
?>