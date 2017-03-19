<?php
	session_start();
	include "conn/conn.php";
	if(isset($_POST["submit"])){
		$sql = "select name,password from user";
		$stmt = $pdo -> prepare($sql);
		$stmt -> execute(); 
		$row =$stmt->fetch(PDO::FETCH_ASSOC);
		if(strtoupper($_SESSION['codes']) == strtoupper($_POST["codes"])){
			if($row["name"] == $_POST["user"]){
				if($row["password"] == $_POST['pw'] ){
					@$_SESSION["admin"] ='admin';
				echo "<script>alert('登陆成功！');location.href='index.php';</script>";
				}else{
			echo "<script>alert('密码错误，请重新输入！');location.href='login.php';</script>";
				}
			}else{
			echo "<script>alert('用户名错误，请重新输入！');location.href='login.php';</script>";
			}
		}else{
			echo "<script>alert('验证码错误，请重新输入！');location.href='login.php';</script>";
		}
	}
	//session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登陆</title>
	<style type="text/css">
	*{
		margin:0px;
		padding:0px;
		font-size:25px;
	}
	table{
		margin:180px auto;
		background-color:#1bbf63;
		padding:50px;
		line-height: 45px;
		color:#d47474;
	}
	input{
		width: 280px;
	}
	.button{
		width:100px;
		padding:5px;
		margin-left:55px;
		color: #1bc6f9;
	}
	</style>
</head>
<body>
	<table >
		<form action="login.php" method="post">
		<tr>
			<td>用户名:</td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>密 码</td>
			<td><input type="password" name="pw"></td>
		</tr>
		<tr>
			<td>验证码：</td>
			<td><input type="text" name="codes"></td>
		</tr>
		<tr>
			<td colspan="2"><img src="usevcode.php" style="width:150px;margin-left:110px;"alt="" onclick="this.src='usevcode.php?'+Math.random()"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="reset" class="button" value="重置">
				<input type="submit" class="button" name="submit" value="登陆">
			</td>
		</tr>
		</form>
	</table>
</body>
</html>