<?php
	require "conn/conn.php";
	//session_start();
	if (isset($_POST["submit"])) {
			$stmt  = $pdo ->prepare("select * from user");
			$stmt -> execute();
			$arr = $stmt ->fetch(PDO::FETCH_ASSOC);
			if (strtoupper($_SESSION["codes"]) == strtoupper($_POST["code"]) ) {
			
				if($_POST["old_password"] == $arr["password"]){
					
					if($_POST["new_password"] == $_POST["ok_password"]){
							$stmt = $pdo ->prepare("update user set password ='$_POST[new_password]' where password ='$_POST[old_password]' ");
							$stmt ->execute();
							if($stmt ->rowcount() >0){
								echo "<script>alert('密码修改成功！');</script>";
							}else{
								echo "<scriprt>alet('密码修改失败');</scriprt>";
							}
					}else{
						echo "<script>alert('两次密码不一致，请重新输入')</script>";
					}
				}else{
					echo "<script>alert('原始密码错误，请重新输入')</script>";
				}
			}else{
					echo "<script>alert('验证码错误，请重新输入')</script>";		
			}
	}
	//session_destroy();
?>

<table cellspacing="0" border="1" style="margin-top:30px;text-align:center;">
	<form action="" method="post" >
		<tr>
			<td colspan="2">修改管理员密码</td>
		</tr>
		<tr>
			<td style="width:200px;">管理员</td>
			<td><input type="text" name="admin_name" style="float:left"></td>
		</tr>
		<tr>
			<td>原始密码</td>
			<td style="width:480px;"><input type="password" name="old_password" style="float:left"></td>
		</tr>
		<tr>
			<td>新密码</td>
			<td><input type="password" name="new_password" style="float:left"></td>
		</tr>
		<tr>
			<td>确认密码</td>
			<td><input type="password" name="ok_password" style="float:left"></td>
		</tr>
		<tr>
			<td>验证码</td>
			<td>
				<input type="text" name="code" style="float:left">
				<img align="left" src="usevcode.php" alt="" onclick="this.src= 'usevcode.php?'+Math.random()">
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="submit" value="提交" style="float:left">
			</td>
		</tr>
	</form>
</table>