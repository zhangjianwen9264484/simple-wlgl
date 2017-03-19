<?php
	require "conn/conn.php";
	if(isset($_GET["id"])){
			$stmt = $pdo ->prepare("delete from customer where id = '$_GET[id]' ");
			$stmt ->execute();
			if($stmt ->rowcount() >0){
				echo "<script>alert('删除成功！');location.href='index.php?lmbs=客户信息管理';</script>";
			}else{
				echo "<script>alert('删除失败！');location.href='index.php?lmbs=客户信息管理';</script>";
			}
	}
?>