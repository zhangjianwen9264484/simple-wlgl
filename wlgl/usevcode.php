<?php
	//include 'vcode.class.php';
	include "verify.class.php";//优化一点
	$vcode = new Vcode(80,20,4);
	$vcode ->outimg();
?>