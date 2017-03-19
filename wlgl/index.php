<?php
	session_start();
	include "conn/conn.php";
	if(!isset($_SESSION["admin"])){
		echo "<script>alert('请先登录！');location.href='login.php';</script>";
	}
	if(isset($_POST["Exit"])){
		echo "<script>alert('退出成功!');location.href='login.php';</script>"; 
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>物流配送信息网</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="body">
		<div class="header">
			<div class="login">
				<form action="" method="post">
					<input type="button" value="加入收藏" class="button">
					<input type="submit"  name="Exit" value="退出登录" class="button" >
				</form>
			</div>
			<div class="flash"></div>
		</div>
		<div class="conter">
			<div class="left">
				<ul>
					<li style="margin-top:30px;"><a href="index.php?lmbs=车源信息查询">车源信息查询</a></li>
					<li><a href="index.php?lmbs=发货单">发货单</a></li>
					<li><a href="index.php?lmbs=回执发货确认">回执发货单确认</a></li>
					<li><a href="index.php?lmbs=发货单查询">发货单查询</a></li>
					<li><a href="index.php?lmbs=客户信息管理">客户信息管理</a></li>
					<li><a href="index.php?lmbs=车源信息管理">车源信息管理</a></li>
					<li><a href="index.php?lmbs=修改密码">修改密码</a></li>
				</ul>
			</div>
			<div class="right">
				<?php
					$lmbs = @$_GET["lmbs"];
					switch ($lmbs) {
						case "车源信息查询":
							include "car_select.php";
							break;
						case "发货单":
							include "Invoice_add.php";
						 	break;
						case '回执发货确认':
							include "Receipt_management.php";
							break;
						case '发货单查询':
							include "Invoice_select.php";
							break;
						case '客户信息管理';
						 	include "customer.php";
						 	break;
						case '车源信息管理':
							include "car_management.php";
							break;
						case '修改密码':
							include "admin.php";
							break;
						default:
							include "car_select.php";
							break;
					}
				?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
</body>
</html>